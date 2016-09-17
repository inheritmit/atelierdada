<?php
	/* Different Environment */
	define('ENV', 1);		// 1 = Developement, 2 = Live Testing, 3 = Production
	
	/* Paging Variables */
	define('PER_PAGE', 50);
	
	/* Date Variables */
	define('TODAY_DATE', date('Y-m-d'));
	define('TODAY_DATETIME', date('Y-m-d H:i:s'));
	define('TIME', time());
	
	/* General Variables */
	define('PASSWORD_HASH', '2016atelierdada09inheritlab17');
	define('USERIP', $_SERVER['REMOTE_ADDR']);
	
	// Default theme for the website
	$theme = 'default';
	$layout = 'default';
	
	// Default module to load
	$module = 'content';
	
	/** Prefix for session variables */
	define('PF', 'ADA_');