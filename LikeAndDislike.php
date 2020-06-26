<?php
/**
 * Created by PhpStorm.
 * User: kill370354
 * Date: 2018/6/2
 * Time: 12:55
 */
header("Content-Type:text/html;charset=utf-8");
include "Connect.php";
error_reporting(0);
$path = 'tmp/';
$sess_name = session_name();//取出字符串"PHPSESSID"
session_save_path($path);//给会话数据指定保存路径,在session_start()前使用。
session_start();//建立会话，会话文件保存在tmp目录下。
if ( isset($_POST['id']) ) {
    try {
        $pdo->beginTransaction();
        if(isset($_POST['like']))

            $query = "UPDATE tb_danmu  SET likenum=likenum+1 WHERE id=".$_POST['id'].";";
            elseif (isset($_POST['dislike'])) $query = "UPDATE tb_danmu SET dislikenum=dislikenum+1 WHERE id=".$_POST['id'].";";
            $result = $pdo->prepare($query);
            $result->execute();
            echo $query;
            $code = $result->errorCode();//$result是查询结果集
            if ($code == '00000') {
                 } else {
                echo '数据库错误：<br/>';
                echo 'SQL Query:' . $query;
                echo '<pre>';
                var_dump($result->errorInfo());
                echo '</pre>';
            }

        $pdo->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "<br/><br/>弹幕点赞PDO事务处理失败，请告知kill370354@qq.com";
        $pdo->rollBack();
    }
}
?>