<?php
	/**
	 * Created by PhpStorm.
	 * User: kill370354
	 * Date: 2017/12/28
	 * Time: 15:49
	 */
	header('Content-Type:text/html; charset=utf-8');
	date_default_timezone_set("Asia/Shanghai");
	include "Connect.php";
	if (isset($_POST['submitreply'])) {
		try {
			$pdo->beginTransaction();
			if (trim($_POST['replytext']) == "") {
				?>
                <script>alert("内容不能为空！");
                    history.go(-1);</script>
				<?php
			} else {
				error_reporting(0);
				$user_name = $_GET["username"];
				$dir = 'tmp/';
				session_save_path($dir);
				session_start();
				$user_name = "游客";
				$aa = isset($_SESSION["username"]);
				$qa = empty($_SESSION["username"]);
				if (isset($_SESSION["username"]) && !empty($_SESSION["username"]))
					$user_name = $_SESSION["username"];
				$createtime = date("Y-m-d H:i:s");
				$query = "insert into tb_my_reply (replyid,author,messages,createtime) values ('" . intval($_POST["num"]) . "','" . $user_name . "',?,'" . $createtime . "')";
				$result = $pdo->prepare($query);
				$result->bindParam(1, $_POST['replytext']);
				$result->execute();
				$code = $result->errorCode();//$result是查询结果集
				if ($code == '00000') {
					$message_count = $_GET["messagecount"] + 1;
					$page_size = $_GET["pagesize"];
					$quotient = $message_count / $page_size;
					if (is_int($quotient)) {
						$page = $quotient;  //根据记录总数除以每页显示的记录数求出所分的页数
					} else $page = ceil($quotient);
					?>
                    <script type="text/javascript"
                            charset="UTF-8">
                        history.go(-1);
                    </script>
				<?php } else {
					?>
                    <script type="text/javascript" charset="UTF-8">alert("留言失败，请截图联系kill370354@qq.com");</script>
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