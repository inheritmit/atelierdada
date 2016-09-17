<?php
	if(ENV != 1) {
		if(isset($_GET['k']) && $_GET['k'] == 'e174206637ca555c2f7a0f44acaa818d8aa757b1') {
			$_SESSION['KEY'] = $_GET['k'];
		}
	
		if(!isset($_SESSION['KEY']) || $_SESSION['KEY'] != 'e174206637ca555c2f7a0f44acaa818d8aa757b1') {
			session_destroy();
			include_once(SITE_PATH.'errors/maintainance.php');
			exit;
		}
	}
?>