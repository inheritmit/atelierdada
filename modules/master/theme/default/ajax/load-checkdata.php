<?php 
$id = $_REQUEST['eid'];
$type = $_REQUEST['ttype']; 
$typename = $type.'_name';
$name =$_REQUEST[$typename];  

if($_REQUEST['pgaction']=="add")
{
	if(!empty($name) && !empty($_REQUEST['ttype']) )
	{
		$result =$mstObj->getMasterCount("$typename='$name' and enmStatus = '1' and enmDeleted = '0'", $type);
		if($result==0) {
			echo "true";
		} else {
			echo "false";
		}
	} else { echo "false"; }
	
} else {
	 
	if(!empty($name) && !empty($_REQUEST['ttype']) )
	{
		$result =$mstObj->getMasterCount("$typename='$name' and enmStatus = '1' and enmDeleted = '0' and id!='$id' ", $type);
		if($result==0) {
			echo "true";
		} else {
			echo "false";
		}
	
	} else { echo "false";}
}
?>