<?php
header("Content-type:text/html;charset=utf-8");

include 'Connect.php';

// var_dump($_GET);
$a = $_GET["username"];

$sql = "select * from tb_grwzphpusers where username=?";
$result = $pdo->prepare($sql);
$result->bindParam(1, $a);


try {
    // var_dump($result);
    $pdo->beginTransaction();
    $result->execute();
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    if ($row) {
        echo "<p>y</p>";
    } else {
        echo "<p>no</p>";
    }
    $pdo->commit();
} catch (PDOException $e) {
    echo $e;
}
