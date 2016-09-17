<?php  
class defaultclass extends db_class {
	
	var $_contact_table = 'mst_contacts';
	
	function insertContact($data) {
		$insertArray = $this->contactArray($data);
		$this->insertByArray($this->_contact_table, $insertArray);
	}
	
	function contactArray($data) {
		
		$modified = array('txtName' => $data['txtName'], 
						  'txtAddress' => $data['txtAddress'], 
						  'txtPhone' => $data['txtPhone'], 
						  'txtEmail' => $data['txtEmail'],
						  'txtNote' => $data['txtNote'],
						  'dtiCreated' => TODAY_DATETIME);
		
		return $modified;
		
	}

}
?>