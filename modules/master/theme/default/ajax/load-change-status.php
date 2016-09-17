<?php
$id=$_REQUEST['id'];
$result =$master_obj->authorize_select_master($id,$_POST['type']);
if($result>0){
	if($result['enmStatus']=='1')
	{
		$data = array('enmStatus'=>'0');
		$master_obj->authorize_update_master($id,$data,$_POST['type']);
		?>
<a href='javascript:void(0);'  data-url="master/load/change-status&id=<?php echo $id;?>&type=<?php _e($_POST['type']);?>" class="fa fa-eye-slash _red ajaxButton" data-container="#activate_<?php echo $result['id'];?>" title="Click to Activate" data-action="add"></a>
   <?php } else {
		$data = array('enmStatus'=>'1');
		$master_obj->unauthorize_update_master($id,$data,$_POST['type']);
		?>
<a href='javascript:void(0);' data-url="master/load/change-status&id=<?php echo $id;?>&type=<?php _e($_POST['type']);?>" class="fa fa-eye _green ajaxButton"  data-container="#activate_<?php echo $result['id'];?>" title="Click to Deactivate" data-action="add"></a>
	<?php }
}
else
{
	echo "Not Available";
}
?>