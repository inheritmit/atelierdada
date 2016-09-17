<?php 
/** Settings class to load all default settings from the database */
	include_once('pdo.class.php');
	
	class setting extends db_class {
		var $_table = 'mst_settings';
		
		function insertSetting($data) {
			$this->insertByArray($this->_table, $data);
		}
		
		function getSettings($where) {
			$sql = "select main.* 
					from ".$this->_table." as main 
					where loadable = '1'".$where;
			return $this->getResults($sql);
		}
		
		function loadConstants() {
			$settings = $this->getSettings(" and constant = '1'");
			if($settings != 404) {
				foreach($settings as $setting) {
					if(!defined($setting['string'])) {
						define($setting['string'], $setting['value']);
					}
				}
			}
		}
		
		function loadVariables() {
			return $this->getSettings(" and constant = '0'");
		}
	}
?>