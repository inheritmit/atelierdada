<?php
	/* Database Detail */

	if(ENV == 1) { // Development
		
		define('DB_SERVER','localhost');
		define('DB_USERNAME','atelier');
		define('DB_PASSWORD','a9WAU76R6y2rWFHa');
		define('DB_SCHEMA','atelier');
		
		error_reporting(E_ALL);
	}
	
	if(ENV == 2) { // Testing
		define('DB_SERVER','mysql.appdemo.co.in');
		define('DB_USERNAME','dadadbuser');
		define('DB_PASSWORD','atelierDB2015');
		define('DB_SCHEMA','dbatelier');
		
		ini_set('error_reporting', E_ALL);
		error_reporting(E_ALL);
		ini_set('log_errors',TRUE);
		ini_set('html_errors',FALSE);
		ini_set('error_log', SITE_PATH.'errors/error.log');
		ini_set('display_errors',FALSE);
	}