<?php
    $user_name = $_POST['username'];
	$user_password = String::getHash($_POST['password']);

	$login_data = $account_obj->checkLogin($user_name, $user_password); //print_r($login_data); exit;
	$session_data = $login_data;
	if($login_data == 404) {
		$_SESSION[PF.'ERROR'] = 'Username or password is wrong';
		_locate($module_url.'/login');
		exit;
	} else {
		$_SESSION[PF.'MAIN'] = session_id();
		$_SESSION[PF.'USERID'] = $session_data['id'];
		$_SESSION[PF.'NAME'] = $session_data['strFirstName'].' '.$session_data['strLastName'];
		$_SESSION[PF.'DESGID'] = $session_data['idDesg'];
		
		$page = SITE_URL.'account/dashboard';
		if(isset($_POST['r']) && !empty($_POST['r'])) {
			$page = $_POST['r'];
		}
		
		$account_obj->loginLog();
		
		_locate($page);
	}