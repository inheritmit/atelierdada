<?php
	_module('career');
	$career_obj = new career();

    if(in_array(@$req['parent'], array('join-us'))) {
        $req['auth'] = false;
    }
	
	if(!isset($req) || (isset($req['slug']) && !empty($req['slug']) && $req['action'] != 'ajax' && $req['slug'] != 'do')) {
		$theme = 'front';
		$template = getTemplate();
	}
	
	if(isset($req['parent']) && in_array($req['parent'], array('join-us'))) {
	    $theme = 'front';
	    $template = getTemplate();
        $layout_path = _layout('no-footer');
    }