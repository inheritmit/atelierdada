<?php
	if(!isset($req['slug']) || empty($req['slug'])) {
		_error('404');
		exit;
	}
	
	$filedata = $drvObj->getItemByTime($req['slug']);
		
	$upload_path = $module_upload_path."/".$filedata['userId']."/";
	$convert_path = $upload_path."/converted/";
	if($filedata['folder'] != 0) {
		$upload_path .= $filedata['folderStorageName'].'/';
	}
	
	$filepath = $upload_path.$filedata['storageName'];
	$ext = pathinfo($filepath, PATHINFO_EXTENSION);
	
	if(in_array($ext, array_keys($convertTypes))) {
		$outputFileName = str_replace('.'.$ext, '.pdf', $filedata['storageName']);
		$filepath = $convert_path.$outputFileName;
	}
	
	header("Content-Type: application/pdf");
	// change, added quotes to allow spaces in filenames, by Rajkumar Singh
	header("Content-Disposition: inline; filename=\"".$filedata['fileName']."\";" );
	header("Content-Length: ".filesize($filepath));
	header('Accept-Ranges: bytes');
	@readfile($filepath);
	exit();
?>