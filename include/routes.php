<?php
	
	// Define Routes
	Route::$request[] = array(
        array(
            'request' => '/',
            'action' => 'index',
            'test' => 'go' // an additional parameter
        ),
		array(
            'request' => '/<module>/load/<slug>',
            'action' => 'ajax'
        ),
        array(
            'request' => '/<content>/<slug>',
            'action' => 'detail',
            'module' => 'content'
        ),
        array(
            'request' => '/tag/<slug>',
            'action' => 'tag',
            'module' => 'content'
        ),
		array(
            'request' => '/<slug>',
            'action' => 'single',
			'module' => 'page'
        ),
		array(
            'request' => '/<module>/<parent>',
            'action' => 'module',
			'auth' => true
        ),
		array(
            'request' => '/<module>(/accounts/<parent>)',
            'action' => 'accounts',
			'auth' => true
        ),
		array(
            'request' => '/<module>/<parent>/<type>/<slug>',
            'action' => 'module',
			'auth' => true
        ),
		array(
            'request' => '/<module>/<parent>/<slug>(/page/<page>|/<pagination>)',
            'action' => 'module',
			'auth' => true
        ),
		array(
            'request' => '/<module>/<version>/<slug>',
            'action' => 'webservice'
        ),
        'controller' => 'main',
        'param' => array(
            'lang' => '[a-z]{2}', // regex url parametr <lang>
            'action' => '(contact|servise|go|[a-z]{5,25})', // regex url parametr <action>
            'page' => '[0-9]{1,3}',
            'pagination' => '[0-9]{1,3}',
            'year' => '[0-9]{4}',
			'slug' => '[a-z0-9_\-]{1,100}',
            'content' => '(case-study|studio|research|product|event|news)',
			'name' => '[a-z0-9_\-.]{1,100}',
			'parent' => '[a-z0-9_\-]{1,100}',
			'module' => '[a-z0-9_\-]{1,25}',
			'type' => '[a-z0-9_\-]{1,25}',
			'num' => '[0-9]{4}',
			'size' => '[a-z]{1}',
        )
    );
	
	$main_path = explode('?', $_SERVER['REQUEST_URI']); //pr($main_path); exit;
	$path = str_replace(HOME_DIR.'/', '', $main_path[0]); //echo $path;
	$routes = $req = Route::matchURI($path); // pr($routes); exit;
	
	if(isset($_POST['auth']) && in_array($_POST['auth'], array('true', 'false'))) {
		$req['auth'] = ($_POST['auth'] == 'true') ? true : false;
	}
	
	function getTemplate() {
		global $theme, $module_theme_path, $module_path, $module_url, $theme_path, $theme_url, $layout_path, $layout, $module, $routes;
		
		$theme_url = SITE_URL.'themes/'.$theme.'/';
		$theme_path = SITE_PATH.'themes/'.$theme.'/';
		
		$layout_path = $theme_path.$layout.'.php';
		
		$module_path = SITE_PATH.'modules/'.$module.'/';
		$module_theme_path = $module_path.'theme/'.$theme.'/';
		$module_url = SITE_URL.$module;
		
		if(isset($routes['module']) && in_array($routes['module'], array('default'))) {
			$routes['auth'] = false;
		}

        if(isset($routes['action'])) {

			if(isset($routes['module'])) {
				$module = $routes['module'];
				$module_path = SITE_PATH.'modules/'.$module.'/';
				$module_theme_path = $module_path.'theme/'.$theme.'/';
				$module_url = SITE_URL.$module;
			}
			
			if($routes['action'] == 'detail' || $routes['action'] == 'single') {
				if(isset($routes['slug'])) {
					if(file_exists($module_path.'theme/'.$theme.'/view.php')) {
						$template = $module_path.'theme/'.$theme.'/view.php';
					} else {
						$template = SITE_PATH.'errors/404.php';
					}
				}
			} else if($routes['action'] == 'tag') {
                if(isset($routes['slug'])) {
                    if(file_exists($module_path.'theme/'.$theme.'/tag.php')) {
                        $template = $module_path.'theme/'.$theme.'/tag.php';
                    } else {
                        $template = SITE_PATH.'errors/404.php';
                    }
                }
            } else if($routes['action'] == 'webservice') {
				$layout_path = '';
				if(isset($routes['version']) && isset($routes['slug'])) {
					if(file_exists($module_path.'web_'.$routes['version'].'/'.$routes['slug'].'.php')) {
						$template = $module_path.'web_'.$routes['version'].'/'.$routes['slug'].'.php';
					} else {
						$template = SITE_PATH.'errors/404.php';
					}
				}
			} else if(file_exists($module_path) && is_dir($module_path) && $routes['action'] != 'single') {
				if(isset($routes['action']) && $routes['action'] == 'ajax') {
					$layout_path = '';
					if(file_exists($module_path.'theme/'.$theme.'/ajax/load-'.$routes['slug'].'.php')) {
						$template = $module_path.'theme/'.$theme.'/ajax/load-'.$routes['slug'].'.php';
					} else {
						$template = SITE_PATH.'errors/404.php';
					}
				} else if(isset($routes['slug']) && $routes['slug'] == 'do') {
					$layout_path = '';
					if(file_exists($module_path.'actions/do-'.$routes['parent'].'.php')) {
						$template = $module_path.'actions/do-'.$routes['parent'].'.php';
					} else {
						$template = SITE_PATH.'errors/404.php';
					}
				} else if(isset($routes['parent'])) {
					$filename = $routes['parent'].'.php';
					if(strstr($routes['parent'], 'edit')) $filename = str_replace('edit', 'add', $routes['parent']).'.php';
					if(file_exists($module_path.'theme/'.$theme.'/'.$filename)) {
						$template = $module_path.'theme/'.$theme.'/'.$filename;
					} else {
						$template = SITE_PATH.'errors/404.php';
					}
				}
			} else if($routes['action'] == 'single' && $routes['slug'] != 'admin') {
				if(file_exists($module_path.'theme/'.$theme.'/'.$routes['action'].'.php')) {
					$template = $module_path.'theme/'.$theme.'/'.$routes['action'].'.php';
				} else {
					$template = SITE_PATH.'errors/404.php';
				}
			} else {
				$template = SITE_PATH.'errors/404.php';
			}
		} else {
			$template = $module_theme_path.'index.php';
		}
		
		return $template;
	}
	
	$template = getTemplate(); //pr($routes);