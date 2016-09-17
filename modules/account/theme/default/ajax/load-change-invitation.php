<?php
$id = $_REQUEST ['id'];
$invited = $_REQUEST ['invited'];

if (! empty ( $id )) {
	if ($invited == '0')
		$invited = 1;
	else if ($invited == '1')
		$invited = 0;
	$data = array('invited' => $invited);
	$where = "id=".$id;
	$account_obj->updateVolunteer($data, $where);
?>
<a href='javascript:void(0);'
	data-url="account/load/change-invitation?invited=<?php echo $invited;?>&id=<?php echo $id;?>"
	data-action="add" data-container="#activate_<?php echo $id;?>"
	class="ajaxButton fa<?php if($invited=='1') echo " _green fa-eye"; else echo " _red fa-eye-slash" ?>"
	title="Click to <?php if($invited=='0') echo "Cancle"?>Invitation"> </a>
<?php
} else {
	echo "No ID Available";
}
?>