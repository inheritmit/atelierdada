<?php
	if(!isset($req['slug']) || empty($req['slug'])) {
		_error('404');
		exit;
	}
	
	$filedata = $drvObj->getItemByTime($req['slug'], $_SESSION['USERID']);
		
	$upload_path = $module_upload_path."/".$_SESSION['USERID']."/";
	if($filedata['folder'] != 0) {
		$upload_path .= $filedata['folderStorageName'].'/';
	}
	
	$filepath = $upload_path.$filedata['storageName'];
	
	header("Content-Type: ".$filedata['mimeType']);
	// change, added quotes to allow spaces in filenames, by Rajkumar Singh
	header("Content-Disposition: inline; filename=\"".$filedata['fileName']."\";" );
	header("Content-Length: ".filesize($filepath));
	header('Accept-Ranges: bytes');
	@readfile($filepath);
	exit();
?>