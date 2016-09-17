<?php
	require_once($module_path.'/class/account.class.php');
	include_once(SITE_PATH.'/emailer/class/emailer.class.php');
	$emailObj = new emailer();
	$account_obj = new account();
	
	if(!isset($_GET['hash']) || empty($_GET['hash'])) {
		include_once(SITE_PATH.'errors/404.php');
	}
	
	$data = $account_obj->getAccount("sha1(concat('".PASSWORD_HASH."', strEmail)) = '".$_GET['hash']."'");
	
	if(!is_array($data)) {
		include_once(SITE_PATH.'errors/404.php');
	} else {
		$edata = array('email' => $data['strEmail'],
					   'fullname' => $data['strFullName'],
					   'verification_code' => $data['validationCode'],
					   'verification_url' => SITE_URL.'account/verify?hash='.$account_obj->hashEmail($data['strEmail']),
					   'subject' => SITE_REPRESENT_TITLE.' : Please verify your account');
		$emailObj->sendMail('verification', $edata);
		
		$_SESSION[PF.'MSG'] = 'Verification email has been successfully sent';
		
		_locate(SITE_URL."account/verify?hash=".$account_obj->hashEmail($_POST['email']));
	}