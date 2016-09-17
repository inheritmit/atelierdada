<?php 
	if($account_obj->checkEmail($_GET['txtCompanyEmail'])) die('false');
	else die('true');
?>