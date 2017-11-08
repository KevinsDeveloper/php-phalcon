<?php

namespace plugins\pdo;

use PDO;
use PDOException;

/**
 * Class Mssql
 * @package plugins\pdo
 */
class Mssql
{
    private $DBH;
    private $numrows;
    private $queryCount;
    private $batch = false;
    private $batchQueue;

    /**
     * Initializes the connection with the database. Only needs to be called once.
     * @param $db_type
     * @param $db_host
     * @param $db_name
     * @param $db_user
     * @param $db_pass
     * @param int $error_level
     * @return $this|bool
     * @throws \Exception
     */
    public function __construct($db_type, $db_host, $db_name, $db_user, $db_pass, $error_level = 0)
    {
        try {
            // Initialize database
            if ($this->DBH == null)
                $this->DBH = new PDO($db_type . ':host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_pass);
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return false;
        }

        // Set error level
        if ($error_level == 1)
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        else
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Set counters
        $this->queryCount = array(
            'select' => 0,
            'sql' => 0,
            'insert' => 0,
            'update' => 0,
            'delete' => 0
        );

        return $this;
    }

    /**
     * Generates and executes a select query.
     *
     * Parameters:
     * <ul>
     * <li>where: Array of where parameters. Key => value translates into key = value. If no key is supplied then the value is treated as its own parameter.
     * <code>'where' => array( 'first_name' => 'John', 'last_name' => 'Doe', 'created > 10405833' )</code></li>
     * <li>single: returns a single value</li>
     * <li>singleRow: returns a single row</li>
     * <li>fetchStyle: see PDO manual</li>
     * <li>join</li>
     * <li>orderBy</li>
     * <li>groupBy</li>
     * </ul>
     *
     * @param string $tableName table name
     * @param string $fields fields, comma-seperated
     * @param array $parameters parameters
     * @param boolean $showQuery echoes the generated query if true
     *
     * @return boolean success?
     * @throws \Exception
     */
    public function select($tableName, $fields, $parameters = array(), $showQuery = false)
    {
        if (isset($parameters['single']) && $parameters['single']) {
            $parameters['singleRow'] = true;
            $parameters['fetchStyle'] = 'singleColumn';
        }

        $where = null;
        $where_other = array(); // array of parameters which do not contain an equal sign or is too complex for our implode function

        // store the original where parameters
        $originalWhere = array();

        if (isset($parameters['where'])) {
            $originalWhere = $parameters['where'];

            if (is_string($parameters['where'])) { // deprecating building where strings, use named parameters instead
                $where = ' WHERE ' . $parameters['where'];
            } else { // use named parameters, its safer
                foreach ((array)$parameters['where'] as $key => $value) {
                    if (is_numeric($key)) { // should not be parameterized
                        if ($value != '')
                            $where_other[] = $value;

                        unset($parameters['where'][$key]);
                    }
                }

                $where_arr = array();
                $where_other_implode = implode(' AND ', $where_other);
                if ($where_other_implode != '') // add to where clause
                    $where_arr[] = $where_other_implode;

                $where_parameterized = implode(' AND ', array_map(create_function('$key, $value', 'return $key.\' = :\'.str_replace(".","",$key);'), array_keys($parameters['where']), array_values($parameters['where'])));
                foreach ((array)$parameters['where'] as $parameter => $value) { // strip periods from named parameters, MySQL does not like this
                    unset($parameters['where'][$parameter]);
                    $parameters['where'][str_replace('.', '', $parameter)] = $value;
                }

                if ($where_parameterized != '')
                    $where_arr[] = $where_parameterized;

                if (count($where_arr) > 0)
                    $where = ' WHERE ' . implode(' AND ', $where_arr);
            }
        } else
            $parameters['where'] = null;

        if (isset($parameters['join'])) // joins cannot be included in where due to the use of named parameters
            $where .= ((strlen($where) > 0) ? ' AND ' : '') . $parameters['join'];

        $orderBy = null;
        if (isset($parameters['orderBy']))
            $orderBy = ' ORDER BY ' . $parameters['orderBy'];

        $groupBy = null;
        if (isset($parameters['groupBy']))
            $groupBy = ' GROUP BY ' . $parameters['groupBy'];

        $limit = null;
        if (isset($parameters['limit']))
            $limit = ' LIMIT ' . $parameters['limit'];

        $fetchStyle = PDO::FETCH_ASSOC;
        if (isset($parameters['fetchStyle'])) {
            switch ($parameters['fetchStyle']) {
                case 'assoc':
                    $fetchStyle = PDO::FETCH_ASSOC;
                    break;
                case 'num':
                    $fetchStyle = PDO::FETCH_NUM;
                    break;
                case 'singleColumn':
                    $fetchStyle = PDO::FETCH_COLUMN;
                    break;
                default:
                    $fetchStyle = PDO::FETCH_ASSOC;
                    break;
            }
        }

        try {
            $query = 'SELECT ' . implode(',', (array)$fields) . ' FROM ' . $tableName . $where . $groupBy . $orderBy . $limit;

            if ($showQuery || false) {
                global $selectQueries;
                $selectQueries .= $query . "\n";
                echo $query . "\n";
            }

            // execute query
            $STH = $this->DBH->prepare($query);
            $STH->execute($parameters['where']);

            $result = null;
            if (isset($parameters['singleRow']) && $parameters['singleRow'])
                $result = $STH->fetch($fetchStyle);
            else
                $result = $STH->fetchAll($fetchStyle);

            // store the number of rows
            $this->numrows = $STH->rowCount();

            // increment the select count
            $this->queryCount['select']++;

            return $result;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return false;
        }
    }

    /**
     * Executes a SQL query on the database
     *
     * WARNING: this could be dangerous so use with caution, no checking is performed
     *
     * @param string $query query
     *
     * @return mixed result
     */
    public function sql($query)
    {
        // increment the sql counter
        $this->queryCount['sql']++;

        return $this->DBH->query($query);
    }

    /**
     * Gets the number of rows affected by the last query
     *
     * @return int number of rows affected by last query
     */
    public function numrows()
    {
        return (int)$this->numrows;
    }

    /**
     * @return null
     * @throws \Exception
     */
    public function lastInsertId()
    {
        try {
            return $this->DBH->lastInsertId();
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return null;
        }
    }

    /**
     * Gets a listing of the tables in the database
     *
     * @return array tables
     */
    public function listTables()
    {
        $result = $this->DBH->query("show tables");

        return $result->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Gets a listing of the columns in a table
     *
     * @return array columns
     */
    public function listColumns($table)
    {
        $result = $this->DBH->query("SHOW COLUMNS FROM `$table`");

        return $result->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * Gets the number of a type of statements exectued
     *
     * @param string $key type of query counter to load (all,select,insert,delete,update,sql)
     *
     * @return int count
     */
    public function queryCounter($key = 'all')
    {
        if ($key == 'all' || !isset($this->queryCount[$key]))
            return $this->queryCount;
        else
            return $this->queryCount[$key];
    }

    /**
     * Notifies the class to start batching insert, update, delete queries
     *
     * @return boolean success
     */
    public function startBatch()
    {
        return $this->DBH->beginTransaction();
    }

    /**
     * Executes all of the queries in the batch queue
     *
     * @return boolean success
     */
    public function executeBatch()
    {
        return $this->DBH->commit();
    }

    /**
     * Inserts a row into the database
     *
     * @param string $tableName table name
     * @param array $data data to be inserted
     *
     * @return boolean true if successful
     */
    public function insert($tableName, $data)
    {
        try {
            $STH = $this->DBH->prepare('INSERT INTO ' . $tableName . ' (' . self::implode_key(',', (array)$data) . ') VALUES (:' . self::implode_key(',:', (array)$data) . ')');
            $STH->execute($data);

            // update the insert counter
            $this->queryCount['insert']++;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Inserts multiple rows at a time
     *
     * NOTE: The input data array must be a multi-dimensional array of rows with each entry in the row corresponding to the same entry in the fields
     *
     * @param string $tableName table name
     * @param array $fields field names
     * @param array $data data to be inserted
     *
     * @return boolean succeess
     * @throws \Exception
     */
    public function insertBatch($tableName, $fields, $data)
    {
        if (count($data) == 0)
            return true;

        try {
            // start the transaction
            $this->DBH->beginTransaction();

            // prepare the values to be inserted
            $insert_values = array();
            $question_marks = array();
            foreach ($data as $d) {
                // build the question marks
                $result = array();
                for ($x = 0; $x < count($d); $x++)
                    $result[] = '?';
                $question_marks[] = '(' . implode(',', $result) . ')';

                // get the insert values
                $insert_values = array_merge($insert_values, array_values($d));
            }

            // generate the SQL
            $sql = "INSERT INTO $tableName (" . implode(",", $fields) . ") VALUES " . implode(',', $question_marks);

            // prepare the statement
            $stmt = $this->DBH->prepare($sql);

            // execute!
            $stmt->execute($insert_values);

            // commit the transaction
            $this->DBH->commit();

            // increment the insert counter
            $this->queryCount['insert']++;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Builds and executes an update query
     *
     * @param string $tableName table name
     * @param array $data data to be updated
     * @param array $where array of keys in $data which will be used to match the rows to be updated
     * @param bool $showQuery echoes the query if true
     *
     * @return boolean true if successful
     * @throws \Exception
     */
    public function update($tableName, $data, $where = null, $showQuery = false)
    {
        try {
            $sql = 'UPDATE ' . $tableName . ' SET ';
            foreach ((array)$data as $key => $value)
                $sql .= $key . ' = :' . $key . ',';
            $sql = substr_replace($sql, '', -1);
            if ($where == null)
                $sql .= ' WHERE id = :id';
            else
                $sql .= ' WHERE ' . implode(' AND ', array_map(create_function('$key, $value', 'return $value.\' = :\'.$value;'), array_keys($where), array_values($where)));

            if ($showQuery) {
                echo $sql;
            }

            $STH = $this->DBH->prepare($sql);
            $STH->execute($data);

            $this->queryCount['update']++;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Builds and executes a delete query
     *
     * @param string $tableName table name
     * @param array $where values used to match rows to be deleted
     *
     * @return boolean true if successful
     * @throws \Exception
     */
    public function delete($tableName, $where, $showQuery = false)
    {
        try {
            $where_other = array(); // array of parameters which do not contain an equal sign or is too complex for our implode function
            $where_arr = array(); // array that will be used to concatenate all where clauses together

            foreach ($where as $key => $value) {
                if (is_numeric($key)) { // should not be parameterized
                    $where_other[] = $value;
                    unset($where[$key]);
                } else
                    $where[$key] = $this->DBH->quote($value);
            }

            $where_other_implode = implode(' AND ', $where_other);
            if ($where_other_implode != '') // add to where clause
                $where_arr[] = $where_other_implode;

            $where_parameterized = implode(' AND ', array_map(create_function('$key, $value', 'return $key.\'=\'.$value;'), array_keys($where), array_values($where)));
            if ($where_parameterized != '')
                $where_arr[] = $where_parameterized;

            $query = 'DELETE FROM ' . $tableName . ' WHERE ' . implode(' AND ', $where_arr);

            if ($showQuery)
                echo $query;

            $this->DBH->exec($query);

            $this->queryCount['delete']++;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @param string $glue
     * @param array $pieces
     * @return string
     */
    private function implode_key($glue = '', $pieces = array())
    {
        $arrK = array_keys($pieces);
        return implode($glue, $arrK);
    }

    /**
     * @param array $array
     * @param string $glue
     * @return bool|string
     */
    private function multi_implode($array = array(), $glue = '')
    {
        $ret = '';

        foreach ($array as $item) {
            if (is_array($item)) {
                $ret .= self::multi_implode($item, $glue) . $glue;
            } else {
                $ret .= $item . $glue;
            }
        }

        $ret = substr($ret, 0, 0 - strlen($glue));

        return $ret;
    }
}
