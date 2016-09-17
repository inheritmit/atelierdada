<?php
	$upload_path = $module_upload_path . '/' . $_SESSION['USERID'] . '/';
	
	$convert_path = $upload_path."converted/";
	
	$folder = 0;
	if(isset($_POST['f']) && $_POST['f'] != 0) {
		$f = $drvObj->getItemByStorageName($_POST['f'], $_SESSION['USERID']);
		
		if($f != 404) {
			$folder = $f['storageName'];
			$upload_path .= $folder . '/';
		}
	}
	
	if(!file_exists($upload_path))
		mkdir($upload_path, 0777);
		
	function checkSum($filename) {
		$sha1 = sha1($filename);
		$number = preg_replace("/[^0-9,.]/", "", $sha1);
		$code = substr($number, 5, 16);
		return $code;
	}
	
	function storageName($filename, $size) {
		$code = checkSum($filename);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$new_file = $code.'_'.TIME.'_'.$size.'.'.$ext;
		return $new_file;
	}
	
	$filename = $_FILES['Filedata']['name'];
	$checksum = checkSum($filename);
	
	$size = $_FILES['Filedata']['size'];
	
	$storagename = storageName($filename, $size);
	$file = $upload_path . $storagename;
	
	if($size > (1048576*10)) {
		echo "error file size > 10 MB";
		unlink($_FILES['Filedata']['tmp_name']);
		exit;
	}
	
	if(!file_exists($file)) {
		if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $file)) {
		
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$fileType = finfo_file($finfo, $file); 
			finfo_close($finfo);
			
			// Convert file to PDF
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			
			if(in_array($ext, array_keys($convertTypes))) {
				$fileType = $convertTypes[$ext];
				
				$outputFileName = str_replace('.'.$ext, '.pdf', $storagename);
				
				$outputFile = $convert_path.$outputFileName;
				$outputType = "application/pdf";
			
				_class('convert');
				$convertObj = new convert();
				
				$outputData = $convertObj->convert(file_get_contents($file), $fileType, $outputType);
				file_put_contents($outputFile, $outputData);
			}
		
		 	$file_array = array('file_name' => $filename,
								'type' => 'file',
								'storage' => $storagename,
								'checksum' => $checksum,
								'size' => $size,
								'folder' => isset($f['id']) ? $f['id'] : 0,
								'mime' => $fileType,
								'user_id' => $_SESSION['USERID']); //print_r($file_array);
		  	$drvObj->addItem($file_array);
			
			_class('logs');
			$logObj = new logs();
			
			$log = array('userId' => $_SESSION['USERID'],
						 'logText' => '{$username} has uploaded new file',
						 'type' => 'file');
			$logObj->insertData($log);
		  
		  	echo $filename;
		} else {
		 	echo 'ERROR';
		}
	}
?>