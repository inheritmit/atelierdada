<?php
	_module('drive');
	$drvObj = new drive(); //echo 'in controller'; exit;
	
	$drvObj->init();
	
	$convertTypes = array('doc' => 'application/msword', 
						  'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
						  'xls' => 'application/vnd.ms-excel', 
						  'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
						  'ppt' => 'application/vnd.ms-powerpoint', 
						  'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
	
	if(isset($req['parent']) && in_array($req['parent'], array('popup-close', 'add-folder', 'file'))) {
		$layout = loadLayout('only-body');
	}
	
	if(isset($req['parent']) && in_array($req['parent'], array('file-view', 'image-view', 'pdf'))) {
		$layout = loadLayout('no-html');
	}
?>