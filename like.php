<?php
/**
 * Created by PhpStorm.
 * User: kill370354
 * Date: 2018/5/30
 * Time: 14:55
 */
header('Content-Type:text/html; charset=utf-8');
include "Connect.php";
$dir = 'tmp/';
session_save_path($dir);
session_start();
echo "<p>";
$_SESSION["id"] = session_id();
try {
    $pdo->beginTransaction();
    $query = "UPDATE tb_messages  SET likenum=likenum+1 where id='".$_POST['id']."'";
    $result = $pdo->query($query); //查询符合条件的记录总条数
    echo $query;
    $pdo->commit();
} catch (PDOException $e) {
    echo $e->getMessage();
    $pdo->rollBack();
}
