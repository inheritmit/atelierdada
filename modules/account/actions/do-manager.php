<?php
_class('emailer');
$emailObj = new emailer();

	if(isset($_POST['action']) && !empty($_POST['action'])) {
		
		if(isset($_POST['action']) && $_POST['action'] == 'add') {

			//$password = String::getHash($_POST['fname']);
			$password = String::getHash($_POST['password']);
			$verification = rand(10000000, 99999999);

			$insert = array('strFirstName'=>$_POST['fname'],
				            'strLastName'=>$_POST['lname'],
				            'strMiddleName'=>$_POST['mname'],
				            'strPassword' => $password,
							'strEmail' => $_POST['email'],
							'dtiCreated' => TODAY_DATETIME,
							'idCreatedBy' => $_SESSION[PF.'USERID'],
							'tinStatus' => '0',
				            'strActivation' => $verification,
				            'idDesg' => $_POST['sel_des'],
				            'strAddress' => $_POST['address'],
				            'strMobile' => $_POST['mobile'],
				            'strGender' => $_POST['gender'],
				            'enmActivated' => 1,
				            'dtBirth' => date('Y-m-d',strtotime($_POST['birthdate'])));
			$rsData = $account_obj->insertData($insert);

			if(defined('VERIFY') && VERIFY === true) {

				$edata = array('email' => $_POST['email'],
							   'fullname' => $_POST['fname']." ".$_POST['lname'],
							   'verification_code' => $verification,
							   'verification_url' => SITE_URL.'account/verify?hash='.$account_obj->hashEmail($_POST['email']),
							   'subject' => SITE_REPRESENT_TITLE.' : Please verify your account');
				$emailObj->sendMail('verification', $edata);
			}

	       if($rsData) {
				$_SESSION[PF.'MSG']  = "<strong>".$_POST['fname']." ".$_POST['mname']." ".$_POST['lname']."</strong> has been successfully Added";		     		
			} else {
				$_SESSION['ERR']  = "Error while inserting data";
			}
			
			$page = SITE_URL."account/list";
		}
		
		if(isset($_POST['action']) && $_POST['action'] == 'edit')
		{ //pr($_POST);exit;
			$ID = isset($_POST['ID']) ? $_POST['ID'] : 0;
			
			$modified = array('strFirstName' => $_POST['fname'],
				              'strLastName' => $_POST['lname'],
				              'strMiddleName' => $_POST['mname'],
				              'strEmail' => $_POST['email'],
							  'dtiModified' => TODAY_DATETIME,
							  'idModifiedBy' => $_SESSION[PF.'USERID'],
							  'tinStatus' => '1',
				              'idDesg' => $_POST['sel_des'],
				              'strAddress' => $_POST['address'],
				              'strMobile' => $_POST['mobile'],
				              'strGender' => $_POST['gender'],
				              'dtBirth' => date('Y-m-d',strtotime($_POST['birthdate'])));

			if(isset($_POST['password']) && !empty($_POST['password'])){
				$modified['strPassword'] = String::getHash($_POST['password']);
			}

			$rsData = $account_obj->updateData($modified,$_POST['id']);
			if($rsData) {
				$_SESSION[PF.'MSG']  = "<strong>".$_POST['fname']."</strong> has been successfully Updated";
			} else {
				$_SESSION['ERR']  = "Error while inserting data";
			}
			
			$page = SITE_URL."account/list";
		}
		
		if($_POST['action'] == 'check'){

			$email_hash = $_POST['hash'];
			$active_code = $_POST['active_code'];
			
			if($account_obj->verifyAccount($email_hash, $active_code)) {
				_locate(SITE_URL."account/verification?success");
			} else {
			  	$_SESSION[PF.'ERROR'] = 'Provided verification code is not exists or expired';
				_locate(SITE_URL."account/verify?hash=".$email_hash);
			}
		}

		_locate($page);
	}
?>