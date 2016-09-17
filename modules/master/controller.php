<?php
	_module('master');
	$master_obj = new master(); 
	
	$module_name = $req['module'];	

	if(isset($req['parent'])) {
		$filename = $req['parent'].'.php';
		if(strstr($req['parent'], 'edit')) $filename = str_replace('edit', 'add', $req['parent']).'.php';
	}
?>