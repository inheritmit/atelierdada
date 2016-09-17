<?php
if(isset($_POST['action']) && !empty($_POST['action'])){

	if(isset($_POST['action']) && $_POST['action'] == 'add')
	{
		$albumname=$_POST['photoname'];
		$where = "enmDeleted = '0' and strName='$albumname'";
		$rsMedia = $media_obj->getMediaCount($where);
		if($rsMedia!=0) {
			$_SESSION[PF.'MSG'] = "This Album name is already exists..!";
			_locate(SITE_URL."media/list");
		}
		else {

			$modified = array(
				'idCategory' => $_POST['category'],
				'dtPhoto' => date('Y-m-d', strtotime($_POST['media_date'])),
				'strName' => $_POST['photoname'],
				'txtDescription' => $_POST['description'],
				'idCreatedBy' => $_SESSION[PF . 'USERID'],
				'dtiCreated' => TODAY_DATETIME
			);
			$rsData = $media_obj->insertData($modified);
			if ($rsData) {
				$_SESSION[PF . 'MSG'] = "<strong>" . $_POST['photoname'] . "</strong> has been successfully Added";
			} else {
				$_SESSION[PF . 'ERROR'] = "Error while inserting data";
			}

		}
	}
	else if(isset($_POST['action']) && $_POST['action'] == 'edit')
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$modified = array(
			'id' => $id,
			'idCategory' => $_POST['category'],
			'dtPhoto'=> date('Y-m-d',strtotime($_POST['media_date'])),
			'strName' => $_POST['photoname'],
			'txtDescription' => $_POST['description'],
			'dtiModified' => TODAY_DATETIME,
			'idModifiedBy' => $_SESSION[PF.'USERID']
		);

		$rsData = $media_obj->updateData($modified);
		if($rsData){
			$_SESSION[PF.'MSG']  = "<strong>".$_POST['photoname']."</strong> has been successfully Updated";
		} else {
			$_SESSION[PF.'ERROR']  = "Error while inserting data";
		}
	}
	_locate(SITE_URL."media/list");
}
?>