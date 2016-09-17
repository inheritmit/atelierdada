<?php 
	$site_root = './';
	
	include_once($site_root.'include.php'); //echo $template; exit;
	
	//echo $module_path;
	
	// load controller file
	if(file_exists($module_path.'/controller.php')) {
		include_once($module_path.'/controller.php');
	} else {
		die('controller not available');
	}

    //pr($req); exit;

    if(isset($req['auth']) && $req['auth'] === true) {
        include_once(SITE_PATH.'include/authenticate.php');
    }
	
	//echo $layout_path; exit;
    // echo $template; exit;
	
	// load layout file
	if(!empty($layout_path) && file_exists($layout_path)) {
		include_once($layout_path);
	} else if(!empty($template) && file_exists($template)) {
		include_once($template);
	} else {
		die('Layout not available');
	}
	exit;