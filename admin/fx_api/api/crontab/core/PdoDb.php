<?php

/**
 * PDO DATABASE CLASS
 * 
 * Handling and Managing of database connection and access to database  
 *
 * @author Arvin Kent Lazaga <arvinkent17@gmail.com>
 * @since November 18, 2014
 * @copyright 2014
 * */
class PdoDb {

    /**
     * Database Class Data Variables.
     *
     * @access private
     * */
    private $server_version;
    private $server_info;
    private $server_status;
    private $dbh;
    private $object;

    /**
     * Automatically Opens Database Connection when Database Class is being instantiated.
     * 
     * @access public
     * */
    public function __construct($database, $username, $password, $hostname) {
        $this->openConnection($database, $username, $password, $hostname);
    }

    /**
     * Opens Server and Database Connection.
     *
     * @return error message
     * @access public
     * */
    public function openConnection($database, $username, $password, $hostname) {
        try {
            $this->dbh = new PDO("mysql:host=" . $hostname . ";dbname=" . $database, $username, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setServerDetails(PDO::ATTR_SERVER_VERSION, PDO::ATTR_SERVER_INFO, PDO::ATTR_CONNECTION_STATUS);
        } catch (PDOException $e) {
            die("Connection to database failed because: " . $e->getMessage());
        }
    }

    public function setServerDetails($server_version, $server_info, $server_status) {
        $this->server_version = $this->dbh->getAttribute($server_version);
        $this->server_info = $this->dbh->getAttribute($server_info);
        $this->server_status = $this->dbh->getAttribute($server_status);
    }

    public function getServerVersion() {
        return $this->server_version;
    }

    public function getServerInfo() {
        return $this->server_info;
    }

    public function getServerStatus() {
        return $this->server_status;
    }

    /**
     * MySQL Injection Handler.
     *
     * Dynamically Handles and Executes any MySQL Scripts with the features of Sanitizing  
     * and Binding of Parameters to avoid any SQL Injections.
     *
     * @param string $sql
     * @param array $param
     * @access public
     * */
    public function executeMySQL($sql, $param = null, $search = false) {
        if (is_null($param)) {
            try {
                $this->object = $this->dbh->prepare($sql);
                $this->object->execute();
            } catch (PDOException $e) {
                die("Failed to execute MySQL script due to: " . $e->getMessage());
            }
        } else {
            try {
                $this->object = $this->dbh->prepare($sql);
                for ($index = 0; $index < count($param); ++$index) {
                    if (is_string($param[$index])) {
                        if ($search == true) {
                            $this->object->bindValue($index + 1, "$param[$index]%", PDO::PARAM_STR);
                        } else {
                            $this->object->bindParam($index + 1, $param[$index], PDO::PARAM_STR);
                        }
                    } elseif (is_bool($param[$index])) {
                        $this->object->bindParam($index + 1, $param[$index], PDO::PARAM_BOOL);
                    } else {
                        $this->object->bindParam($index + 1, $param[$index], PDO::PARAM_INT);
                    }
                }
                $this->object->execute();
            } catch (PDOException $e) {
                die("Failed to execute MySQL script with parameters due to: " . $e->getMessage());
            }
        }
    }

    /**
     * Dynamically Counts the total rows of the current object.
     *
     * @return number of rows
     * @access public
     * */
    public function rowCount() {
        return $this->object->rowCount();
    }

    /**
     * Dynamically Fetch the rows of the current object.
     *
     * @return array of data
     * @access public
     * */
    public function rowFetch() {
        return $this->object->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Dynamically Fetch the rows of the current object.
     *
     * @return array of data
     * @access public
     * */
    public function getAll() {
        $data = [];
        while ($row = $this->object->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }

    /**
     * Dynamically checks if there is a item inserted on the current object's database.
     *
     * @return true or false
     * @access public
     * */
    public function isInserted() {
        return $this->dbh->lastInsertId();
    }

    public function PDOError() {
        return $this->dbh->errorCode();
    }

    /**
     * Automatically closes connection for security purposes.
     *
     * @access public
     * */
    public function closeConnection() {
        if (isset($this->openConnection)) {
            $this->dbh = null;
            unset($this->openConnection);
        }
    }

    /**
     * 开始事务
     * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
     * @return type
     */
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }

    /**
     * 提交事务
     * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
     * @return type
     */
    public function commit() {
        return $this->dbh->commit();
    }

    /**
     * 回滚事务
     * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
     * @return type
     */
    public function rollBack() {
        return $this->dbh->rollBack();
    }

    /**
     * 插入一条数据
     * @param type $data
     * @param type $table
     * 
     */
    public function insert($data, $table) {
        $param = array();
        $fields = '';
        $grap = '';
        foreach ($data as $key => $value) {
            $fields .= ",{$key}";
            $grap .= ",?";
            array_push($param, $value);
        }
        $fields = substr($fields, 1);
        $grap = substr($grap, 1);
        $sql = "insert into {$table} ({$fields}) values({$grap})";

        $this->executeMySQL($sql, $param);
        $id = $this->isInserted();
        if ($id) return $id;
        throw new Exception("数据插入失败！");
    }

    /**
     * 批量插入一条数据
     * @param type $data
     * @param type $table
     * 
     */
    public function insertAll($data, $table) {
        if (!$data || count($data) <= 0) {
            throw new Exception("数据插入失败！");
        }
        $param = array();
        $grap = array();
        $fields = '';
        foreach ($data as $k => $item) {
            $fields = '';
            foreach ($item as $key => $value) {
                $fields .= ",{$key}";
                $grap[$k][] = "?";
                array_push($param, $value);
            }
        }
        $fields = substr($fields, 1);
        $grap_str = '';
        foreach ($grap as $v) {
            $grap_str .= ',(' . implode(',', $v) . ')';
        }
        $grap_str = substr($grap_str, 1);
        $sql = "insert into {$table} ({$fields}) values{$grap_str}";
        $this->executeMySQL($sql, $param);
        $id = $this->isInserted();
        if ($id) return $id;
        throw new Exception("数据插入失败！");
    }

}
