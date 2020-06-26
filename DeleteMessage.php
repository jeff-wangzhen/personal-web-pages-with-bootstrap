<meta charset="utf-8">
<?php
	error_reporting(0);
	//$sess_id = $_GET["sess_id"];
	$user_name = $_GET["username"];
//	session_id($sess_id);//设置session_id号为$sess_id值
	$dir = 'tmp/';
	session_save_path($dir);
	session_start();
	include("Connect.php");
	$id = $_GET["id"];
	$sql = $pdo->query("delete from tb_messages where id=$id");
	if ($sql) {
		?>
        <script>alert('删除成功！');
            window.location.href = "messages.php?page=1&username=<?php echo "$user_name"?>";</script>";
		<?php
	} else {
		?>
        <script>alert('删除失败！');
            history.go(-1);</script>";
		<?php
	}
?>