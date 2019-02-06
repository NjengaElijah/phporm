<?php

include_once "DBConn.php";

class SQLQuery extends DBConn
{
    public static $results;
    public static function nonQuery($sql)
    {
        if (self::getConnection()->query($sql)) {
            self::closeConnection();
            return true;
        }
        return false;
    }
    public static function query($sql)
    {
        $result = self::getConnection()->query($sql);
        $arr = array();
        if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)) {
                array_push($arr, $row);
            }
        }
        self::closeConnection();
        return $arr;
    }
    public static function insert($tableName, $assocDataArr)
    {
        $conn = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $cols = "";
        $params = "";
        // print_r($assocDataArr);
        foreach ($assocDataArr as $key => $value) {
            if ($key != 'id' && $key != 'table' && $key != 'foreign_key_name' ) {
                if ($cols != "") {$cols .= ',';}
                if ($params != "") {$params .= ',';}
                $cols .= "`$key`";
                $params .= ":$key";
            }
        }
        $stmt = $conn->prepare("INSERT INTO `$tableName` ($cols) VALUES ($params)");
        
        foreach ($assocDataArr as $key => $value) {
            if ($key != 'id' && $key != 'table' && $key != 'foreign_key_name') {
                // echo ':' . $key . ' -> ' . $value;
                $stmt->bindParam(':' . $key, $assocDataArr[$key]);
            }
        }
        $stmt->execute();
        $id = $conn->lastInsertId();
        $conn = null;
        return $id;
    }

}