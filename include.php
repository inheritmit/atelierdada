<?php
	@session_start();
	@set_time_limit(0);
	@date_default_timezone_set('Asia/Kolkata');
	
	define('HOME_DIR', basename(dirname(__FILE__)));
	define('SITE_PATH', realpath(dirname(__FILE__)).'/');
	define('MOD_PATH', realpath(dirname(__FILE__)).'/modules/');
    define('ASSET_PATH', realpath(dirname(__FILE__)).'/assets/');
	
	set_include_path(implode(PATH_SEPARATOR, array(
		realpath(SITE_PATH . '/lib'),
		get_include_path(),
	)));
	
	define('FPDF_FONTPATH', SITE_PATH . '/lib/fpdf/fpdf-font/');

	require_once(SITE_PATH.'include/core.php');
	require_once(SITE_PATH.'include/config.php');
	require_once(SITE_PATH.'include/db-config.php');
	require_once('functions.php');
	_class('setting');
	
	$setting = new setting();
	$setting->loadConstants();
	
	$globals = $setting->loadVariables();
	if($globals != 404) {
		foreach($globals as $global) {
			$$global['string'] = $global['value'];
		}
	}
	
	define('SITE_HOST',	'http://'.$_SERVER['HTTP_HOST']);
	define('SITE_URL', SITE_HOST.'/'.HOME_DIR.'/');
    define('ASSET_URL', SITE_URL.'assets/');

    define('UPLOAD_PATH', SITE_PATH.'file-manager/');
    define('UPLOAD_URL', SITE_URL.'file-manager/');
	
	require_once(SITE_PATH.'include/email-config.php');
	require_once(SITE_PATH.'include/myPagingHTML.php');
	
	require_once('classes/route.class.php');
	require_once(SITE_PATH.'include/routes.php');
	
	$db = new db_class;

    _class('String');
    _class('Date');
    _class('File');

    // Load page module
    _module('content');
    $cont_obj = new content();
	
	// Load main account module
	_module('account');
	$account_obj = new account();
	
	if(isset($_SESSION[PF.'USERID'])) {
		$account_details = $account_obj->getAccountByID($_SESSION[PF.'USERID']);
		
		if(isset($account_details['idDesg']) && is_numeric($account_details['idDesg']) && $account_details['idDesg'] != 0) {
			$account_obj->getAccessRights($account_details['idDesg']);
		}

	}
	//exit;
?>