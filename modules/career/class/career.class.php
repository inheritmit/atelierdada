<?php 
class career extends db_class {

	/** @var string
	 * Pages master table name
	 */
	protected $_table = 'mst_career';

    protected $_join_us = 'mst_joinus';

	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertData($data) {
		return $this->insertByArray($this->_table, $data);
	}

	function insertJoinusData($data) {
		return $this->insertByArray($this->_join_us, $data);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getCareers($where){
		$sql = "select * from ".$this->_table." where ".$where;
		return $this->getResults($sql);
	}

	function getJoinUs($where){
		$sql = "select * from ".$this->_join_us." where ".$where;
		return $this->getResults($sql);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int : Send particular count
	 */
	function getCareersCount($where) {

	    $sql = "select count(id) as total_rows from " . $this->_table . " where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];


	}

	function getJoinUsCount($where) {

		$sql = "select count(id) as total_rows from " . $this->_join_us . " where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];


	}
	/** Update content details from Content details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function updateData($data) {
		return $this->updateByArray($this->_table,$data,"id = ".$_POST['id']);
	}

	/** Softdelete content details from Content details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function deleteData($id,$data){
		$where='id='.$id;
		return $this->updateByArray($this->_table,$data,$where);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getCareer($where){
		$sql = "select * from ".$this->_table." where ".$where;
		return $this->getResult($sql);
	}
}