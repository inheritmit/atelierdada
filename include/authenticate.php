<?php
	$_SESSION[PF.'REFERER'] = $_SERVER['REQUEST_URI'];
	$_SESSION[PF.'AERROR'] = 'Please login to access private services.';
	
	if(!isset($_SESSION[PF.'MAIN']) || empty($_SESSION[PF.'MAIN']))
		_locate(SITE_URL.'account/login?r='.urlencode($_SERVER['REQUEST_URI']));
		
	unsetSession(PF.'AERROR');
	unsetSession(PF.'REFERER');
?>