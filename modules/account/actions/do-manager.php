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
				            'idDesg' => $_POST['sel_des'],
				            'strMobile' => $_POST['mobile'],
				            'strGender' => $_POST['gender'],
				            'dtBirth' => date('Y-m-d',strtotime($_POST['birthdate'])));
			$rsData = $account_obj->insertData($insert);

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

		_locate($page);
	}
?>