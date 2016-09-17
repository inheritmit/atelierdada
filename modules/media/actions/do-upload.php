<?php
if(isset($_POST['action']) && $_POST['action'] == 'uploadphoto')
{
	foreach ($_FILES['photoname']['name'] as $key => $value) {

		if (isset($value) && !empty($value)) {
			if (File::isAllowedType($_FILES['photoname']['type'][$key])) {
				//$upload_path = $module_path . 'upload/photoalbum/';
				$upload_path=UPLOAD_PATH.'media/';
				$time = time();
				if(move_uploaded_file($_FILES['photoname']['tmp_name'][$key], $upload_path.$time.$value)){
					$imgurl = $time.$value;
					chmod($upload_path.$time.$value, 0777);
					createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 35, 35, false);
					createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 140, 140,  false);
				} else {
					echo "Error in upload file";
				}
			} else {
				$_SESSION['ERR'] = "wrong file type";
				_locate(SITE_URL . "media/list");
			}
		} else {
			$imgurl = null;
		}

		$data = array(
			'idPhotoAlbum' => $_POST['albumid'],
			'strImageName' => $imgurl,
			'dtiCreated' => TODAY_DATETIME,
			'idCreatedBy' => $_SESSION[PF . 'USERID']);
		$rsData = $media_obj->insertPhotosData($data);

	}

	if($rsData){
		$_SESSION[PF.'MSG']  = "<strong>Photo</strong> has been successfully Uploaded";

	} else {
		$_SESSION[PF.'ERROR']  = "Error while Updateing data";
	}

	_locate(SITE_URL."media/popup-close");
	// _locate(SITE_URL."media/list");

}
?>
