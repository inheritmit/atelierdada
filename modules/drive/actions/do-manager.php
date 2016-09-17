<?php	
	function checkSum($filename) {
		$sha1 = sha1($filename);
		$number = preg_replace("/[^0-9,.]/", "", $sha1);
		$code = substr($number, 5, 16);
		return $code;
	}
	
	function storageName($filename, $size, $dir = false) {
		$code = checkSum($filename);
		$new_file = $code.'_'.TIME.'_'.$size;
		
		if($dir == false) {
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$new_file .= '.'.$ext;
		}
		
		return $new_file;
	}
	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		
		if(isset($_POST['action']) && $_POST['action'] == 'create-folder') {
			
			$size = rand(10000, 99999);
			$checksum = checkSum($_POST['folder_name']);
			$storagename = storageName($_POST['folder_name'], $size, true);
			
			if(!file_exists($module_upload_path.'/'.$_SESSION['USERID'].'/'.$storagename)) {
				mkdir($module_upload_path.'/'.$_SESSION['USERID'].'/'.$storagename, 0777);
			}
			
			$file_array = array('file_name' => $_POST['folder_name'],
								'type' => 'folder',
								'storage' => $storagename,
								'checksum' => $checksum,
								'size' => $size,
								'folder' => 0,
								'mime' => '',
								'user_id' => $_SESSION['USERID']);
		  	$rsData = $drvObj->addItem($file_array);
			
			if($rsData){
				$_SESSION['MANAGE-MSG']  = "<strong>".$_POST['folder_name']."</strong> has been successfully created"; 		     		  
			} else {
				$_SESSION['MANAGE-ERR']  = "Error while inserting data";
			}
		}
		
		?>
        <script src="<?php _e($theme_url);?>js/jquery.js"></script>
        <script type="text/javascript">
		parent.$('a#dataLoad').trigger('click'); self.parent.tb_remove();
		</script>
        <?php
	}
?>