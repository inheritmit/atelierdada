<?php


	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    if($_POST['action'] == 'send-reset-instructions') {

			$email = strip_tags($_POST['email']);
			$account = $account_obj->getAccount("strEmail = '".$email."'"); //print_r($account); exit;
			
			if($account == 404){
				$_SESSION[PF.'ERROR']= "Ooops! ".$_POST['email']." is not registered with us";
				_locate(SITE_URL.'account/forgot-password');
			} else {

                _class('emailer');
                $emailObj = new emailer();

                _class('String');

				$token = String::generateCode(32);
				
				$data = array('token' => $token,
							  'vId' => $account['id'],
							  'sendDate' => TODAY_DATETIME);

				$account_obj->addResetToken($data);
				
				//$reset_url = SITE_URL.'account/reset-password?email='.$account['strEmail'].'&token='.$token;
				$reset_url = $module_url.'/reset-password?email='.$account['strEmail'].'&token='.$token;

				$edata = array('email' => $account['strEmail'],
							   'fullname' => $account['strFirstName'].' '.$account['strLastName'],
							   'reset_url' => $reset_url,
							   'subject' => SITE_REPRESENT_TITLE.' : Reset your account password');
				$emailObj->sendMail('reset-password', $edata);
				
				$_SESSION[PF.'MSG'] = 'Reset password instructions email has been successfully sent';

				_locate(SITE_URL.'account/login');
			}
		}
		if($_POST['action'] == 'reset-password') {
			$error = '';
			if(empty($_POST['password'])) {
				$error = 'Please enter new password';
			} else if(strlen($_POST['password']) < 8 || strlen($_POST['password']) > 16) {
				$error = 'Password must be 8 to 16 chars long';
			} else if($_POST['password'] != $_POST['confirm_password']) {
				$error = 'Password and Confirm Password must be same';
			}
			
			if(!empty($error)) {
				$_SESSION[PF.'ERROR'] = $error;
				_locate($_POST['referer']);
			}
			
			$password = String::getHash($_POST['password']);
			$data = array('strPassword' =>  $password);
			$account_obj->updateAccount($data, "id = '".$_POST['accountId']."'");
			
			//$account_obj->removeToken("id = ".$_POST['token_id']);
			 $_SESSION[PF.'MSG'] = 'Your password has been successfully reset. You can login to your account now using new password.';
			//_locate(SITE_URL);
			_locate(SITE_URL.'account/login');
		}
		if($_POST['action'] == 'set-password') {
			$error = '';
			if(empty($_POST['password'])) {
				$error = 'Please enter new password';
			} else if(strlen($_POST['password']) < 8 || strlen($_POST['password']) > 16) {
				$error = 'Password must be 8 to 16 chars long';
			} else if($_POST['password'] != $_POST['confirm_password']) {
				$error = 'Password and Confirm Password must be same';
			}
			
			if(!empty($error)) {
				$_SESSION[PF.'ERROR'] = $error;
				_locate($_POST['referer']);
			}
			
			$password = String::getHash($_POST['password']);
			$data = array('strPassword' =>  $password,
						  'tinStatus' => '1',
						  'strActivation' => '');
			$account_obj->updateAccount($data, "id = ".$_POST['ID']);
			
			$_SESSION[PF.'MSG'] = 'Your password has been successfully set. You can login to your account now using this password.';
			_locate($module_url.'/login');
		}
	}else{
		include_once(SITE_PATH.'errors/404');
	}
?>