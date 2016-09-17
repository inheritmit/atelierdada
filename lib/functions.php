<?php

	function _e($txt) {
		echo $txt;
	}
	
	function _env($str) {
		$str = strtoupper($str);
		return $_SERVER[$str];
	}
	
	function _b64($str, $t = 'encode') {
		if($t == 'decode') {
			return base64_decode($str);
		}
		
		return base64_encode($str);			
	}
	
	function _seq($link, $seperator, $all = false, $qSep = '?')
	{
		global $_REQUEST;
		
		$as = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$alphabets = str_split($as);
		
		if($qSep == '&') {
			$link_data = explode('&', $link);
			
			$link = $link_data[0];
		}
		
		if($all)
		{
			$str = '<a href="'.$link.'"><strong>All</strong></a>';
			if(!isset($_REQUEST['sq']))
				$str = $str;
			$disp[] = $str;
		}
		
		for($a=0;$a<count($alphabets);$a++)
		{
			$str = '<a href="'.$link.$qSep.'sq='.$alphabets[$a].'">'.$alphabets[$a].'</a>';
			if(@$_REQUEST['sq'] == $alphabets[$a])
				$str = '<h6 style="display:inline;">'.$str.'</h6>';
			$disp[] = $str;
		}
		
		$display = implode($seperator, $disp);
		
		return $display;
	}
	
	function generateUniqueName($name, $ID, $table = 'pages', $field = 'name', $idfield = 'id', $where = '1') {
		global $db, $n, $unique_name;
		
		$qAdd = ($ID != 0) ? ' and '.$idfield.' != '.$ID : '';
		$qAdd .= (isset($_SESSION['NAV']) && !empty($_SESSION['NAV'])) ? ' and navid = '.$_SESSION['NAV'] : '';
		
		if(!isset($unique_name)) $unique_name = $name;
		
		$sql = "select count(id) as total_rows from ".$table." where ".$where." and ".$field." = '".$name."'".$qAdd;
		$result = $db->getResult($sql);
		
		if(!isset($n)) $n = 1;
		if($result['total_rows'] > 0) {
			$n++;
			$name = generateUniqueName($unique_name.'-'.$n, $ID, $table, $field);
		}
		
		return $name;
	}
	
	function shortenString($str, $length = 50) {
		$new_str = substr($str, 0, $length);
		if(!empty($str)) $new_str .= ' ...';
		return $new_str;
	}
	
	// Create a thumbnail from the given picture
	function createthumb($name,$filename,$new_w,$new_h,$echo=false){ 
		$file = pathinfo($name);		
		if (preg_match('/jpg|jpeg|JPG|JPEG/',strtolower($file['extension']))){
			$src_img=imagecreatefromjpeg($name);
		}
		if (preg_match('/png/',$file['extension'])){
			$src_img=imagecreatefrompng($name);
		}
		if (preg_match('/gif/',$file['extension'])){
			$src_img=imagecreatefromgif($name);
		}
	
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		
		if ($new_w==0) {
			$thumb_w=$old_x*($new_h/$old_y);
			$thumb_h=$new_h;
		}
		elseif ($new_h==0) {
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_w/$old_x);
		}
		else {
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		
		$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		
		if (preg_match("/png/",$file['extension'])) {
			imagepng($dst_img,$filename); 
		} elseif (preg_match("/gif/",$file['extension']))  {
			imagegif($dst_img, $filename);
		} else {
			imagejpeg($dst_img, $filename, 100); 
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img);
		
		if($echo)
			echo $filename; // change on 08May2014 Becoze File upload at that time Header is not redirect
	}
	
	// Create a thumbnail from the given picture
	function createimage($image_data, $filename, $type){ 
		
		$dst_img = imagecreatefromstring($image_data);
		
		if (preg_match("/png/",$type)) {
			imagepng($dst_img, $filename); 
		} elseif (preg_match("/gif/",$type))  {
			imagegif($dst_img, $filename);
		} else {
			imagejpeg($dst_img, $filename, 100); 
		}
		imagedestroy($dst_img);
	}
	
	/* 	function _locate
	//	This function is used for reducing the retyping of header location
	//	$path 			path to redirect
	*/
	function _locate($path) { 
		header("Location: ".$path);
		exit;
	}
	
	/* 	function unsetSession
	//	This function is used for unsetting the specified session variables
	//	$str 			variable name of the session you want to unset
	*/
	function unsetSession($str) {
		if(isset($_SESSION[$str]))
			unset($_SESSION[$str]);
	}
	
	function _msg($var, $class = 'success') {
		if(isset($_SESSION[$var]) && !empty($_SESSION[$var])) {
			echo '<div class="notify"><div class="'.$class.'">'.$_SESSION[$var].'</div></div>';
			unsetSession($var);
		}
	}
	
	function count_days( $a, $b ) {
		// First we need to break these dates into their constituent parts:
		$gd_a = getdate( $a );
		$gd_b = getdate( $b );
		// Now recreate these timestamps, based upon noon on each day
		// The specific time doesn't matter but it must be the same each day
		$a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
		$b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );
		// Subtract these two numbers and divide by the number of seconds in a
		// day. Round the result since crossing over a daylight savings time
		// barrier will cause this time to be off by an hour or two.
		return round( abs( $a_new - $b_new ) / 86400 );
	}
	
	function _isModule($module_name) {
		$module_path = SITE_PATH.'modules/'.$module_name;
		return file_exists($module_path) ? true : false;
	}
	
	function _module($module_name) {

		if(class_exists($module_name)) return true;
		
		$module_path = SITE_PATH.'modules/'.$module_name;
		if(file_exists($module_path.'/class/'.$module_name.'.class.php')) {
			include_once($module_path.'/class/'.$module_name.'.class.php');
			
			return true;
		} else {
			throw new Exception($module_name.' class not available');
		}
	}
	
	function _subModule($module_name, $class_name) {
		
		if(!class_exists($module_name)) _module($module_name);
		
		$module_path = SITE_PATH.'modules/'.$module_name;
		if(file_exists($module_path.'/class/'.$class_name.'.class.php')) {
			include_once($module_path.'/class/'.$class_name.'.class.php');
			
			return true;
		} else {
			throw new Exception('Module class not available');
		}
	}
	
	function _class($class_name) {
		
		if(class_exists($class_name)) return true;
		
		if(file_exists(SITE_PATH.'lib/classes/'.$class_name.'.class.php')) {
			include_once('classes/'.$class_name.'.class.php');
		} else {
			throw new Exception('Unable to load a class: '.$class_name);
		}
	}
	
	function _error($error_no, $module_name = '') {
		$error_path = !empty($module_name) ? SITE_PATH.'modules/'.$module_name.'/errors/' : SITE_PATH.'/errors/';
		if(file_exists($error_path.$error_no.'.php')) {
			include_once($error_path.$error_no.'.php');
		} else {
			throw new Exception('Unable to load a error: '.$error_no);
		}			
	}
	
	function _widget($name) {
		_class('widget');
		$widgetObj = new widget();
		
		$widget = $widgetObj->getWidget("name = '".$name."'");
		
		if($widget != 404) {
			
		}
	}
	
	function _layout($name) {
		global $theme_path;
		if(file_exists($theme_path.''.$name.'.php')) {
			return $theme_path.''.$name.'.php';
		} else {
			throw new Exception('Layout not available');
		}
	}
	
	function pr($ar='', $exit = true){
	   
		if(isset($ar) || !empty($ar)) {
			if(is_array($ar)) {
				echo "<pre>";
				print_r($ar);
				echo "</pre>";
			} else  {
				echo $ar." is not Array";
			}
			
		} else {
			echo "Array is Blank";
		}

        if($exit === true) exit;
    }

    function _template($module_name, $template_name) {
        global $theme;

        $module_path = SITE_PATH.'modules/'.$module_name.'/';
        if(file_exists($module_path)) {

            if(file_exists($module_path.'theme/'.$theme.'/'.$template_name.'.php')) {
                return $module_path.'theme/'.$theme.'/'.$template_name.'.php';
            } else {
                throw new Exception('Template is not available');
            }
        } else {
            throw new Exception('Module class not available');
        }
    }

    function _plugin($module_name, $plugin_name) {
        $template = _template($module_name, $plugin_name);

        include($template);
    }