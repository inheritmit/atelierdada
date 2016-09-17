<?php
	if(empty($template)) echo $template = SITE_PATH.'modules/account/theme/'.$theme.'/login.php';exit;
	
	//_class('abcd');
	
	if(isset($_GET['r']) && !empty($_GET['r'])) {
		_module('account');
		$account_obj = new account();
		
		$checkAccount = $account_obj->getAccount("sha1(concat('".PASSWORD_HASH."', id)) = '".$_GET['r']."'");
		
		if(!is_array($checkAccount) && $checkAccount == 404) {
			$template = SITE_PATH.'errors/404.php';
		}
	}
	
	if(isset($req['parent']) && in_array($req['parent'], array('popup-close'))) {
		$layout_path = _layout('only-body');
	}
	
	_module('default');
	$dftObj = new defaultclass();
	
	if(isset($req['parent']) && $req['parent'] == 'add' && $req['action'] != 'manage') {
		$layout_path = _layout('only-body');
	}
?>