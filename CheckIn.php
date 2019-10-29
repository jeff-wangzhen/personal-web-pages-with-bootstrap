<?php
	/**
	 * Created by PhpStorm.
	 * User: kill370354
	 * Date: 2017/12/26
	 * Time: 15:14
	 */
	header('Content-Type:text/html; charset=utf-8');
	include "Connect.php";
	error_reporting(0);
	if (isset($_GET['Submit'])) {
		try {
			$pdo->beginTransaction();
			if (trim($_GET['username']) != "" && trim($_GET['userpwd']) != "") {
				$query = "select * from tb_grwzphpusers where username= ? and userpwd= ? ";
               			 $result = $pdo->prepare($query);
                		$result->bindParam(1, $_GET['username']);
                		$result->bindParam(2, $_GET['userpwd']);
                		$result->execute();
				$res = $result->fetch(pdo::FETCH_ASSOC);
				if ($res) {
				    if(isset($_GET['autologin']) )setcookie("autologin",1);
				    else setcookie("autologin",0);
					$path = 'tmp/';
					session_save_path($path);//给会话数据指定保存路径,在session_start()前使用。
					session_start();//建立会话，会话文件保存在tmp目录下。
					$_SESSION["username"] = $_GET['username'];
					setcookie("username",$_GET['username'],time()+60*60*24*30);
					setcookie("password",$_GET['userpwd']);
					setcookie("signedin",1,0);
					$_SESSION["id"] = session_id();
                    $_SESSION["user_portrait"]="client1.jpg";
                    if(!isset($_SESSION["lastpage"])){ $_SESSION["lastpage"]="introduction.php";}
                    ?>
                    <script type="text/javascript" charset="UTF-8">
                        window.location = "<?php echo $_SESSION["lastpage"]?>?sess_id=<?php echo "$sess_id" ?>&username=<?=$_POST['username'] ?>"
                    </script>
				<?php } else {
					?>
<!--                    <script type="text/javascript" charset="UTF-8">alert("用户名或密码错误！");window.history.go(-1);</script>-->
					<?php
				}
			} else {
				echo '数据库错误：<br/>';
				echo 'SQL Query:' . $query;
				echo '<pre>';
				var_dump($result->errorInfo());
				echo "<br/>";
				var_dump($res);
				echo '</pre>';
			}
			$pdo->commit();
		} catch (PDOException $e) {
			echo $e->getMessage();
			echo "<br/><br/>PDO事务处理失败，请告知kill370354@qq.com";
			$pdo->rollBack();
		}
	}
?>
