<?php
	if(isset($req['slug']) && !empty($req['slug'])) {
		$file = $drvObj->getItemByTime($req['slug'], $_SESSION['USERID']);
		
		if($file == 404) {
			_error(404);
			exit;
		}
		
		$upload_path = $module_upload_path."/".$_SESSION['USERID']."/";
		if($file['folder'] != 0) {
			$upload_path .= $file['folderTime'].'/';
		}
		
		if(!file_exists($upload_path.$file['storageName'])) {
			_error(302);
			exit;
		}
	}
?>
<?php /*?><h3 class="drive-title"><i class="fa fa-archive"></i> <a href="<?php _e($module_url);?>/my">My Documents</a><?php if($file['folder'] != 0) { ?> <i class="fa fa-caret-right"></i> <a href="<?php _e($module_url);?>/my#folder/<?php _e($file['folderTime']);?>"><?php _e($file['folderName']);?></a><?php } ?></h3><?php */?>
<section class="panel">
  <?php /*?><header class="panel-heading"><?php _e($file['fileName']);?></header><?php */?>
  <embed width="100%" height="700px" src="<?php _e($module_url.'/file-view/'.$file['fileTime']);?>" type="application/pdf">
</section>
<?php //include_once('drive-footer.php');?>