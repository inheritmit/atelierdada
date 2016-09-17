<?php 
	if($account_obj->checkEmail($_GET['email'], 'account')) die('false');
	else die('true');
?>