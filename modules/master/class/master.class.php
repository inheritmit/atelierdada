<?php 
class master extends db_class
{ 
    var $_types = array('access-type' => array('table' => 'mst_access_types'),
						'navigation' => array('table' => 'mst_navigations'),
		                'category' => array('table' => 'mst_category'),
						'tag' => array('table' => 'mst_tag')
						);
	
	function getMaster($where, $type = 'access-type') {
		$table = $this->_types[$type]['table'];
		$sql = "select * from ".$table." where ".$where;
		return $this->getResult($sql);
	}
	/** getting Master from id
	 ** @param  $where :$where is pass particular id
	 */
	function getMasterByID($id, $type = 'access-type') {
		$where = "id = ".$id;
		return $this->getMaster($where, $type);
	}
	/** getting Total Master Count rows related to id
	 ** @param  $where :$where is pass particular id
	 *  @return int :Send particular count
	 */
	function getMasterCount($where = '1', $type = 'access-type') {
		$table = $this->_types[$type]['table']; 
		$sql = "select count(id) as total_rows from ".$table." where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}
	/** getting Master related to id
	 * @param  $where : $where is pass particular id
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getMasterByPage($where = '1', $page = '1', $type = 'access-type') {
		$table = $this->_types[$type]['table'];
		$sql = "select * from ".$table." where ".$where;
		return $this->getResults($sql, $page, 'paged');
	}

	/** Save Page details from Page details array
	 * @param array $data : Array of Page
	 * * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertData($data, $type = 'access-type') {
		$insert = $this->dataArray($data, $type);
		$table = $this->_types[$type]['table'];
		return $this->insertByArray($table, $insert);
	}
	/** Update data as per particular id
	 * @param array $data : Array with key and value
	 *  @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateData($data, $type = 'access-type') {
		$update = $this->dataArray($data, $type);
		$table = $this->_types[$type]['table'];
		return $this->updateByArray($table, $update, "id = ".$data['ID']);
	}
	
	function dataArray($data, $type) {

		$ID = isset($data['ID']) ? $data['ID'] : 0;
		
		$table = $this->_types[$type]['table'];

		$input_name = str_replace('-', '_', $type).'_name';
		$name = ucwords(str_replace('-', ' ', $type));

		$db_name_field = 'str'.str_replace(' ', '', $name);
				
		$slug = String::generateSEOString($data[$input_name]);
		$slug = generateUniqueName($slug, $ID, $table, 'strSlug', 'id', '1');
					
		$modified = array($db_name_field => $data[$input_name],
						  'strSlug' => $slug,
						  'enmStatus' => '1');
		
		if(isset($data['description'])) {
			$modified['txtDescription'] = $data['description'];
		}
		
		if(isset($data['parent'])) {
			$modified['idParent'] = $data['parent'];
		}
		
		if(isset($data['action']) && $data['action'] == 'add') {
			$modified['dtiCreated'] = TODAY_DATETIME;
			$modified['idCreatedBy'] = $_SESSION[PF.'USERID'];
			$modified['idModifiedBy'] = $_SESSION[PF.'USERID'];
			$modified['dtiModified'] = TODAY_DATETIME;		
		}
		
		return $modified;
	}
	/** getting All master
	 * @param  $where : $where condition with id
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getMasters($where = '1', $type = 'access-type', $order = '') {
		$table = $this->_types[$type]['table'];
		$name = str_replace('-', '_', $type).'_name';
		$orderAdd = (!empty($order)) ? ' order by '.$order : '';
		$sql = "select * from ".$table." where ".$where.$orderAdd;
		return $this->getResults($sql);
	}
	/** getting authorized master related to particular id
	 * @param  $id : $id as per the required
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function authorize_select_master($id, $type = 'access-type')
	{	
		$table = $this->_types[$type]['table'];
		$where = 'where id='.$id;
		$query = "select * from " . $table . " $where";
		return $this->getResult($query);
	}
	/** Authorized Update Master details as per particular id
	 * @param array $data : Array with key and value
	 *              $id:Particular ID
	 *  @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function authorize_update_master($id,$data,$type = 'access-type')
	{	
		$table = $this->_types[$type]['table'];
		$where='id='.$id;
		return $this->updateByArray($table,$data,$where);
	}
	/** unauthorized Update Master details as per particular id
	 * @param array $data : Array with key and value
	 *              $id:Particular ID
	 *  @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function unauthorize_update_master($id,$data,$type = 'access-type')
	{	
		$table = $this->_types[$type]['table'];
		$where='id='.$id;
		return $this->updateByArray($table,$data,$where);
	}
	/** Softdelete Page details from Page details array with particular id
	 * @param array $data : Array of Page
	 *              $id:Particular Page's ID
	 *@return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function delete_update_master($id,$data,$type = 'access-type')
	{	
		$table = $this->_types[$type]['table'];
		$where='id='.$id;
		return $this->updateByArray($table,$data,$where);
	}
	/** Update Assign role as per particular id
	 * @param array $assign_role : Array  with key and value
	 *              $id:Particular ID
	 *  @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateAssignRole($assign_role, $id, $type = 'access-type')
	{	
		$table = $this->_types[$type]['table'];
		$where='id='.$id;
		return $this->updateByArray($table,$assign_role,$where);
	}
	/** Update Master details as per particular id
	 * @param array $data : Array with key and value
	 *              $id:Particular ID
	 *  @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateMaster($data, $id, $type = 'access-type') {
		$table = $this->_types[$type]['table'];
		return $this->updateByArray($table, $data, 'id='.$id);
	}
}
?>