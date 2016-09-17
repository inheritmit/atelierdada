<?php
	unsetSession(PF.'USERID');
	unsetSession(PF.'EMAIL');
	unsetSession(PF.'NAME');
	session_destroy();

	_locate($module_url.'/login');
?>