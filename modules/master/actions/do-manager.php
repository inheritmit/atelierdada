<?php 	
	if(isset($_POST['action']) && !empty($_POST['action'])){
		
		if(isset($_POST['type'])) {

			$type = _b64($_POST['type'], 'decode');

			$input_name = str_replace('-', '_', $type).'_name';
			$name = ucwords(str_replace('-', ' ', $type));

			$db_name_field = 'str'.str_replace(' ', '', $name);

			if(isset($_POST['action']) && $_POST['action'] == 'add')
			{
				$type_name = $_POST[$input_name];
                $where_cond=$db_name_field." = '$type_name' and enmDeleted='0'";
				$result = $master_obj->getMasterCount($where_cond, $type);

				if($result!=0) {
					$_SESSION[PF.'MSG'] = "This ".$type_name." ".$type." is already taken!";
					_locate(SITE_URL."master/add?t="._b64($type));
				} 
				else{
					$rsData = $master_obj->insertData($_POST, $type);
					if($rsData){
						$_SESSION[PF.'MSG']  = "<strong>".$_POST[$input_name]."</strong> has been successfully added";
					}else {
						$_SESSION[PF.'MSG']  = "Error while inserting data";
					}
				}
			}
			
			if(isset($_POST['action']) && $_POST['action'] == 'edit')
			{
				$input_name = str_replace('-', '_', $type).'_name';
				$name = ucwords(str_replace('-', ' ', $type));
				$db_name_field = 'str'.str_replace(' ', '', $name);

				$type_name = $_POST[$input_name];
				$where_cond=$db_name_field." = '$type_name' and enmDeleted=1 and id!=".$_POST['ID'];
				$result = $master_obj->getMasterCount($where_cond, $type);

				if($result!=0){
					$_SESSION[PF.'MSG'] = "This ".$type_name." ".$type." is already taken!";
					_locate(SITE_URL."master/edit?t="._b64($type)."&id=".$_POST['ID']);

				}else{

					$rsData = $master_obj->updateData($_POST, $type);
					if ($rsData) {
					$_SESSION[PF . 'MSG'] = "<strong>" . $_POST[$input_name] . "</strong> has been successfully update";
					} /*else {
					$_SESSION[PF . 'MSG'] = "Error while update data";
					}*/
				}
			}
			
			if(isset($_POST['action']) && $_POST['action'] == 'bulk-add')
			{
				$names = explode("\n", $_POST['names']);
				
				if(sizeof($names) > 0) {	
					foreach($names as $iname) {
						$data[$name] = $iname;
						if(isset($_POST['parent'])) $data['parent'] = $_POST['parent'];
						$master_obj->insertData($data, $_POST['type']);
					}
					$_SESSION[PF.'MSG']  = "All categories have been successfully submitted";
				}
			}
			
			$type = ($type == 'category') ? 'categorie' : $type;
			_locate($module_url."/list?t=".$_POST['type']);
			
		}
	}
?>