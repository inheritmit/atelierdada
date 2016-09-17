<?php 
	_module('account');
	$account_obj = new account(); //print_r($_COOKIE); print_r($_SESSION);
	
	if(isset($_COOKIE['NKCOOKIE']) && !isset($_SESSION[PF.'USERID'])) { //exit;
	
		$user_id = $_COOKIE['NKCOOKIE'];
				
		$login_data = $account_obj->getAccount("id = ".$user_id); //print_r($login_data); exit;
		$session_data = $login_data;
		
		if($login_data != 404) {
			$_SESSION[PF.'MAIN'] = session_id();
			$_SESSION[PF.'USERID'] = $session_data['id'];
			$_SESSION[PF.'NAME'] = $session_data['strFirstName'].' '.$session_data['strLastName'];
			$_SESSION[PF.'DESGID'] = $session_data['idDesg'];
			
			$account_obj->makeUserOnline(1);
			$account_obj->loginLog();

			_locate(SITE_URL);
		}
	}
?>