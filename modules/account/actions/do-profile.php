<?php

    if(isset($_POST['submit'])) {

        if(isset($_FILES['imgurl']['name']) && !empty($_FILES['imgurl']['name']))
		{  
			if(File::isAllowedType($_FILES['imgurl']['type']))
			{
				//$upload_path = $module_path.'/upload/avtar/';
				$upload_path=UPLOAD_PATH.'account/avtar/';

				$time=time();						
				move_uploaded_file($_FILES['imgurl']['tmp_name'],$upload_path. $time.'_'.$_FILES['imgurl']['name']);
				$imgurl = $time.'_'.$_FILES['imgurl']['name'];
				chmod($upload_path . $time.'_'.$_FILES['imgurl']['name'],0777);
				createthumb($upload_path . $imgurl, $upload_path . '35/' . $imgurl, 35, 35, false);
				createthumb($upload_path . $imgurl, $upload_path . '140/' . $imgurl, 140, 140,  false);
			} else {
				$_SESSION[PF.'MSG']  = "wrong file type";
				_locate(SITE_URL."account/profile");
			}
		} else {
			$imgurl = $_POST['oldimg'];
		}

        $profile_data = array('strFirstName' => $_POST['firstname'],
                              'strLastName' => $_POST['lastname'],
			                  'strMobile'=>$_POST['mobileno'],
			                  'strPincode'=>$_POST['pincode'],
			                  'strCity'=>$_POST['city'],
                              'dtBirth' => Date::mysqlDate($_POST['birthdate'], 'DD/MM/YYYY'),
                              'strImgurl' => $imgurl);

		   $wherecond = "id=".$_POST['account_id'];
		   $insert_account_data = $account_obj->updateAccount($profile_data,$wherecond);

		   		$row = $account_obj->getAccountByID($_POST['account_id']);
			   	$_SESSION[PF.'MSG'] = 'Profile has been save Successfully';
				$_SESSION[PF.'NAME'] = $row['strFirstName']." ".$row['strLastName'];

		        if($row['strImgurl'] != "" && $row['strImgurl'] != NULL){
					$_SESSION['IMAGE']['140'] = SITE_URL.'file-manager/account/avtar/140/'.$row['strImgurl'];
					$_SESSION['IMAGE']['35'] = SITE_URL.'file-manager/account/avtar/35/'.$row['strImgurl'];
				}

		    $_SESSION['USERSTATUS'] = true;
	       	_locate(SITE_URL."account/profile");
}
_locate(SITE_URL."account/profile");