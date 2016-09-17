<?php
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		
		if($_POST['action'] == 'signup') {
			
			$data = $_POST;
			
			$password = sha1(PASSWORD_HASH.$_POST['password']); 
			$activation = rand(10000000, 99999999);
			
			$data['password'] = $password;
			$data['activation'] = $activation;
			$regId = $account_obj->registerAccount($data);
			
			// Send mail to administrator
			_class('emailer');
			$emailObj = new emailer();
			
			$edata = array('email' => $_POST['email'],
						   'theme_url' => $theme_url,
						   'verification_code' => $activation,
						   'verification_url' => SITE_URL.'account/verify?hash='.$account_obj->hashEmail($_POST['email']),
						   'fullname' => $_POST['first_name'].' '.$_POST['last_name'],
						   'subject' => SITE_REPRESENT_TITLE.' : Please verify your email address');
			$emailObj->sendMail('verification', $edata);
			
			$redirect = (isset($_POST['redirect']) && !empty($_POST['redirect'])) ? $_POST['redirect'] : SITE_URL."account/signup-success";
			_locate($redirect."?t="._b64($_POST['email']));
		}
	}

	if($_REQUEST['action'] =='check'){
		// _locate(SITE_URL."account/invite");//testing on live
		$email_hash = $_POST['hash'];
		$active_code = $_POST['active_code'];

		if($account_obj->verifyAccount($email_hash, $active_code)) {
			_locate(SITE_URL."account/verification?success");
		} else {
			$_SESSION[PF.'ERROR'] = 'Provided verification code is not exists or expired';
			_locate(SITE_URL."account/verify?hash=".$email_hash);
		}
	}
	
	_error('404');
?>