<?php
if(isset($_POST['action']) && !empty($_POST['action'])){

	if(isset($_POST['action']) && $_POST['action'] == 'add')
	{
		$videoname=$_POST['videoname'];
		$where = "enmDeleted = '0' and strName='$videoname'";
		$rsVideo = $media_obj->getVideoCount($where);
		if($rsVideo!=0) {
			$_SESSION[PF.'MSG'] = "This Video name is already exists..!";
			_locate(SITE_URL."media/videolist");
		}
		else {
			$insertVideo = array(
				'idCategory' => $_POST['category'],
				'strName' => $_POST['videoname'],
				'txtUrl' => $_POST['videourl'],
				'enmType' => $_POST['media_type'],
				'dtVideo' => date('Y-m-d', strtotime($_POST['video_date'])),
				'idCreatedBy' => $_SESSION[PF . 'USERID'],
				'dtiCreated' => TODAY_DATETIME
			);
			$rsData = $media_obj->insertVideoData($insertVideo);
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
		$modifyVideo = array(
			'id' => $id,
			'idCategory' => $_POST['category'],
			'strName' => $_POST['videoname'],
			'txtUrl' => $_POST['videourl'],
			'enmType' => $_POST['media_type'],
			'dtVideo' => date('Y-m-d',strtotime($_POST['video_date'])),
			'dtiModified' => TODAY_DATETIME,
			'idModifiedBy' => $_SESSION[PF.'USERID']
		);

		$rsData = $media_obj->updateVideoData($modifyVideo);
		if($rsData){
			$_SESSION[PF.'MSG']  = "<strong>".$_POST['videoname']."</strong> has been successfully Updated";
		} else {
			$_SESSION[PF.'ERROR']  = "Error while updating data";
		}
	}
	_locate(SITE_URL."media/videolist");
}
?>