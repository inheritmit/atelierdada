<?php

class account extends db_class
{
	/** @var string
	 * Account master table name
	 */
	protected $_table = 'mst_accounts';

	/** @var string
	 * Account relation table name
	 */
	protected $_log_table = 'rel_account_login_logs';

	/** @var string
	 * Access type master table name
	 */
	protected $_access_type_table = 'mst_access_types';

	/** @var string
	 * Reset password relation table name
	 */
	protected $_reset_password = 'rel_reset_password';

	/** Inserts data into mst_accounts table
	 * @param array $data: array of the table field name and post data of the fields
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertData($data){
		return $this->insertByArray($this->_table, $data);
	}

	/** Updates data of table mst_accounts provided from key->value pairs in an array
	 * @param array $data : array of the data with key->value pair of table fields as a key
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateData($data, $id)
	{
		return $this->updateByArray($this->_table, $data, "id = " . $id);
	}

	/** Get all account data and access details for Account ID provided
	 * @param int $id : Account ID
	 * @return array | int : returns Array of account and access_types table for provided Account ID on success, otherwise returns 404
	 */
	function getAccountDetail($id)
	{
		$sql = "select main.*,desg.strAccessType
				from " . $this->_table . " as main
				inner join " . $this->_access_type_table . " as desg
				on desg.id = main.idDesg
				where main.id = " . $id;
		return $this->getResult($sql);
	}

	/** Get count number of table mst_accounts
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getAccountsCount($where)
	{
		$sql = "select count(main.id) as total_rows from " . $this->_table . " as main where " . $where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

	/** Check the password is right for provided account
	 * @param string $password : password for the account
	 * @return bool : true if password is right, otherwise false
	 */
	function checkPassword($password)
	{
		$hash_password = $this->hashEmail($password);
		$sql = "select count(id) as total_rows from " . $this->_table . " where password = '" . $hash_password . "'
                and id = " . $_SESSION[PF . 'USERID'];
		$data = $this->getResult($sql);

		if ($data['total_rows'] > 0) return true;
		else return false;
	}

	/** Converted into HASH
	 * @param string $password : password for the account
	 * @return string : it return password hash
	 */
	function hashEmail($password)
	{
		return sha1(PASSWORD_HASH . $password);
	}

	/** It provide the checkSum as per the provide filename
	 * @param string $filename : particular file name
	 * @return string : it return code
	 */
	function checkSum($filename)
	{
		$sha1 = sha1($filename);
		$number = preg_replace("/[^0-9,.]/", "", $sha1);
		$code = substr($number, 5, 16);
		return $code;
	}


	/** Inserts data into mst_accounts table
	 * @param array $data: array of the table field name and post data of the fields
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function registerAccount($data)
	{
		$reg_data = $this->regArray($data);
		return $this->insertByArray($this->_table, $reg_data);
	}

	/** It Create the array as per the $data array
	 ** @param array $data :data array with filed name and value
	 * @return array : it return Array with value and data
	 */
	function regArray($data)
	{
		$modified = array(
            'strFirstName' => $data['first_name'],
			'strLastName' => $data['last_name'],
			'strEmail' => $data['email'],
			'strPassword' => $data['password'],
			'dtiCreated' => TODAY_DATETIME);
		return $modified;
	}

	/** Get Registration count number of table mst_accounts
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getRegistrationsCount($where = '1')
	{
		$sql = "select count(id) as total_rows from " . $this->_table . " as reg where " . $where;
		$data = $this->getResult($sql);

		return $data['total_rows'];
	}

	/** Get Registered member data number of table mst_accounts
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getRegistrations($where = '1')
	{
		$sql = "select main.*
				from " . $this->_table . " as main
				where " . $where;
		return $this->getResults($sql);
	}

	/** Get Registered data of table mst_accounts
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getRegistrationDetails($where)
	{
		$sql = "select main.*
				from " . $this->_table . " as main
				where " . $where;
		return $this->getResult($sql);
	}

	/** Get Registered data of table mst_accounts
	 * @param string $email : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getRegistrationByEmail($email)
	{
		$where = "reg.txtCompanyEmail = '" . $email . "'";
		return $this->getRegistrationDetails($where);
	}

	/** Get Registered data number of table mst_accounts
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getRegistrationByID($id)
	{
		$where = "id = " . $id;
		return $this->getRegistrationDetails($where);
	}

	function insertAccount($data)
	{
		$modified = $this->accountArray($data);
		return $this->insertByArray($this->_table, $modified);
	}

	function accountArray($data)
	{
		$modified = array(
			'strFullName' => $data['name'],
			'email' => @$data['strEmail'],
			'idCreatedBy' => $_SESSION[PF . 'USERID'],
			'dtiCreated' => TODAY_DATETIME,
			'idModifiedBy' => $_SESSION[PF . 'USERID'],
			'dtiModified' => TODAY_DATETIME,
			'tinStatus' => 0,
			'idDesg' => $data['access']
		);

		if (isset($data['password']) && !empty($data['password'])) {
			$modified['password'] = $data['password'];
		}

		if ($data['no-email'] == 1) {
			unset($modified['strEmail']);
			$modified['status'] = '1';
			$modified['strTempPassword'] = $data['temp_pwd'];
		}

		return $modified;
	}

	/** getting accounts detail from where condition
	 * @param $where       : Where means particular condition
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getAccounts($where)
	{
		$sql = "select main.*, at.strAccessType as atName
				from " . $this->_table . " as main
				inner join " . $this->_access_type_table . " as at
					on at.id = main.idDesg 
				where " . $where;
		return $this->getResults($sql);
	}

	/** getting account detail from ID as per the condition
	 * @param $id : id to the particular account
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function getAccountByID($id)
	{
		$sql = "select main.*
				from " . $this->_table . " as main
				where main.id = " . $id;
		return $this->getResult($sql);
	}

	/** getting account detail from where condition
	 * @param $where       : Where means particular condition
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function getAccount($where)
	{
		$sql = "select main.*
				from " . $this->_table . " as main
				where " . $where;
		return $this->getResult($sql);
	}

	/** This function will check whether it is a valid Account OR not
	 * @param $id          : particular id
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function checkAccount($id)
	{
		$query = "SELECT * from " . $this->_table . " where enmStatus = '1' and enmDeleted = '0' and id = '" . $id . "'";
		return $this->getResult($query);
	}

	/** Inserts data into rel_reset_password table
	 * @param array $data: array of the table field name and post data of the fields
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function addResetToken($data)
	{
		$this->insertByArray($this->_reset_password, $data);
	}
	/* Get reset-token from rel_reset_password and mst_account tables with matching ID in both.
              @params $emailId:strEmailId from mst_account,
                      $token:strToken from rel_reset_password
              @return:single array resultset return.
    */
	function getResetToken($emailId, $token) {
		 $sql = "select reset.*
				from ".$this->_reset_password." as reset
				inner join ".$this->_table." as main
					on main.id = reset.vId and main.strEmail = '".$emailId."'
				where reset.token = '".$token."'";
		return $this->getResult($sql);
	}

