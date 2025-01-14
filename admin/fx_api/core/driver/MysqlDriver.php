<?php

/**
 * PDO方式操作数据库
 * @author tian 林澜叶
 */
require_once('DbDriver.php');

class MysqlDriver extends DbDriver {

    /**
     * 构造函数初始化
     */
    function __construct() {
        try {
            parent::__construct();
        } catch (Exception $e) {
            myerror(StatusCode::msgDBFail, '数据库异常', $e->getMessage());
        }
    }

    protected function collectSql($sql = null, $fields = null) {                   //收集sql
        Sql::set($sql, $fields);
    }

    protected function exec(PDOStatement $pdo, $fields = null) {                                   //执行pdo编译
        $r = $pdo->execute();

        if (Config('debug')) {              //调试情况下
            if ($r === false) {
                print_r($pdo->errorInfo());
                die;
            }
        }
        Sql::set($pdo->queryString, $fields);
        return $r;
    }

    /**
     * 保存单个对象
     * @param $model 对象实体
     * @param $type 返回类型，默认返回对象实体，当值为id时，返回自增id
     * @return int 返回自增id
     */
    public function insert($model, $type = '') {
        $sql = "insert into " . $model['table'] . " ";
        unset($model["table"]);
        unset($model[$model['_cxf_num_id']]);
        unset($model['_cxf_num_id']);
        $fields = $model;


        //组合字段
        $sql .= "(";
        $i = 1;
        foreach ($fields as $key => $value) {
            if (!empty($value) ) {
                $sql .= "`$key`";
                if ($i < count($fields)) {
                    $sql .= ",";
                }
                $i++;
            }
        }

        if (strlen($sql) > 0) {
            $sql = substr($sql, 0, strlen($sql) - 1);
        }
        $sql .= ") values (";

        //组合字段值参数
        $i = 1;
        foreach ($fields as $key => $value) {
            if (!empty($value)  && $value != 'null') {
                $sql .= ":$key";
                if ($i < count($fields)) {
                    $sql .= ",";
                }
                $i++;
            }
        }
        $sql = rtrim($sql, ',');
        $sql .= ")";
        //预处理sql语句
        $stmt = $this->pdo->prepare($sql);
        //绑定参数结果
        foreach ($fields as $key => $value) {
            if (!empty($value)  && $value != 'null') {
                $stmt->bindValue(":$key", $value);
            }
        }
        $result = $this->exec($stmt, $fields);

        switch ($type) {
            case 'model':
                if ($result) {
                    $model["id"] = $this->pdo->lastInsertId();
                }
                return (object) $model;
            default:
                return $this->pdo->lastInsertId();
        }
    }

    /**
     * 保存多个对象
     * 一次性保存多条数据
     * 返回影响条数
     * * */
    public function insertMany($arr_model) {
        $sql = "insert IGNORE into ";
        foreach ($arr_model as $key => &$value) {
            $value = get_object_vars($value);
            $t_name = $value["table"];
            unset($value["table"]);
            unset($value[$value['_cxf_num_id']]);
            unset($value['_cxf_num_id']);
            $arr[]=$value;
        }
        $sql.= $t_name;
        unset($arr_model);
        $colum = '(';
        $vallist = '';
        if (!empty($arr) && is_array($arr)) {

            foreach ($arr[0] as $cky => $cval) {
                $colum .= $cky . ',';
            }
            if (!empty($colum) && strlen($colum) > 0) {
                $colum = substr($colum, 0, strlen($colum) - 1) . ")";
            }
            $i = 0;

            foreach ($arr as $key => $value) {
                $i++;
                $vallist.="(";
                if (!empty($value) && is_array($value)) {

                    foreach ($value as $ckey => $cval) {
                        $vallist .= ":$ckey$i,";
                    }
                    if (!empty($vallist) && strlen($vallist) > 0) {
                        $vallist = substr($vallist, 0, strlen($vallist) - 1) . "),";
                    }
                }
            }
            
            if (!empty($vallist) && strlen($vallist) > 0) {
                $vallist = substr($vallist, 0, strlen($vallist) - 1);
            }
            $sql .= $colum . 'values' . $vallist;
            $stmt = $this->pdo->prepare($sql);
            $i = 0;
            foreach ($arr as $key => $val) {
                $i++;
                if (!empty($val) && is_array($val)) {
                    foreach ($val as $ckey => $cval) {
                        $stmt->bindValue(":$ckey$i", $cval);
                        $arr[$key][$ckey.$i]=$cval;
                        unset($arr[$key][$ckey]);
                    }
                }
            }
        }

        $this->exec($stmt, $arr);
        return $stmt->rowCount();
    }

