<?php 
$id=$_REQUEST['id'];
$delete=$_REQUEST['delete'];

if(!empty($id))
{
	if($delete == '0')
		$delete = 1;
	else if($delete =='1')
		$delete = 0;
		
	$data = array('enmDeleted' => $delete);
	$media_obj->updatephotoData($data);
?>
	<a href='javascript:void(0);' class="ajaxButton fa "
	   data-url="media/load/change-photodelete?delete=<?php echo $delete; ?>&id=<?php echo $id;?>"
	   data-container="#activate_<?php echo $id;?>" data-action="add">
		<?php if($pd['enmDeleted']=='0'){ echo "Delete"; } ?>
	</a>
<?php
}
else
{
   	echo "No ID Available";
}
?>