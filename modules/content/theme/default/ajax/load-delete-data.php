<?php 
$id=$_POST['id'];
$data = array('enmDeleted'=>'1', 'idDeletedBy'=>$_SESSION[PF.'USERID'], 'dtiDeleted'=>TODAY_DATETIME);
$cont_obj->deleteData($id, $data);

$_SESSION[PF.'MSG']  = "Content has been deleted";
?>