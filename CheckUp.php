<?php
	/**
	 * Created by PhpStorm.
	 * User: kill370354
	 * Date: 2017/12/26
	 * Time: 15:14
	 */
	header("Content-Type:text/html;charset=utf-8");
	include "Connect.php";
	error_reporting(0);
	$path = 'tmp/';
	$sess_name = session_name();//取出字符串"PHPSESSID"
	session_save_path($path);//给会话数据指定保存路径,在session_start()前使用。
	session_start();//建立会话，会话文件保存在tmp目录下。
	$sess_id = session_id();
	$cooid = $_COOKIE["PHPSESSID"];
	$user_name = $_POST['username'];
	$_SESSION["username"] = $_POST['username'];
	$portrait_file = "client1.jpg";
	if (  preg_match("/^[a-zA-Z][a-zA-Z0-9_-]{5,20}$/",$_POST['username'] ) && preg_match("/^[a-zA-Z][a-zA-Z0-9_-]{5,20}$/",$_POST['userpwd'] ) && $_POST['userpwd']==$_POST['checkid'] && isset($_POST['Submit']) ) {
		try {
			$pdo->beginTransaction();
			if (trim($_POST['username']) != "") {
				if ((($_FILES["file"]["type"] == "image/gif")
						|| ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png")
						|| ($_FILES["file"]["type"] == "image/pjpeg"))
					&& ($_FILES["file"]["size"] < 10000)) {
					if ($_FILES["file"]["error"] > 0) {
						echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
					} else {
						function getMillisecond()
						{
							list($t1, $t2) = explode(' ', microtime());
							return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
						}
						
						//调用
						$milltime = getMillisecond();
						$pic_suffix = strstr($_FILES["file"]["name"], ".");
						$portrait_file = $milltime . $pic_suffix;
						move_uploaded_file($_FILES["file"]["tmp_name"],
							"clientportrait/" . $portrait_file);
					}
				} else {
				};
				$query = "insert into tb_grwzphpusers (username,userpwd,portrait) values ('" . $_POST['username'] . "','" . $_POST['userpwd'] . "','" . $portrait_file . "')";
				$result = $pdo->prepare($query);
				$result->execute();
				$code = $result->errorCode();//$result是查询结果集
				if ($code == '00000') {
                    setcookie("username",$_POST['username']);
                    setcookie("password",$_POST['userpwd']);setcookie("autologin","0");
		    setcookie("signedin",1,0);
                    $_SESSION["user_portrait"]="client1.jpg";

                    if(!isset($_SESSION["lastpage"])){ $_SESSION["lastpage"]="introduction.php";}
                    ?>
                    <script type="text/javascript" charset="UTF-8">
                        window.location = "<?php echo $_SESSION["lastpage"]?>?sess_id=<?php echo "$sess_id" ?>&username=<?=$_POST['username'] ?>"
                    </script>
				<?php } else {
					?>
                    <script type="text/javascript" charset="UTF-8">alert("注册失败，请截图联系kill370354@qq.com");</script>
					<?php
					echo '数据库错误：<br/>';
					echo 'SQL Query:' . $query;
					echo '<pre>';
					var_dump($result->errorInfo());
					echo '</pre>';
				}
			}
			
			$pdo->commit();
		} catch (PDOException $e) {
			echo $e->getMessage();
			echo "<br/><br/>PDO事务处理失败，请告知kill370354@qq.com";
			$pdo->rollBack();
		}
	}
?>
