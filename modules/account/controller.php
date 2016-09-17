<?php

    if(isset($req['parent']) && in_array($req['parent'], array('login','forget-password', 'signup', 'signup-success', 'pdf', 'set-password', 'verify', 'verification','email', 'password', 'reset-password','new-password'))) {
        $req['auth'] = false;
    }

    if(isset($req['parent']) && in_array($req['parent'], array('login','signup', 'signup-success', 'pdf', 'set-password','add-avail'))) {
		// $theme = 'front';

		$theme = 'default';
		$template = getTemplate();
		$layout_path = _layout('no-header-footer');
	}
	
	if(isset($req['parent'])) {
		$filename = $req['parent'].'.php';
		if(strstr($req['parent'], 'edit')) $filename = str_replace('edit', 'add', $req['parent']).'.php';
	}
	
	$current_sidebar = 'account-sidebar';
	if(empty($template)) $template = $module_path.'/theme/'.$theme.'/home.php';
    if(isset($req['parent']) && in_array($req['parent'], array('invite', 'verify', 'verification', 'forgot-password'))) {
	   $layout_path = '';
    }

    if(isset($req['parent']) && in_array($req['parent'], array('forgot-password', 'pdf', 'generate-password', 'access-details'))) {
		$layout_path = '';
	} else if(isset($req['slug']) && $req['slug'] == 'do') {
	    $layout_path = '';
	}
    if(isset($req['parent']) && in_array($req['parent'], array('reset-password', 'login'))) {
		$layout_path = _layout('main-login-page');
    }
    if(isset($req['parent']) && in_array($req['parent'], array('new-password'))) {
		$layout_path = _layout('no-header-footer');
    }