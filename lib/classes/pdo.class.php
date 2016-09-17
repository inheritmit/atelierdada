<?php
/**
 * This class aids in MySQL database connectivity using PDO. It was
 * written with my specific needs in mind.
 */

/**
 * It simplifies the database tasks I most often need to do thus reducing
 * redundant code.  It is also written with the mindset to provide easy means
 * of debugging erronous sql and data during the development phase of a
 * web application.
 *
 * The future may call for adding a slew of other features, however, at
 * this point in time it just has what I often need.  I'm not trying to
 * re-write phpMyAdmin or anything.  :)  Hope you find it  useful.
 *
 ******************************************************************************
 *                         MySQL Database Class
 *******************************************************************************
 *      Author:     Mitesh Tandel
 *      Email:      mits.tandel@gmail.com
 *
 *      File:       db.class.php
 *      Version:    2.0.0
 *      Copyright:  (c) 2015 - Mitesh Tandel
 *                  You are free to use, distribute, and modify this software
 *                  under the terms of the GNU General Public License.  See the
 *                  included license.txt file.
 *
 *******************************************************************************
 *  VERSION HISTORY:
 *
 *      v1.0.0 [01.11.2008] - Initial release
 *      v1.0.2 [20.09.2010] - Added the paging functions
 *      v1.1.0 [04.08.2013] - Replaced all mysql functions with PDO
 *      v2.0.0 [02.09.2015] - Multiple query execution removed and major bug
 *                            fixes
 *
 *******************************************************************************
 */

// constants used by class

define('MYSQL_TYPES_NUMERIC', 'int real double');
define('MYSQL_TYPES_DATE', 'datetime timestamp year date time ');
define('MYSQL_TYPES_STRING', 'string blob varchar char');

/**
 * This class aids in MySQL database connectivity using PDO.
 */
class db_class
{
    /** @var  string
     * Holds the last error string from the PDO exception
     */
    var $last_error;

    /** @var  string
     * Holds the last query executed
     */
    var $last_query;

    /** @var  int
     * Holds the last insert id from insert statement
     * Used for insert statements only
     */
    var $last_insert_id;

    /** @var  string
     * MySQL host to connect to
     */
    private $host;

    /** @var  string
     * MySQL username for the host
     */
    private $user;

    /** @var  string
     * MySQL password for the host
     */
    private $pw;

    /** @var  string
     * MySQL database to be used
     */
    private $db;

    /** @var  object
     * MySQL database to be used
     */
    private $stmt;           // Holds sql statement

    /** @var  object
     * Current/last database link identifier
     */
    var $conn;

    /** @var  boolean
     * The class will add/strip slashes when it can
     *
     * Default is true
     */
    var $auto_slashes = true;

    /** @var  int
     * Holds the total rows from the last query
     * For select statements it holds total number of rows to be fetched
     * For insert/update statements it holds total affected rows
     */
    var $total_rows;

    /** @var  int
     * Holds the number of rows per page
     *
     * Default is 20 rows per page
     */
    var $perpage = 20;

    /** @var  int
     * Holds the number of pages for number of rows fetched
     */
    var $pages;

    /** @var  boolean
     * Display page links or not
     *
     * true to display page links
     * false to hide page links
     */
    var $page_link;

    /** @var  boolean
     * Compress the paging with dots for more than 10 pages
     *
     * true to compressed paging
     * false to simple paging
     *
     * Default is false
     */
    var $compress_link = false;

    /** @var  string
     * Display type of the next/previous links in paging
     * text to display Next/Prev text links
     * arrow to display arrows instead of text links
     */
    var $display_type;

    /** @var bool
     * Display total records with paging
     *
     * true to display total records
     * false to not display total records
     *
     * Default is false
     */
    var $display_records = false;

    /** @var bool
     * Use seo friendly links or simple links for paging
     *
     * true to use seo friendly links
     * false to use simple links
     *
     * Default is false
     */
    var $htaccess = false;

    /** @var string
     * Transaction ID of the transaction
     */
    var $trans_id;

    /** @var array
     * Array of each transactions and its status
     */
    var $error = array();