    /**
     * 删除一条数据
     * @param 要删除的实体
     * @return boolean
     */
    public function delete($model) {

        $sql = "delete from " . $model['table'] . "  where ";
        $i = 1;
        $sql .= " `" . $model['_cxf_num_id'] . "` = :id";
        //预处理sql语句
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $model[$model['_cxf_num_id']]);
        $this->exec($stmt, ['id' => $model[$model['_cxf_num_id']]]);
        return $stmt->rowCount();
    }

    /**
     * 更新数据库
     * @param unknown $table
     * @param unknown $fields
     * @param unknown $where
     */
    public function update($model) {
        $sql = "update " . $model['table'] . " set ";
        $id_name = $model['_cxf_num_id'];
        $id = $model[$model['_cxf_num_id']];


        unset($model["table"]);

        $i = 1;

        $f_arr = $model;
        unset($f_arr[$f_arr["_cxf_num_id"]]);
        foreach ($f_arr as $key => $value) {
            if (!empty($value)  && $key != '_cxf_num_id') {
                $sql .= "$key=:$key";
                if ($i < count($f_arr)) $sql .= ',';
                $i++;
            }
        }
        if (strlen($sql) > 0) {
            $sql = substr($sql, 0, strlen($sql) - 1);
        }

        $sql .= ' where ';
        $sql .= "$id_name=:id";

        $stmt = $this->pdo->prepare($sql);


        $iid = $model[$model['_cxf_num_id']];
        unset($model['_cxf_num_id']);
        unset($f_arr['_cxf_num_id']);

        //绑定参数结果
        foreach ($f_arr as $key => $value) {
            if (!empty($value) ) {
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->bindValue(":id", $iid);

        $f_arr[$id_name] = $id;       //记录sql语句使用
        $this->exec($stmt, $f_arr);
        return $stmt->rowCount();
    }

    /*
     * 查询总条数
     */

    public function count($model) {
        $sqlrow = "select count(*) from " . $model['table'] . " where 1=1 ";
        unset($model["table"]);
        unset($model['_cxf_num_id']);
        foreach ($model as $ckey => $cval) {
            if (!empty($cval) && strlen($cval) > 0) {
                $sqlrow .= " and $ckey =:$ckey";
            }
        }

        $abc = $this->pdo->prepare($sqlrow);
        foreach ($model as $key => $value) {
            if (!empty($value) ) {

                $abc->bindValue(":$key", $value);
            }
        }



        $this->exec($abc, $model);
        $number_of_rows = $abc->fetchColumn();
        return $number_of_rows;
    }

    /**
     * 根据条件查询
     *  $where=array(QueryType::In=>array("name"=>array("3","4","5")),  QueryType::Eq=>array("sex"=>"男","name"=>"陈"),  QueryType::Maybe=>array("name"=>array("a","b","c")),  QueryType::Range=>array("name"=>array("1","10")),  QueryType::Like=>array('name'=>'a','sex'=>'b'));
     * * */
    public function getList($model, $fields, $paging, $order) {
        unset($model['_cxf_num_id']);
        $getfields = '';
        if (!empty($fields) && is_array($fields) && count($fields) > 0) {
            foreach ($fields as $value) {
                $getfields .= format("$value,");
            }
            $getfields = substr($getfields, 0, strlen($getfields) - 1);
        }
        $sqlrow = "select count(*) count from " . $model["table"] . " where 1=1 ";

        $sql1 = "";
        $sql2 = "";

        if (strlen($getfields) > 0) {


            if ($paging != null) {
                $pageSize = Config('page_num');
                $currentSize = ($paging - 1) * $pageSize;
                $sql1 .= "select  $getfields from " . $model["table"] . " where 1 = 1 ";
            }
        } else {
            //判断分页
            if ($paging != null) {
                $pageSize = Config('page_num');
                $currentSize = ($paging - 1) * $pageSize;
                $sql1 .= "select  * from " . $model["table"] . " where 1 = 1 ";
            }
        }
        $cursor = 0;
        foreach ($model as $key => $val) {
            if ($key != "table") {
                if (!empty($val) && strlen($val) > 0) {

                    $sql1 .= " and $key = :$key";
                    $sql2 .= " and $key = :$key";
                    $sqlrow .= " and $key = :$key";
                }
            }
        }
        if (!empty($order) && is_array($order) && count($order) > 0) {
            $sql1 .= ' order by ';
            $str = '';
            foreach ($order as $key => $val) {
                $str.= format(" $key $val,");
            }
            if (strlen($str) > 0) {
                $str = substr($str, 0, strlen($str) - 1);
            }
            $sql1 .= $str;
        }

        if ($pageSize) {            //如果有分页信息，则分页
            $newsql = $sql1 . " limit $currentSize, $pageSize ";
        } else {
            $newsql = $sql1;
        }

        $stmt = $this->pdo->prepare($newsql);
        $abc = $this->pdo->prepare($sqlrow);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        unset($model["table"]);

        foreach ($model as $key => $value) {
            if (!empty($value) ) {
                $stmt->bindValue(":$key", $value);
                $abc->bindValue(":$key", $value);
            }
        }
        //取得结果
        $this->exec($stmt, $model);
        //将结果集转为array
        $list = $stmt->fetchAll();
        $rows = 0;
        $this->exec($abc, $model);
        foreach ($abc as $item) {
            $rows = $item['count'];
            break;
        }
        $allPage = $rows % $pageSize == 0 ? $rows / $pageSize : intval($rows / $pageSize) + 1;
        return array("rows" => $rows, "pageIndex" => $paging, "allPage" => $allPage, "list" => $list);
    }

    /* zhixing sql */

    public function excute($sql, $parmeters) {
        $stmt = $this->pdo->prepare($sql);
        //绑定参数结果
        foreach ($parmeters as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $this->exec($stmt, $parmeters);

        return $stmt->rowCount();
    }

    public function query($sql, $parameters, $return_type = '') {
        $stmt = $this->pdo->prepare($sql);
        //绑定参数结果
        foreach ($parameters as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        //取得结果
        $this->exec($stmt, $parameters);
        //将结果集转为array
        switch ($return_type) {
            case 'fetch_unique':
                $list = $stmt->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);
                break;
            case 'fetch_row':       //返回['字段'=>'值']
                $list = $stmt->fetch();
                break;
            case 'fetch_string':       //返回'值'
                $list = $stmt->fetch(PDO::FETCH_COLUMN);
                break;
            default:
                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
        }

        return $list;
    }

    /*
     * 开始事物
     */

    public function beginTrans() {
        return $this->pdo->beginTransaction();
    }

    /*
     * 回滚事物
     */

    public function rollBack() {
        return $this->pdo->rollBack();
    }

    /*
     * 提交事物
     */

    public function commit() {
        return $this->pdo->commit();
    }

    public function insertBySql($sql, $parmeters) {
        $stmt = $this->pdo->prepare($sql);
        //绑定参数结果
        foreach ($parmeters as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $result = $this->exec($stmt, $parmeters);
        if ($result) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

}
