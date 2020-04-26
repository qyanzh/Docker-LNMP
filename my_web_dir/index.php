<?php
$dbms = 'mysql';     //数据库类型
$host = 'cdb';       //数据库主机名，修改为容器名
$user = 'root';      //数据库连接用户名
$pass = $_ENV["MYSQL_PASSWORD"]; //通过yml中定义的环境变量获得对应的密码
$dsn = "$dbms:host=$host;";

try {
    $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
    echo "连接成功<br/>";
    $dbh = null;
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}
//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$db->exec("create database if not exists test_db;");
$db->exec("use test_db;");
$db->exec("create table if not exists t(num integer);");
$db->exec("delete from t;");

// 增
$db->exec("insert into t(num) values(2420);");
showDb($db, "insert:\n");
// 改
$db->exec("update t set num=031702420 where num=2420;");
showDb($db, "update:\n");
// 删
$db->exec("delete from t;");
showDb($db, "delete:\n");
// 查
function showDb($db, $op)
{
    print_r($op);
    $sql = "select * from t";
    $result = $db->query($sql);
    while ($arr = $result->fetch()) {
        print_r($arr);
    }
    echo "<br/>";
}
