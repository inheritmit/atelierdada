<?php
//pr($_POST);
//loadModule('master');
$mstObj = new master();
$id=$_POST['id'];
//$status = $_POST['sts'];
//$data = array('enmDeleted'=>'1', 'tinStatus' => '0', 'idDeletedBy'=>$_SESSION[PF.'USERID'], 'dtiDeleted'=>TODAY_DATETIME);

$data = array('enmDeleted'=>'1',
              'idDeletedBy'=>$_SESSION[PF.'USERID'],
              'dtiDeleted'=>TODAY_DATETIME);

$master_obj->delete_update_master($id, $data,$_POST['type']);
$_SESSION[PF.'MSG']  = "categories has been deleted";
/*$delete=$master_obj->delete_update_master($id, $data,$_POST['type']);
if($delete){
    _e(_b64($_POST['type']));
}*/
?>

