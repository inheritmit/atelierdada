<?php
	require_once($module_path.'/class/account.class.php');
	include_once(SITE_PATH.'/emailer/class/emailer.class.php');
	$emailObj = new emailer();
	$account_obj=new account();

	function generatePassword($length = 8) 
	{
		$chars = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#%$*';
		$count = mb_strlen($chars);
		for ($i = 0, $result = ''; $i < $length; $i++) {
		$index = rand(0, $count - 1);
		$result .= mb_substr($chars, $index, 1);
		}
		return $result;
	}	

	$email = strip_tags($_POST['email']);
	$account = $account_obj->getAccount("email = '".$email."'"); //print_r($account); exit;
	
	if($account == 404)
	{
		$_SESSION[PF.'ERROR']= "Ooops! ".$_POST['email']." is not registered with us";
		_locate(SITE_URL.'account/forgot-password');
	}
	else
	{
		$token = generatePassword(32);
		
		$data = array('token' => $token,
					  'vId' => $account['id'],
					  'sendDate' => TODAY_DATETIME);
		$account_obj->addResetToken($data);
		
		$reset_url = SITE_URL.'account/reset-password?email='.$account['strEmail'].'&token='.$token;
		$edata = array('email' => $account['strEmail'],
					   'fullname' => $account['strFirstName'].' '.$account['strLastName'],
					   'reset_url' => $reset_url,
					   'subject' => SITE_REPRESENT_TITLE.' : Reset your account password');
		$emailObj->sendMail('reset-password', $edata);
		
		$_SESSION[PF.'MSG'] = 'Reset password instructions email has been successfully sent';
		
		_locate(SITE_URL);
	}
?>