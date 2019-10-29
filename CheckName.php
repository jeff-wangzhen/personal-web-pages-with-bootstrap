<?php
header("Content-type:text/html;charset=utf-8");
$link=mysqlI_connect("localhost","a0912161003","qaz123","a0912161003");
mysqli_query($link,"set names utf-8");
$user_name=$_GET["username"];
//var_dump($user_name);
$s="select * from tb_grwzphpusers where username=".$user_name;
//var_dump($s);
$sql=mysqli_query($link,$s);
//var_dump($sql);
$info=mysqlI_fetch_array($sql);
if ($info){
    echo "<p>y</p>";
}else{
 echo "<p>no</p>";
}
?>