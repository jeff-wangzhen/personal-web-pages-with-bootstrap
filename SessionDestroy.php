<?php
	/**
	 * Created by PhpStorm.
	 * User: kill370354
	 * Date: 2018/1/1
	 * Time: 15:47
	 */
	header('Content-Type:text/html; charset=utf-8');
	include "Connect.php";
	error_reporting(0);
	$user_name = $_GET["username"];
	$dir = 'tmp/';
	session_save_path($dir);
    session_start();
    header('Content-type:text/html;charset=utf-8');
    if( !empty($_SESSION["username"])) {
       $lastpage= $_SESSION["lastpage"];
		session_unset();//free all session variable
		session_destroy();//销毁一个会话中的全部数据
		setcookie(session_name(),'',time()-3600);//销毁cookie
        setcookie("autologin",0);
        setcookie("signedin",0,0);
		echo '<script type="text/javascript">window.location.href="'.$lastpage.'";</script>';
	}else{
    	var_dump($_SESSION);
        echo '<script type="text/javascript">alert("注销失败，请截图联系kill370354@qq.com"); window.history.go(-1);location.reload();</script>';
	}
?>
