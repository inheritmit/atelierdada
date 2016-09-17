<?php
	_module('media');
	$media_obj = new media();

    if(in_array($req['parent'], array('gallery', 'album-gallery'))) {
        $req['auth'] = false;
    }

	if(!isset($req) || (isset($req['slug']) && !empty($req['slug']) && $req['action'] != 'ajax' && $req['slug'] != 'do')) {
		$theme = 'front';
		$template = getTemplate();
		
		if(!isset($req)) {
			$layout_path = _layout('home');
		}
	}
	if(isset($req['parent']) && in_array($req['parent'], array('photogallery'))) {
		$layout_path = _layout('no-header-footer');
	}elseif(isset($req['parent']) && in_array($req['parent'], array('gallery','album-gallery'))) {
		$theme = 'front';
		$template = getTemplate();
	}
	
