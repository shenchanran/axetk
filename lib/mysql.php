<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/config.php");
class mysql
{
    private $conn;
    public function __construct()
    {
        $c_mysql = \config\get('mysql');
        $tconn = mysqli_connect($c_mysql[0], $c_mysql[1], $c_mysql[2], $c_mysql[3]);
        if (!$tconn) {
            return false;
        }
        $this->conn = $tconn;
        return true;
    }
    public function Close()
    {
        $this->conn->close();
    }
    public function Select(...$args)
    /*
        参数示例，接收n个数组
        1：['数据表名'，'limit限制(可忽略)','OR还是AND（默认AND）']，
        2-n:['列名'，'符号（<>=like）可忽略'，'匹配值']
    */
    {
        $info = $args[0];
        unset($args[0]);
        $sql = 'SELECT * FROM ' . $info[0] . ' WHERE ';
        $params = [];
        foreach ($args as $arg) {
            if (count($arg) == 2) {
                $arg[1] = addslashes($arg[1]);
                $params[] = "{$arg[0]} = '{$arg[1]}'";
            } else {
                $arg[2] = addslashes($arg[2]);
                $params[] = "{$arg[0]} {$arg[1]} '{$arg[2]}'";
            }
        }
        if (count($args) < 1) {
            $sql .= '1';
        } else {
            if (count($info) > 2) {
                $sql .= implode(" {$info[2]} ", $params);
            }else{
                $sql .= implode(" AND ", $params);
            }
        }
        if (count($info) > 1) {
            $sql .= " LIMIT {$info[1]}";
        }
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            // 输出数据
            $result = $result->fetch_assoc();
        } else {
            $result = [];
        }
        return $result;
    }
    public function Insert($db_name, $values)
    /*
        参数示例，接收2个参数
        1：'数据表名'，
        2: 'key=>value关联数组'
    */
    {
        $names = [];
        $datas = [];
        foreach ($values as $key => $value) {
            $names[] = $key;
            $datas[] = "'" . addslashes($value) . "'";
        }
        $names = implode(',', $names);
        $datas = implode(',', $datas);
        $sql = "INSERT INTO {$db_name} ({$names}) VALUES({$datas})";
        $result = $this->conn->query($sql);
        return $result;
    }
    public function Set($db_name, $index, $data)
    {
        /*
    参数示例，接收3个参数
    1：'数据表名'，
    2: 用于定位的键和值，例如["id","=",'2']，第二个元素可忽略
    3：'key=>value关联数组'
*/
        $ss = [];
        foreach ($data as $key => $value) {
            $value = addslashes($value);
            $ss[] = " {$key} = '{$value}' ";
        }
        $ss = implode(',', $ss);
        if (count($index) > 2) {
            $index = "{$index[0]} {$index[1]} '{$index[2]}'";
        } else {
            $index = "{$index[0]} = '{$index[1]}'";
        }
        $index[2] = addslashes($index[2]);
        $sql = "UPDATE {$db_name} SET {$ss} WHERE {$index}";
        $result = $this->conn->query($sql);
        return $result;
    }
}
