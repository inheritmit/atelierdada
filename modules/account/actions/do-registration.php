<?php
	_module('emailer');
	$emailObj = new emailer();
	
	if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
		
      	if($_REQUEST['action'] == 'add') {
			
			$referId = 0;
			if(isset($_POST['r']) && !empty($_POST['r'])) {
				$checkAccount = $account_obj->getAccount("sha1(concat('".PASSWORD_HASH."', id)) = '".$_POST['r']."'");
				
				if(!is_array($checkAccount) && $checkAccount == 404) {
					$template = SITE_PATH.'errors/404.php';
				}
				
				$referId = $checkAccount['id'];
			}
		
			$email=strip_tags($_POST['email']);
			$check_duplicate=$account_obj->checkduplicate_account_email($email);
			if(mysql_num_rows($check_duplicate)>0){ //echo "if";exit;
				$_SESSION[PF.'ERROR']= "E-mail address is alerady registered with us";
				echo '<script>window.history.back();</script>';					
				exit;
			} else { 
				$password = sha1(PASSWORD_HASH.$_POST['new_password']); 
				$birthdate = Date::mysqlDate($_POST['birth_date'], 'DD/MM/YYYY');
				$verification = rand(10000000, 99999999);
				
				$data = array('strFullName' => $_POST['fullname'],
							  'strEmail' => $_POST['email'],
							  'strPassword' =>  $password,
							  'birthDate' => $birthdate,
							  'idCreatedBy' => 1,
							  'dtiCreated' => TODAY_DATETIME,
							  'dtiModified' => TODAY_DATETIME,
							  'validationCode' => $verification,
							  'referrerId' => $referId);
				$account_obj->insert_account($data);
				$vid = mysql_insert_id();
				
			    $data = array('vid' => $vid,
							  'oAuth_type' => 'email');
				
				if(isset($_POST['type']) && !empty($_POST['type'])) {
					$all = json_decode($_SESSION['oAuth_all']);
					$data['oAuth_type'] = $_POST['type'];
					$data['oAuth_name'] = $all->name;
					$data['oAuth_ID'] = $all->id;
					$data['oAuth_all'] = $_SESSION['oAuth_all'];
				}
				
				$account_obj->insert_account_detail($data);
				
				$edata = array('email' => $_POST['email'],
							   'fullname' => $_POST['fullname'],
							   'verification_code' => $verification,
							   'verification_url' => SITE_URL.'account/verify?hash='.$account_obj->hashEmail($_POST['email']),
							   'subject' => SITE_REPRESENT_TITLE.' : Please verify your account');
				$emailObj->sendMail('verification', $edata);
				
				_locate(SITE_URL."account/verify?hash=".$account_obj->hashEmail($_POST['email']));
			}
		}
		
		// Verify user account
		// By Mitesh Tandel 19-07-2013
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
		
		if($_REQUEST['action'] =='profile_insert'){ 
			//_locate(SITE_URL."account/sendinvitation");	//chnage on 18-07-2013 for send email with invitaion link
			_locate(SITE_URL."account/invite");	//chnage on 19-07-2013 for send email with invitaion link
			
			if(isset($_POST['txt_city']) && !empty($_POST['txt_city']))
			{
				  $check_city=$account_obj->check_city($_POST['txt_city']);//check city into table
				  if(mysql_num_rows($check_city)==0){
					  $city_data=array('city_name'=>$_POST['txt_city']);
					  $city_id=$account_obj->insert_city($city_data);//not in the table then insert it and give the Last inserted id
					  $cityid=mysql_insert_id();
				  }
				  else{
					  $row_city=$account_obj->getdata($check_city);
					  //$cityid=$_POST['txt_city'];
					  $cityid=$row_city['city_id'];
				 }
			}
			
			$data_update=array('address'=>$_POST['address'],
							   'state'=>$_POST['state'],
							   'city'=>$cityid);
													   
			$condition="id=".$_POST['account_id'];										   
			$result_profile=$account_obj->update_profile($data_update,$condition);
			if($result_profile){
			  _locate(SITE_URL."index");
			}
		}
}
?>