	/** Update data from account table
	   @params $this->_table: mst_account,
	   $where: id of the account table to update,
	   $data:data array with fields and value
	*/
	function updateAccount($data, $where)
	{
		return $this->updateByArray($this->_table, $data, $where);
	}

	/** Inserts data into rel_account_login_logs table
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function loginLog(){
		$data = array(
            'vId' => $_SESSION[PF . 'USERID'],
			'loginDate' => TODAY_DATETIME,
			'session' => $_SESSION[PF . 'MAIN'],
			'ipAddress' => USERIP);
		$this->insertByArray($this->_log_table, $data);
	}

	/** This function check Login as well as duplication of Mobile or Email id at the time of registation
	 * @param string $email : email as checking
	 * @return it returns single result otherwise 404
	 */
	function checkEmail($email, $for = 'registration')
	{
		$table = ($for == 'registration') ? $this->_reg_table : $this->_table;
		$where = ($for == 'registration') ? "txtCompanyEmail = '" . $email . "'" : "email = '" . $email . "'";
		$sql = "select count(id) as total_rows from " . $table . " where " . $where;
		$data = $this->getResult($sql);
		if ($data['total_rows'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	/** This function check Login as well as duplication of Mobile or Email id at the time of registation
	 * @param string $username : email as checking
	 * @return it returns single result otherwise 404
	 */
	function checkLogin($username, $password = '')
	{
		$mainAdd = " AND main.strEmail = '" . $username . "'";
		if (!empty($password)) {
			$mainAdd .= " AND main.tinStatus = '1' AND main.strPassword = '" . $password . "'";
		}

		$sql = "select main.id, strEmail, strFirstName, strLastName, idDesg, strImageName
				from " . $this->_table . " as main
				where main.enmDeleted = '0'" . $mainAdd;
		return $this->getResult($sql);
	}

	/** Getting Access to particular Designation
	 * @param string $desg_id : designation_id for getting rights
	 * @return Array:it returns results set with array
	 */
	function getAccessRights($desg_id)
	{
		$sql = "select txtModules, txtActions, id
				from " . $this->_access_type_table . "
				where id = " . $desg_id;
		$data = $this->getResults($sql);

		if ($data != 404) {
			foreach ($data as $d) {
				$this->_rights['actions'] = unserialize($d['txtActions']);
				$this->_rights['modules'] = unserialize($d['txtModules']);
			}
		}
	}

	/** Check the Module With Access Right as per the condition
	 * @param string $module : password for the account,
	 *                       $action: Particular action like Edit,Add,List particular modules
	 * @return bool : true if module have particular rights, otherwise false
	 */
	function checkAccess($module, $action)
	{
		if (!isset($this->_rights['actions']) || !is_array($this->_rights['actions'])) return true;

		if (isset($this->_rights['actions'][$module])) {

			if (in_array($action, array_keys($this->_rights['actions'][$module]))) {
				return true;
			}

			return false;
		}

		return false;
	}

	/** Check the Module's Rights
	 * @param string $module : pass particular module name
	 * @return bool : true if module have particular rights, otherwise false
	 */
	function checkModule($module)
	{
		if (!isset($this->_rights['modules']) || !is_array($this->_rights['modules'])) return true;

		if (in_array($module, $this->_rights['modules'])) {
			return true;
		} else {
			return false;
		}
	}
} ?>