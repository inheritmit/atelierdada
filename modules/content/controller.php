<?php

    _subModule('content', 'block');
    $block_obj = new block();

	if(!isset($req) || (isset($req['slug']) && !empty($req['slug']) && $req['action'] != 'ajax' && $req['slug'] != 'do')) {
		$theme = 'front';
		$template = getTemplate();
		if(!isset($req)) {
			$layout_path = _layout('home');
		}
	}
	if(isset($req['parent']) && in_array($req['parent'], array('preview'))) {
		$layout = _layout('no-header-footer');
	}elseif(isset($req['parent']) && in_array($req['parent'], array('case-study', 'product', 'gis'))) {
		$theme = 'front';
		$template = getTemplate();
	}


    if(isset($req['parent']) && in_array($req['parent'], array('case-study', 'research', 'news', 'event', 'studio', 'product'))) {
        $req['auth'] = false;
    }

	if(isset($req['content']) && in_array($req['content'], array('case-study'))) {
        $template = _template('content', 'case-study');
        $layout_path = _layout('case-study');
	}

    if(isset($req['content']) && in_array($req['content'], array('product', 'studio'))) {
        $layout_path = _layout('no-footer');
    }

    if(isset($req['content']) && in_array($req['content'], array('research', 'news'))) {
        $layout_path = _layout('no-banner');
    }

    if(isset($req['action']) && in_array($req['action'], array('tag', 'search'))) {
        $layout_path = _layout('no-video');
    }