<?php 
$id=$_REQUEST['id'];
$status=$_REQUEST['status'];

if(!empty($id))
{
	if($status == '0')
		$status = 1;
	else if($status =='1')
		$status = 0;
		
	$data = array('enmStatus' => $status);
	$media_obj->updateData($data);
?>
<a href='javascript:void(0);' data-url="media/load/change-status?status=<?php echo $status;?>&id=<?php echo $id;?>"
   data-action="add" data-container="#activate_<?php echo $id;?>"
   class="ajaxButton fa<?php if($status=='1') echo " _green fa-eye"; else echo " _red fa-eye-slash" ?>"
   title="Click to <?php if($status=='0') echo "De"?>active">
</a>
<?php
}
else
{
   	echo "No ID Available";
}
?>