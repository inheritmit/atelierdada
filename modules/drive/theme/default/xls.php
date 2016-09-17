<?php
	if(!isset($req['slug']) || empty($req['slug'])) {
		_error('404');
		exit;
	}
	
	$filedata = $drvObj->getItemByTime($req['slug']);
		
	$upload_path = SITE_URL."modules/drive/upload/drive/".$filedata['userId']."/";
	$convert_path = $upload_path."/converted/";
	if($filedata['folder'] != 0) {
		$upload_path .= $filedata['folderStorageName'].'/';
	}
	
	$filepath = $upload_path.$filedata['storageName'];
	$ext = pathinfo($filepath, PATHINFO_EXTENSION);
	
	/*if(in_array($ext, array_keys($convertTypes))) {
		$outputFileName = str_replace('.'.$ext, '.pdf', $filedata['storageName']);
		$filepath = $convert_path.$outputFileName;
	}
	
	$data = file_get_contents($filepath);*/
?>
<iframe src = "/ViewerJS/#<?php _e($filepath);?>" width='800' height='600' allowfullscreen webkitallowfullscreen></iframe>