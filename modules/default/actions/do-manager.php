<?php
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		
		if($_POST['action'] == 'submit-contact') {
			
			$data = $_POST;
			$dftObj->insertContact($data);
			
			// Send mail to administrator
			_class('emailer');
			$emailObj = new emailer();
			
			$edata = array('email' => ADMIN_EMAIL,
						   'fullname' => ADMIN_NAME,
						   'theme_url' => $theme_url,
						   'contact_name' => $_POST['txtName'],
						   'contact_email' => $_POST['txtEmail'],
						   'contact_phone' => $_POST['txtPhone'],
						   'contact_note' => $_POST['txtNote'],
						   'subject' => SITE_REPRESENT_TITLE.' : New Contact ('.$_POST['txtName'].')');
			$emailObj->sendMail('new-contact', $edata);
			
			$redirect = (isset($_POST['redirect']) && !empty($_POST['redirect'])) ? $_POST['redirect'] : $module_url."/contact-success";
			_locate($redirect);
			
		}
	}
?>