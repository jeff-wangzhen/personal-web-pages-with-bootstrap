<?php //连接数据库语句
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set("Asia/Shanghai");

echo "as";
var_dump($_POST);var_dump($_GET);
var_dump($_SERVER["REQUEST_URI"]);
if (isset($_POST["sBulletScreen"])) {
    echo "as";
    $dbms = 'mysql';    //数据库类型 ,对于开发者来说，使用不同的数据库，只要改这个，不用记住那么多的函数
    $host = 'localhost';    //数据库主机名
    $dbName = 'a0912161003'; //使用的数据库
    $user = 'a0912161003';        //数据库连接用户名
    $pass = 'qaz123';    //对应的密码
    $dsn = "$dbms:host=$host;dbname=$dbName";
    $pdo = new PDO($dsn, $user, $pass);    //初始化一个PDO对象，就是创建了数据库连接对象$pdo
   // $pdo->query("set names 'utf8'");
    try {
        $pdo->beginTransaction();
        /** @var TYPE_NAME $query_bullet_screen */
       // $query_bullet_screen ="INSERT INTO tb_danmu(message) VALUE ('11士大夫1')";
             $query_bullet_screen = "insert into tb_danmu (message,datetime) VALUES (\"" . $_POST["sBulletScreen"] . "\",\"" . date("Y-m-d H:i:s") . "\")";
        /** @var TYPE_NAME $query_result */
        $query_result = $pdo->query($query_bullet_screen);

        //$query_result->execute();
        if ($query_result) {
            echo "<p>y</p>";
        } else {
            echo "<p>no</p>";
        }
        echo "qa";
        $pdo->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "<br/><br/>PDO事务处理失败，请告知kill370354@qq.com";
        $pdo->rollBack();
    }
}

?>