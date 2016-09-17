<?php
	error_reporting(0);
	
	if(!isset($_GET['f']) && empty($_GET['f'])) {
		_error(404);
		exit;
	}
	
	$file = $drvObj->getItemByTime($_GET['f'], $_SESSION['USERID']);
		
	if($file == 404) {
		_error(404);
		exit;
	}
	
	$upload_path = $module_upload_path."/".$_SESSION['USERID']."/";
	if($file['folder'] != 0) {
		$upload_path .= $file['folderTime'].'/';
	}
	
	$convert_path = $upload_path."/converted/";
	
	if(!file_exists($convert_path))
		mkdir($convert_path, 0777);
	
	$inputFile = $upload_path.$file['storageName'];
	
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$inputType = finfo_file($finfo, $inputFile);
	finfo_close($finfo);
	
	if(!file_exists($inputFile)) {
		_error(302);
		exit;
	}
	
	$ext = pathinfo($inputFile, PATHINFO_EXTENSION);
	$outputFileName = str_replace('.'.$ext, '.pdf', $file['storageName']);
	
	if(in_array($ext, array_keys($convertTypes))) {
		$inputType = $convertTypes[$ext];
	}
	
	$outputFile = $convert_path.$outputFileName;
	$outputType = "application/pdf";

	_class('convert');
	$convertObj = new convert();
	
	$outputData = $convertObj->convert(file_get_contents($inputFile), $inputType, $outputType);
	file_put_contents($outputFile, $outputData);
	
	setLocation($_SERVER['HTTP_REFERER']);
?>