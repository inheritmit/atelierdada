<?php 
	$id=$_REQUEST['id'];
	$stat=$_REQUEST['stat'];
	
	$access = ($stat == 1) ? 'approve' : 'reject';
	if(!$account_obj->checkAccess('registration', $access)) {
		_error('unauthorized');
		exit;
	}
	
	if(!empty($id)) {
		if($stat == '1') {
			$details = $account_obj->getRegistrationByID($id); //pr($details);
			
			$activation = String::getHash($details['txtCompanyEmail'].$details['dtiCreated']);
			
			$account = array('name' => $details['txtCompanyName'],
							 'strEmail' => $details['txtCompanyEmail'],
							 'activate' => $activation,
							 'access' => 2);
			$account_id = $account_obj->insertAccount($account);
			
			$activation_url = $module_url.'/set-password?hash='.$activation.'&email='.$details['txtCompanyEmail'];
			
			// Send mail to administrator
			_class('emailer');
			$emailObj = new emailer();
			
			$edata = array('email' => $details['txtCompanyEmail'],
						   'fullname' => $details['txtCompanyName'],
						   'theme_url' => $theme_url,
						   'password_url' => $activation_url,
						   'subject' => SITE_REPRESENT_TITLE.' : Your account has been activated');
			$emailObj->sendMail('activation', $edata);
		}
		
		$data = array('enumApproved' => $stat,
					  'idApprovedBy' => $_SESSION[PF.'USERID'],
					  'dateApproved' => TODAY_DATETIME,
					  'idStore' => $account_obj->getStoreID(),
					  'accountId' => $account_id);
		$account_obj->updateRegistration($data, $details['id']);
	}
	else
	{
		echo "No ID Available";
	}
?>