    /** @var bool
     * Use of AJAX in paging
     *
     * true to AJAX is used
     * false to AJAX not used
     *
     * Default is false
     */
    var $ajax = false;

    /** @type array
     * Prepare statement data array for select statements
     */
    var $prepare;

    /** Constructor of the class
     *    Setup your own default values for connecting to the database here. You
     *    can also set these values in the connect() function
     */
    function db_class()
    {

        $this->host = DB_SERVER;
        $this->user = DB_USERNAME;
        $this->pw = DB_PASSWORD;
        $this->db = DB_SCHEMA;

        $this->connect();
    }

    /**
     * Connects the database using access details provided
     * @param string $host : host name/ip address of the connecting database server
     * @param string $user : username for the database
     * @param string $pw : password for the database
     * @param string $db : database name to be connected
     * @param string $type : format of the data for unicode
     * @return bool : true if connected successfully else false
     */
    function connect($host = '', $user = '', $pw = '', $db = '', $type = 'utf8')
    {

        if (!empty($host)) $this->host = $host;
        if (!empty($user)) $this->user = $user;
        if (!empty($pw)) $this->pw = $pw;
        if (!empty($db)) $this->db = $db;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pw, $options);
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            $this->printLastError();
            return false;
        }

        return true;  // success
    }

    /** Start the db transaction for multiple queries */
    function start()
    {
        return $this->conn->beginTransaction();
    }

    /** Stops the db transaction and commit if successful
     *    else rollback all transaction on failure
     */
    function stop()
    {
        if (!$this->error[$this->trans_id])
            $this->conn->commit();
        else
            $this->conn->rollBack();

        unset($this->trans_id);
    }

    /** Performs an SQL query and returns the result pointer or false
     *  if there is an error.
     * @param string $sql : sql statement to be executed
     * @return bool|object : returns result-set on success otherwise return false
     */
    function select($sql)
    {
        $this->last_query = $sql;

        try {
            if(isset($this->prepare) && sizeof($this->prepare) > 0) {
                $r = $this->conn->prepare($sql);
                $r->execute($this->prepare);
            } else {
                $r = $this->conn->query($sql);
            }
            $this->total_rows = $r->rowCount();
            unset($this->prepare);
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            $this->printLastError();
            return false;
        }

        return $r;
    }


    public function setPrepare($data) {

        if(!isset($data) || sizeof($data) == 0) {
            $this->last_error = "You must pass an array to the setPrepare() function";
            $this->printLastError();
            return false;
        }

        $this->prepare = $data;
    }

    /** Delete row from the table provided according to where condition
     * @param string $table : Name of the table
     * @param string $where : condition on which rows will be deleted
     * @return bool: returns true on success, otherwise return false
     */
    function deleteRows($table, $where)
    {
        $sql = "delete from $table where $where";
        return $this->executeSql($sql);
    }

    /** Returns a rows of data from the query result.
     * You can specify the type of results you want.
     * @param object $result : query result-set
     * @param string $type : format of results to be fetched
     * @return array $row : array of rows with results as specified format
     */
    function getRows($result, $type = 'MYSQL_BOTH')
    {
        if ($type == 'MYSQL_ASSOC') $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($type == 'MYSQL_NUM') $rows = $result->fetchAll(PDO::FETCH_NUM);
        if ($type == 'MYSQL_BOTH') $rows = $result->fetchAll(PDO::FETCH_BOTH);

        return $rows;
    }

    /** Returns a single row of data from the query result.
     * You can specify the type of results you want.
     * @param object $result : query result-set
     * @param string $type : format of results to be fetched
     * @return array $row : array of single row with results as specified format
     */
    function getRow($result, $type = 'MYSQL_BOTH')
    {
        if ($type == 'MYSQL_ASSOC') $row = $result->fetch(PDO::FETCH_ASSOC);
        if ($type == 'MYSQL_NUM') $row = $result->fetch(PDO::FETCH_NUM);
        if ($type == 'MYSQL_BOTH') $row = $result->fetch(PDO::FETCH_BOTH);

        return $row;
    }

    /** Inserts data in the table via SQL query.
     * First prepare the SQL query and then execute.
     * @param string $sql : SQL statement for insert query
     * @param array $data : Array of data to be inserted with respected to query fields
     * @return bool|int : return false on error, otherwise return last inserted id
     */
    function insertRow($sql, $data)
    {
        $this->last_query = $sql;

        try {
            $r = $this->conn->prepare($sql);
            $r->execute($data);
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            $this->printLastError();
            return false;
        }

        $this->last_insert_id = $this->conn->lastInsertId();
        return $this->last_insert_id;
    }

    /** Updates data in the table via SQL query.
     * First prepare the SQL query and then execute.
     * @param string $sql : SQL statement for update query
     * @param array $data : Array of data to be updated with respected to query fields
     * @return bool|int : return false on error, otherwise return affected rows on update
     */
    function updateRow($sql, $data)
    {
        $this->last_query = $sql;

        try {
            $r = $this->conn->prepare($sql);
            $r->execute($data);
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            $this->printLastError();
            return false;
        }

        $rows = $r->rowCount();
        return $rows;
    }

    /** Execute any SQL query
     * @param string $sql : SQL query to be executed
     * @return bool|object : returns result-set object if success, otherwise return false
     */
    function executeSql($sql)
    {
        $this->last_query = $sql;

        try {
            $r = $this->conn->query($sql);
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            $this->printLastError();
            return false;
        }

        return $r;
    }

    /** Inserts a row into the database table from field to value pairs in an array
     * @param string $table: name of the table for insertion
     * @param array $data: array of the data with key->value pair of table fields as a key
     * @return bool|int : id of the row inserted otherwise false on failure
     */
    function insertByArray($table, $data)
    {

        if (empty($data)) {
            $this->last_error = "You must pass an array to the insertByArray() function.";
            $this->printLastError();
            return false;
        }

        if (!isset($this->column_types[$table])) {
            $this->getColumnNames($table);
        }

        $cols = '(' . implode(", ", array_keys($data)) . ')';
        $new_data = array();

        foreach ($data as $key => $value) {     // iterate values to input

            if (!isset($this->column_types[$table][$key])) {
                $this->last_error = "Undefined column '" . $key . "'";
                $this->printLastError();
                return false;  // error!
            } else {
                $col_type = $this->column_types[$table][$key];
            }

            $k = ":$key";
            $new_data[$k] = $value;
        }

        $values = '(' . implode(", ", array_keys($new_data)) . ')';

        // insert values
        $sql = "INSERT INTO $table $cols VALUES $values";
        return $this->insertRow($sql, $new_data);
    }

    /** Updates a row into the database table provided from key->value pairs in an array
     * @param string $table : name of the table to be updated
     * @param array $data : array of the data with key->value pair of table fields as a key
     * @param string $condition : a WHERE clause (without the WHERE)
     * @return the number or row affected or true if no rows needed the update otherwise false on failure
     */
    function updateByArray($table, $data, $condition)
    {

        if (empty($data)) {
            $this->last_error = "You must pass an array to the updateByArray() function.";
            $this->printLastError();
            return false;
        }

        $new_data = array();

        $sql = "UPDATE $table SET";
        foreach ($data as $key => $value) {     // iterate values to input

            $sql .= " $key=";

            $k = ":$key";
            $new_data[$k] = $value;

            $sql .= ":$key,";
        }

        $sql = rtrim($sql, ','); // strip off last "extra" comma
        if (!empty($condition)) $sql .= " WHERE $condition";

        return $this->updateRow($sql, $new_data);
    }

    /** Gets data type information of a particular column.
     * @param string $table: name of the table in which the column available
     * @param string $column: name of the column
     * @return array : an array with the field info or false if there is an error.
     */
    function getColumnType($table, $column)
    {
        if (!isset($this->column_types[$column])) {
            $this->getColumnNames($table);
        }
        return $this->column_types[$column];
    }

    /** Get all column data type information for table provided
     * @param string $table : name of the table
     * @return bool : true if columns available, otherwise false if there is an error
     */
    function getColumnNames($table)
    {

        $sql = 'SHOW COLUMNS FROM ' . $table;

        $this->stmt = $this->conn->prepare($sql);

        try {
            if ($this->stmt->execute()) {
                $raw_column_data = $this->stmt->fetchAll();

                foreach ($raw_column_data as $outer_key => $array) {
                    foreach ($array as $inner_key => $value) {

                        if ($inner_key === 'Field') {
                            if (!(int)$inner_key) {
                                $field = $value;
                            }
                        }

                        if ($inner_key === 'Type') {
                            if (!(int)$inner_key) {
                                $this->column_types[$table][$field] = $value;
                            }
                        }
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            $this->last_error = $e->getMessage();
            $this->printLastError();
            return false;
        }
    }

    /** Fetch the results from the query provided
     * Use $result variable to fetch limited records
     * @param string $sql : SQL statement to be executed
     * @param int $page : No of the page whose records to be displayed
     * @param string $result : Display all or paged records
     * @return int|array : return 404 if no data available for the query,
     *                     otherwise return array of results
     */
    function getResults($sql, $page = 1, $result = 'all')
    {
        if ($result == 'paged') {
            $result = $this->select($this->pageNo($sql, $page));
        } else {
            $result = $this->select($sql);
        }

        $data = $this->getRows($result, 'MYSQL_ASSOC');

        if (!$data) {
            return 404;
        }

        return $data;
    }

    /** Fetch the results from the query provided
     * Use $result variable to fetch limited records
     * @param string $sql : SQL statement to be executed
     * @return int|array : return 404 if no data available for the query,
     *                     otherwise return array of results
     */
    function getResult($sql)
    {
        $result = $this->select($sql);
        $data = $this->getRow($result, 'MYSQL_ASSOC');

        if (!$data) {
            return 404;
        }

        return $data;
    }

    /** Set the per page records value for paging
     * @param int $value : per page value to be set
     */
    function perPage($value = 20)
    {
        $this->perpage = $value;
    }

    function pageLink($value = false)
    {
        $this->page_link = $value;
    } // End: pageLink

    function compressLink($value = false)
    {
        $this->compress_link = $value;
    }

    function setHtaccess($value = false)
    {
        $this->htaccess = $value;
    }

    function displayType($value = 'text')
    {
        $this->display_type = $value;
    }

    function totalPages()
    {
        if (!$this->perpage) {
            $this->perPage();
        }
        if ($this->total_rows) {
            //echo $this->perpage;
            if ($this->total_rows % $this->perpage == 0) {
                $this->pages = $this->total_rows / $this->perpage;
            } else {
                $this->pages = ceil($this->total_rows / $this->perpage);
            }
        }
    } // End: totalPages

    function totalPagesByCount($count)
    {
        if (!$this->perpage) {
            $this->perPage();
        }
        if ($count > 0) {
            //echo $this->perpage;
            if ($count % $this->perpage == 0) {
                $this->pages = $count / $this->perpage;
            } else {
                $this->pages = ceil($count / $this->perpage);
            }
        }
    } // End: totalPagesByCount

    function changePageValue($q_string, $to_change = 0, $setv = 0)
    {
        if ($this->htaccess) {
            $new_query = '';
            if (strpos($q_string, '?')) {
                $url_content = explode('?', $q_string);
                $q_string = $url_content[0];
                $new_query = '?' . $url_content[1];
            }

            if (stristr($q_string, "page")) {
                $values = explode("/", $q_string);
                //print_r($values);
                for ($i = 0; $i < sizeof($values); $i++) {
                    if (stristr($values[$i], "page")) {
                        if ($setv) {
                            $values[$i + 1] = $setv;
                        } else {
                            if ($to_change) {
                                $values[$i + 1] += $to_change;
                            } else {
                                $values[$i + 1]--;
                            }
                        }
                    }
                }
                return implode("/", $values) . $new_query;
            } else {
                if ($setv) {
                    return $q_string . "/page/" . $setv . $new_query;
                } else if ($this->pages > 1) {
                    return $q_string . "/page/2" . $new_query;
                } else {
                    return $q_string . $new_query;
                }
            }
        } else {
            if (stristr($q_string, "pg")) {
                $values = explode("&", $q_string);
                //print_r($values);
                for ($i = 0; $i < sizeof($values); $i++) {
                    if (stristr($values[$i], "pg")) {
                        if ($setv) {
                            $value = explode("=", $values[$i]);
                            $value[1] = $setv;
                            $values[$i] = $value[0] . "=" . $value[1];
                        } else {
                            $value = explode("=", $values[$i]);
                            if ($to_change) {
                                $value[1] += $to_change;
                            } else {
                                $value[1]--;
                            }
                            $values[$i] = $value[0] . "=" . $value[1];
                            //print_r($values);
                        }
                    }
                }
                return implode("&", $values);
            } else {
                if ($setv) {
                    return $q_string . "&pg=" . $setv;
                } else if ($this->pages > 1) {
                    return $q_string . "&pg=2";
                } else {
                    return $q_string;
                }
            }
        }
    } // End: changePageValue

    function changePageLink($q_string, $to_change)
    {
        //$q_string = $_SERVER['HTTP_HOST'].$q_string;

        if ($this->htaccess) {

            $new_query = '';
            if (strpos($q_string, '?')) {
                $url_content = explode('?', $q_string);
                $q_string = $url_content[0];
                $new_query = '?' . $url_content[1];
            }

            if (stristr($q_string, "page")) {
                $values = explode("/", $q_string);
                for ($i = 0; $i < sizeof($values); $i++) {
                    if (stristr($values[$i], "page")) {
                        $values[$i + 1] = $to_change;
                    }
                }
                return implode("/", $values) . $new_query;
            } else {
                if ($to_change) {
                    $link = $q_string . "/page/" . $to_change . $new_query;
                } else if ($this->pages > 1) {
                    $link = $q_string . "/page/2" . $new_query;
                } else {
                    $link = '' . $new_query;
                }
                return $link;
            }
        } else {
            if (stristr($q_string, "pg")) {
                $values = explode("&", $q_string);
                //print_r($values);
                for ($i = 0; $i < sizeof($values); $i++) {
                    if (stristr($values[$i], "pg")) {
                        $value = explode("=", $values[$i]);
                        $value[1] = $to_change;
                        $values[$i] = $value[0] . "=" . $value[1];
                    }
                }
                return implode("&", $values);
            } else {
                if ($to_change) {
                    return $q_string . "&pg=" . $to_change;
                } else if ($this->pages > 1) {
                    return $q_string . "&pg=2";
                } else {
                    return $q_string;
                }
            }
        }
    } // End: changePageLink

    function getHidden($q_string)
    {
        $varf = '';
        $values = explode("&", $q_string);

        for ($i = 0; $i < sizeof($values); $i++) {
            $value = explode("=", $values[$i]);

            if ($value[0] != "pg") {
                $varf .= str_replace(array('##H_NAME##', '##H_VAL##'), array($value[0], $value[1]), HIDDEN_VAR);
            }
        }
        return $varf;
    } // End: getHidden

    function removeChar($q_string, $char)
    {
        $values = explode("&", $q_string);

        for ($i = 0; $i < sizeof($values); $i++) {
            $value = explode("=", $values[$i]);

            if ($value[0] == "_") unset($values[$i]);
        }

        return implode("&", $values);
    } // End: removeChar

    function printPages($pg)
    {

        $request = explode("?", $_SERVER['REQUEST_URI']);

        $method = $_SERVER["REQUEST_METHOD"];
        $qstring = ($this->htaccess) ? $_SERVER['REQUEST_URI'] : $_SERVER["QUERY_STRING"];
        $qstring = ($this->ajax) ? $_SESSION['PATH'] : $qstring;
        $self_path = (isset($_SESSION['PATH'])) ? $_SESSION['PATH'] : $request[0];
        $self = ($this->htaccess) ? 'http://' . $_SERVER['SERVER_NAME'] : $self_path;
        $sep = ($this->htaccess) ? '' : '?';
        $server = $_SERVER["SERVER_NAME"];

        $qstring = $this->removeChar($qstring, '_');

        if ($method == "GET" || $this->ajax) {
            $no_first = $this->changePageValue($qstring, 0, 1);
            $no_previous = $this->changePageValue($qstring, 0);
            $no_next = $this->changePageValue($qstring, 1);
            $no_last = $this->changePageValue($qstring, 0, $this->pages);
        }

        if ($pg == 1) {
            $first = FIRST1;
        } else {
            $first = FIRST2;
        }
        if (($pg - 1) > 0) {
            $previous = PREV2;
        } else {
            $previous = PREV1;
        }
        if (($this->pages - $pg) > 0) {
            $next = NEXT2;
        } else {
            $next = NEXT1;
        }
        if ($pg == $this->pages) {
            $last = LAST1;
        } else {
            $last = LAST2;
        }
        if (!$pg) {
            $pg = 1;
        }

        $page_list = '';
        if ($this->pages > 10) {
            $page_jump = PAGE_JUMP;

            $page_list .= '<select name="pg" onchange="this.form.submit()">' . "\n";
            for ($p = 1; $p <= $this->pages; $p++) {
                if ($p == $pg)
                    $page_list .= str_replace(array('##CURRENT_PAGE##', '##SELECTED##'), array($p, "selected='selected'"), CURRENT_PAGE_OPTION) . "\n";
                else
                    $page_list .= str_replace('##CURRENT_PAGE##', $p, PAGE_OPTION) . "\n";
            }
            $page_list .= '</select>' . "\n";
        }

        $total_records = TOTAL_RECORDS;

        if ($this->page_link) {
            $actual = ACTUAL_PAGE;
            $elements['##TOTAL_PAGES##'] = $this->pages;
            $elements['##PAGE##'] = $pg;
        } else {
            $actual = '';
            $front = '';
            $end = '';
            $start = 1;
            if ($this->compress_link) {
                $left = 2;
                $right = 2;

                $start = 1;
                $fend = ($this->pages < 10) ? $this->pages : 3;
                $estart = ($this->pages) - 2;

                if ($pg > 1 && $pg - $left - 1 <= $fend && $pg + $right < $this->pages)
                    $fend = $pg + $right;

                if ($pg < $this->pages && $pg + $right + 1 >= $estart)
                    $estart = $pg - $right;

                /*$start = (($pg-$left) > 1 || ($pg+$right) <= $this->pages) ? ($pg-$left) : ((($pg+$right) > $this->pages) ? ($this->pages-(10-1)) : 1);*/
                for ($p = 1; $p <= $fend; $p++) {
                    $class = ($pg == $p) ? ' class="current_page"' : '';
                    $actual .= str_replace(array('##CURRENT_PAGE##', '##CURRENT_LINK##', '##CURRENT_CLASS##'), array($p, $this->changePageLink($qstring, $p), $class), PAGE_LIST);
                }

                if ($this->pages > 10) {
                    $end = (($pg + $right) <= $this->pages) ? ($pg + $right) : $this->pages;
                    $actual .= '...';

                    if ($pg > $left + 3 + 1 && $pg < $this->pages - $right - 3) {
                        $start = $pg - $left;
                        $end = $pg + $right;

                        for ($p = $start; $p <= $end; $p++) {
                            $class = ($pg == $p) ? ' class="current_page"' : '';
                            $actual .= str_replace(array('##CURRENT_PAGE##', '##CURRENT_LINK##', '##CURRENT_CLASS##'), array($p, $this->changePageLink($qstring, $p), $class), PAGE_LIST);
                        }

                        $actual .= '...';
                    }

                    for ($p = $estart; $p <= ($this->pages); $p++) {
                        $class = ($pg == $p) ? ' class="current_page"' : '';
                        $actual .= str_replace(array('##CURRENT_PAGE##', '##CURRENT_LINK##', '##CURRENT_CLASS##'), array($p, $this->changePageLink($qstring, $p), $class), PAGE_LIST);
                    }
                }

                /*for($p=1;$p<=$this->pages;$p+=10)
                {
                    if($p < ($start-5))
                        $front .= str_replace(array('##CURRENT_PAGE##', '##CURRENT_LINK##'), array($p, $this->changePageLink($qstring,$p)), PAGE_LIST);

                    if($p > ($end+5))
                        $end .= str_replace(array('##CURRENT_PAGE##', '##CURRENT_LINK##'), array($p, $this->changePageLink($qstring,$p)), PAGE_LIST);
                }
                $actual = $front.$actual.$end;*/
            } else {
                for ($p = 1; $p <= $this->pages; $p++) {
                    $class = ($pg == $p) ? ' class="current_page"' : '';
                    $actual .= str_replace(array('##CURRENT_PAGE##', '##CURRENT_LINK##', '##CURRENT_CLASS##'), array($p, $this->changePageLink($qstring, $p), $class), PAGE_LIST);
                }
            }
        }

        $elements = array('##SELF##' => $self,
            '##SEP##' => $sep,
            '##NO_FIRST##' => $no_first,
            '##NO_LAST##' => $no_last,
            '##NO_PREV##' => $no_previous,
            '##NO_NEXT##' => $no_next,
            '##TOTAL##' => $this->total_rows,
            '##PAGE_LIST##' => $page_list);

        if ($this->display_type == 'arrow') {
            $additional = array('##FIRST##' => FIRST_ARROW,
                '##LAST##' => LAST_ARROW,
                '##NEXT##' => NEXT_ARROW,
                '##PREV##' => PREVIOUS_ARROW);
        } else {
            $additional = array('##FIRST##' => FIRST_TEXT,
                '##LAST##' => LAST_TEXT,
                '##NEXT##' => NEXT_TEXT,
                '##PREV##' => PREVIOUS_TEXT);
        }

        $elements = array_merge($elements, $additional);

        $to_print = '';
        /*if($this->pages > 10)
            $to_print .=  $page_jump;*/

        if ($this->display_records)
            $to_print .= $total_records;

        $to_print .= $first . $previous . $actual . $next . $last;

        foreach ($elements as $key => $value) {
            $to_print = str_replace($key, $value, $to_print);
        }

        /*if($this->pages > 10)
            echo str_replace(array('##ACTION##', '##HIDDEN##', '##PAGING##'), array($self, $this->getHidden($qstring), $to_print), PAGE_FORM);
        else*/
        //echo $to_print;exit;
        return $to_print;//changes on 27-02-2013 By Ankur Doshi
    } // End: printPages

    function pageNo($sql, $pg)
    {
        if (!$this->perpage) {
            $this->perPage();
        }
        if ($pg == 1) {
            $begin = 0;
        } else {
            if ($pg > $this->pages) {
                $pg = $this->pages;
            }
            $begin = ($pg - 1) * $this->perpage;
        }
        if ($sql) {
            $sql .= " LIMIT $begin," . $this->perpage;
            return $sql;
        }
    } // End: pageNo

    /** Displays last database error to the screen with query if $show_query is true
     * @param bool $show_query : Display query with error or not
     */
    function printLastError($show_query = true)
    {
        if (isset($this->trans_id)) $this->error[$this->trans_id] = true;

        if ($show_query && (!empty($this->last_query)) && ENV == 1) {
            $this->printLastQuery();
        }

        $error_array = array(
            'strRequestUri' => $_SERVER['REQUEST_URI'],
            'intErrorNo' => 0,
            'txtDescription' => $this->last_error . (($show_query && (!empty($this->last_query))) ? '<br /> ' . $this->last_query : ''),
            'txtSqlQuery' => (!empty($this->last_query) ? $this->last_query : ''),
            'dtiCreated' => TODAY_DATETIME,
            'enmStatus' => 'New'
        );

        $this->insertByArray('mst_errors', $error_array);

        if (ENV == 1) {

            echo '<div style="border: 1px solid red; font-size: 9pt; font-family: monospace; color: red; padding: .5em; margin: 8px; background-color: #FFE2E2">
		 <span style="font-weight: bold">Error:</span><br> ';
            echo $this->last_error;
            echo '</div>';

            exit();
        }
    }

    /** Display last query if error occurs during execution */
    function printLastQuery()
    {
        echo '<div style="border: 1px solid blue; font-size: 9pt; font-family: monospace; color: blue; padding: .5em; margin: 8px; background-color: #E6E5FF"><span style="font-weight: bold">Last SQL Query:</span> ' . str_replace("\n", " ", $this->last_query) . '</div>';
    }
}

?>