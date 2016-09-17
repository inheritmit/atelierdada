<?php  
class drive extends db_class {
	
	var $_table = 'mst_drive';
	var $_account_table = 'mst_account';
	var $_log_obj;
	var $_filter;
	
	function init() {		
		_class('logs');
		$this->_log_obj = new logs();
	}
	
	function getFiles($where = '', $order = array()) {
		$where = " and main.type = 'file' ".$where;
		return $this->getDrive($where, $order);
	}
	
	function setFilter($key, $value) {
		$this->_filter[$key] = $value;
	}
	
	function getDrive($where = '', $order = array()) {
		
		$order_array = array(); $order_by = ' order by main.type desc, main.fileName';
		if(sizeof($order) > 0) {
			foreach($order as $field => $asc) {
				$order_array[] = $field." ".$asc;
			}
			$order_by .= ", ".implode(", ", $order_array);
		}
		
		$qAdd = '';
		if(sizeof($this->_filter) > 0) {
			foreach($this->_filter as $type => $filter) {
				switch($type) {
					case 'idx':
						$qAdd .= " and main.id in (".$filter.")";
						break;
					default:
						$qAdd .= '';
						break;
				}
			}
		}
		
		$sql = "select main.*, account.fullName as ownerName, f.fileTime as folderTime     
				from ".$this->_table." as main 
				inner join ".$this->_account_table." as account 
					on account.id = main.userId 
				left join ".$this->_table." as f 
					on f.filetime = main.folder 
				where main.deleted = '0' ".$where.$qAdd.$order_by;
		return $this->getResults($sql);
	}
	
	function getFilesByUser($userid) {
		$where = " and main.userId = ".$userid;
		return $this->getFiles($where);
	}
	
	function getFilesByFolder($folderid) {
		$where = " and main.folder = ".$folderid;
		return $this->getFiles($where);
	}
	
	function getDriveByFolder($folderid) {
		$where = " and main.folder = ".$folderid;
		return $this->getDrive($where);
	}
	
	function getDriveByUser($userid) {
		$where = " and main.folder = 0 and main.userId = ".$userid;
		return $this->getDrive($where);
	}
	
	function getItem($where) {
		$sql = "select main.*, f.fileName as folderName, f.storageName as folderStorageName    
				from ".$this->_table." as main
				left join ".$this->_table." as f 
					on f.id = main.folder 
				where main.deleted = '0'".$where;
		return $this->getResult($sql);
	}
	
	function getItemByTime($time, $userid = 0) {
		$where = " and main.fileTime = '".$time."'";
		if($userid != 0) {
			$where .= " and main.userId = ".$userid;
		}
		return $this->getItem($where);
	}
	
	function getItemByStorageName($storage_name, $userid = 0) {
		$where = " and main.storageName = '".$storage_name."'";
		if($userid != 0) {
			$where .= " and main.userId = ".$userid;
		}
		return $this->getItem($where);
	}
	
	function getItemByID($id) {
		$where = " and main.id = ".$id;
		return $this->getItem($where);
	}
	
	function deleteItem($id, $userid = 0) {
		$item = $this->getItemByID($id);
		if($item == 404) return 404;
		
		if($userid != 0 && $item['userid'] != $userid) return 505;
		
		if($item['deleted'] == '1') return 405;
		
		$this->delete($this->_table, "id = ".$id);
		return 200;
	}
	
	function addItem($data) {
		$modified = $this->parseData($data);
		$this->insert_array($this->_table, $modified);
	}
	
	function parseData($data) {
					
		$modified = array('fileName' => $data['file_name'],
						  'type' => $data['type'],
						  'fileTime' => TIME,
						  'checkSum' => $data['checksum'],
						  'fileSize' => $data['size'],
						  'storageName' => $data['storage'],
						  'mimeType' => $data['mime'],
						  'folder' => $data['folder'],
						  'userId' => $data['user_id']);
		return $modified;
	}
}
?>