<?php 
$id=$_REQUEST['id'];
$default=$_REQUEST['default'];

if(!empty($id))
{
	/* update all fields to default o then make default value 1 */
	$data = array('enmDefaultImage' => '0');
	$media_obj->updatephoto($data);

	$data = array('enmDefaultImage' => '1');
	$media_obj->updatephotoData($data);

?>
<a href='javascript:void(0);' class="ajaxButton fa"
   data-url="media/load/change-photodefault?default=<?php echo $default; ?>&id=<?php echo $id;?>"
   data-container="#activate_<?php echo $id;?>" data-action="add">
	<?php if($default=='1'){ echo "Make Default"; } else { echo "Default"; }?>
</a>
<?php
}
else
{
   	echo "No ID Available";
}
?>