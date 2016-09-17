<?php
	if(!class_exists('account')) _module('account');
	_module('emailer');
	
	$emailObj = new emailer();
	$account_obj = new account();
	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		
      	if($_POST['action'] =='invite-emails') {
			
			$sent = 0;
			if (!empty($_POST['invitee_emails'])) {
				$res = preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i", $_POST['invitee_emails'], $matches);
				
				$invitee_emails = array_unique($matches[0]); //print_r($invitee_emails); exit;
				
				foreach($invitee_emails as $email) { 
					
					$checkEmail = $account_obj->getAccount("email = '".$email."'"); //this function is check for already if email is already registered
					
					if(!is_array($checkEmail) && $checkEmail == 404){   
						$data = array('toEmail' => $email,
									  'msgDate' => TODAY_DATETIME,
									  'vid' => $_SESSION[PF.'USERID']);
						$account_obj->insertInvitee($data);
						
						/*$edata = array('email' => $email,
									   'fullname' => $_SESSION[PF.'NAME'],
									   'join_url' => SITE_URL.'?hash='.String::getHash($volDetails['id']),
									   'subject' => $_SESSION[PF.'NAME'].' invited you to join '.SITE_REPRESENT_TITLE);
						$emailObj->sendMail('invitation', $edata);*/
						
						$sent++;
					}
				}
			}
			
			$_SESSION[PF.'MSG'] = $sent.' invitation(s) have been successfully sent';
			
			_locate(SITE_URL.'account/invite');
		}
		
		if($_POST['action'] == 'invite-contacts'){
			
			$sent = 0;
			foreach($_POST['contact'] as $email) {
				
			   	$checkEmail = $account_obj->getAccount("email = '".$email."'"); //this function is check for already if email is already registered
			    
				if(!is_array($checkEmail) && $checkEmail == 404) {
					
    	       		$data = array('toEmail' => $email,
								  'msgDate' => TODAY_DATETIME,
								  'vid' => $_SESSION[PF.'USERID']);
					$account_obj->insertInvitee($data);
					
					$sent++;
			 	}
         	}
			
			$_SESSION[PF.'MSG'] = $sent.' invitation(s) have been successfully sent';
			
			_locate(SITE_URL.'default/popup-close');
	  	}
		
		//start logic for the Read CSV file
		if($_POST['action'] == 'invite-csv'){
			
			require('reader/SpreadsheetReader.php');
			require('reader/excel_reader2.php');
			require("reader/doc2txt.class.php");
		
	        $file_name = $_FILES['csv_file']['name'];
	        $upload_path = 'csvfile/'.$file_name;
			
			$invite_email = explode(",",$_POST['invit_email']);
			$check_validate_email = $invite_email;
			
			$content = "";
			/***** xls *****/
			/*$data = new Spreadsheet_Excel_Reader("xcl.xls");
			$content .= $data->dump();*/
			/***** csv *****/
			if(isset($file_name)){
			   	$Spreadsheet = new SpreadsheetReader($upload_path);
			   	foreach($Spreadsheet as $Key => $Row){
					$content .= $Row[0];
			  	}
			}
			/***** xlsx *****/
			/*$Spreadsheet = new SpreadsheetReader("xcl.xlsx");
			foreach($Spreadsheet as $Key => $Row){
				$content .= $Row[0];
			}*/
			$matches = array();
			$pattern = '/[a-z0-9_\-\+.]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
			preg_match_all($pattern,$content,$matches);
			
			$invitee_emails = array_unique($matches[0]);
			
			foreach($invitee_emails as $email) { 
					
				$checkEmail = $account_obj->getAccount("email = '".$email."'"); //this function is check for already if email is already registered
				
				if(!is_array($checkEmail) && $checkEmail == 404){   
					$data = array('toEmail' => $email,
								  'msgDate' => TODAY_DATETIME,
								  'vid' => $_SESSION[PF.'USERID']);
					$account_obj->insertInvitee($data);
					
					/*$edata = array('email' => $email,
								   'fullname' => $_SESSION[PF.'NAME'],
								   'join_url' => SITE_URL.'?hash='.String::getHash($volDetails['id']),
								   'subject' => $_SESSION[PF.'NAME'].' invited you to join '.SITE_REPRESENT_TITLE);
					$emailObj->sendMail('invitation', $edata);*/
					
					$sent++;
				}
			}
      }	
	  //End CSV file logic
}
?>