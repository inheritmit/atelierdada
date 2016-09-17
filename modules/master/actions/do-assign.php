<?php
	if(isset($_POST['submit']))  {
		
		$assign_role = array('txtModules' => serialize($_POST['module']),
						 	 'txtActions' => serialize($_POST['action']));
		$id = $_POST['id'];			 
		$rsData = $master_obj->updateAssignRole($assign_role, $id);
	}
	$_SESSION[PF.'MSG'] = 'Roles has been successfully updated';

	_locate(SITE_URL."master/list?t="._b64('access-type'));