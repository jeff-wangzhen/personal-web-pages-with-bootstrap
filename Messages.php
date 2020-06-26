<?php
header('Content-Type:text/html; charset=utf-8');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="renderer" content="webkit"/>
    <meta name="author" content="王振"/>
    <meta name="generator" content="phpstorm"/>
    <meta name="keywords" content="HTML, CSS, 个人网页,学生,初级"/>
    <meta name="description" content="这是一个普通高等学校计算机科学与技术专业二年级学生的作业网页，欢迎访问！限于作者水平，难免有些不足，敬请见谅！"/>
    <title>留言</title>
    <link rel="stylesheet" type="text/css" href="css/base.css"/>
    <link rel="stylesheet" type="text/css" href="css/messageboard.css"/>
    <link rel="stylesheet" type="text/css" href="css/rightmenu.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <style>
        .container { /*覆盖背景*/
            background-color: rgb(245, 245, 245);
        }

    </style>
</head>
<body>
<?php
include "Connect.php";
error_reporting(0);
$dir = 'tmp/';
session_save_path($dir);
session_start();
if (isset($_SESSION["username"])) $user_name = $_SESSION["username"];
$_SESSION["id"] = session_id();
$_SESSION["lastpage"] = "Messages.php";
if (isset($_GET["useronly"])) {
    if ($_GET["useronly"] == "no") {
        unset($_SESSION["useronly"]);
    } else  $_SESSION["useronly"] = $_GET["useronly"];
}
if (!empty($_SESSION["useronly"])) $_SESSION["useronly"] = $_SESSION["useronly"];
if (!isset($_SESSION["username"]) || empty($_SESSION["username"]))    //登录
    $user_flag = 0;
else $user_flag = 1;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else $page = 1;
if (!is_numeric($page)) return;
else {
    $page_size = 10;    //每页显示4条记录
    $user_only = NULL;
    $offset = ($page - 1) * $page_size;//计算下一页从第几条数据开始循环
    if (isset($_GET["searchcontent"])) {//是否仅看本人留言、是否有搜索内容
        $_SESSION["searchinputcontent"] = $_GET["searchcontent"];
        $_SESSION["searchcontent"] = preg_replace("/%/", "\%", $_GET["searchcontent"]);
        $_SESSION["searchcontent"] = preg_replace("/_/", "\_", $_SESSION["searchcontent"]);
        $_SESSION["searchcontent"] = "%" . $_SESSION["searchcontent"] . "%";
    }
    if ($_GET["searchcontent"] == "" && isset($_GET["searchinput"]) && isset($_SESSION["searchcontent"])) {
        unset($_SESSION["searchcontent"]);
        unset($_SESSION["searchinputcontent"]);
    }
    if (!empty($_SESSION["useronly"])) {
        if (!empty($_SESSION["searchcontent"])) {
            $messagescount = "SELECT COUNT(*)  from tb_messages where messages like ? and truename='" . $_SESSION["useronly"] . "'";
            $messagesql = "select * from tb_messages where messages like ? and truename='" . $_SESSION["useronly"] . "' order by  id  limit $offset, $page_size";
            $messagescount = $pdo->prepare($messagescount);
            $messagescount->bindParam(1, $_SESSION["searchcontent"]);
            $result = $pdo->prepare($messagesql);
            $result->bindParam(1, $_SESSION["searchcontent"]);
        } else {
            $messagescount = "SELECT COUNT(*)  from tb_messages where truename='" . $_SESSION["useronly"] . "'";
            $messagesql = "select * from tb_messages where truename='" . $_SESSION["useronly"] . "' order by  id  limit $offset, $page_size";
            $result = $pdo->prepare($messagesql);
            $messagescount = $pdo->prepare($messagescount);
        }
    } else if (!empty($_SESSION["searchcontent"])) {
        $messagescount = "SELECT COUNT(*)  from tb_messages where messages like ?";
        $messagescount = $pdo->prepare($messagescount);
        $messagescount->bindParam(1, $_SESSION["searchcontent"]);
        $messagesql = "select * from tb_messages where messages like ?  order by  id  limit $offset, $page_size";
        $result = $pdo->prepare($messagesql);
        $result->bindParam(1, $_SESSION["searchcontent"]);
    } else {
        $messagescount = "select COUNT(*) from  tb_messages  ";
        $messagescount = $pdo->prepare($messagescount);
        $messagesql = "select * from  tb_messages order by  id  limit $offset, $page_size";
        $result = $pdo->prepare($messagesql);
    }
    try {

        $pdo->beginTransaction();
        $messagescount->execute();
        $message_count = $messagescount->fetch(PDO::FETCH_BOTH)[0]; //查询符合条件的记录总条数
        $page_count = ceil($message_count / $page_size);    //根据记录总数除以每页显示的记录数求出所分的页数
        $result->execute();
        $row = $result->fetch(PDO::FETCH_OBJ);
        if ($user_flag) {
            if (!isset($_SESSION["user_portrait"]) || empty($_SESSION["user_portrait"]) || $_SESSION["user_portrait"] == "NULL") {
                $_SESSION["user_portrait"] = "client1.jpg";
                $sql_user_portrait = $pdo->query("select portrait from tb_grwzphpusers where username='" . $_SESSION["username"] . "'");
                if ($sql_user_portrait) {
                    $result_user_portrait = $sql_user_portrait->fetch(PDO::FETCH_OBJ);
                    $_SESSION["user_portrait"] = $result_user_portrait->portrait;
                }
            }
        };
        $pdo->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "PDO事务处理失败，请告知kill370354@qq.com";
        $pdo->rollBack();
    }
}
?>
<!--顶部导航项 开始-->
<?php
include "top.php";
?>

<!--导航部分结束-->
<div class="container">
    <div>
        <!--留言部分  开始-->
        <form class="form-actions" id="messageform" method="post"
              action="CheckMessage.php?messagecount=<?php echo "$message_count" ?>&pagecount=<?php echo "$page_count" ?>&pagesize=<?php echo "$page_size" ?>">
            <div class="lable control-group text-center">
                <div class="welcome avoidContentHidden" id="leavemessage">既已到此，何不留言</div>
                <div class="text-right" id="wordnumtip">已输入<span></span>字</div> <!--微博式字数提示-->
                <!--留言功能-->
                <div class="controls">
                    <textarea name="messagetext" id="submitmessagetext" maxlength="10000"></textarea>
                    <div id="messagetext" class=" edui-body-container" contenteditable="true"></div>
                </div>
                <div class="edui-dialog-container">
                    <div class="edui-dropdown-menu edui-popup">
                        <div class="edui-popup-body">
                            <div class="j_emotion_container emotion_container">
                                <div class="s_layer_content j_content ueditor_emotion_content">
                                    <div class="tbui_scroll_panel tbui_no_scroll_bar">
                                        <div class="tbui_panel_content j_panel_content clearfix" style="height: 277px;">
                                            <table class="s_layer_table"
                                                   style="border-collapse:collapse;">
                                                <tbody>
                                                <tr>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="0" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="呵呵"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f01.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left 0px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="1" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="哈哈"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f02.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -30px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="2" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="吐舌"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f03.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -60px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="3" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="啊"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f04.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -90px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="4" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="酷"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f05.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -120px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="5" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="怒"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f06.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -150px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="6" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="开心"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f07.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -180px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="7" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="汗"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f08.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -210px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="8" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="泪"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f09.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -240px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="9" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="黑线"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f10.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -270px;">&nbsp;</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="10"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="鄙视"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f11.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -300px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="11"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="不高兴"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f12.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -330px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="12"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="真棒"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f13.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -360px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="13" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="钱"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f14.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -390px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255);"
                                                        data-value="14" data-sname="face" data-type="normal"
                                                        data-class="s_face"
                                                        data-stype="img" title="疑问"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f15.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -420px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="15"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="阴险"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f16.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -450px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="16"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="吐"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f17.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -480px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="17"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="咦"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f18.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -510px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="18"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="委屈"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f19.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -540px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="19"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="花心"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f20.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -570px;">&nbsp;</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="20"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="呼~"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f21.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -600px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="21"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="笑眼"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f22.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -630px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="22"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="冷"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f23.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -660px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="23"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="太开心"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f24.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -690px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="24"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="滑稽"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f25.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -720px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="25"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="勉强"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f26.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -750px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="26"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="狂汗"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f27.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -780px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="27"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="乖"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f28.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -810px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="28"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="睡觉"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f29.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -840px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="29"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="惊哭"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f30.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -870px;">&nbsp;</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="30"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="升起"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f31.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -900px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="31"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="惊讶"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f32.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -930px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="32"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="喷"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f33.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -960px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="33"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="爱心"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f34.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -990px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="34"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="心碎"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f35.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1020px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="35"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="玫瑰"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f36.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1050px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="36"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="礼物"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f37.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1080px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="37"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="彩虹"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f38.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1110px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="38"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="星星月亮"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f39.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1140px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="39"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="太阳"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f40.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1170px;">&nbsp;</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="40"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="钱币"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f41.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1200px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="41"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="灯泡"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f42.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1230px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="42"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="茶杯"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f43.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1260px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="43"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="蛋糕"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f44.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1290px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="44"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="音乐"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f45.png?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1320px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="45"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="haha"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f46.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1350px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="46"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="胜利"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f47.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1380px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="47"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="大拇指"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f48.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1410px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="48"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="弱"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f49.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1440px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="49"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="OK"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f50.png?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1470px;">&nbsp;</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="50"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="伤心"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f51.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1500px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="51"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="加油"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f52.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1530px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="52"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="必胜"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f53.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1560px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="53"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="期待"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f54.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1590px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="54"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="牛逼"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f55.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1620px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="55"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="胜利"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f56.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1650px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="56"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="跟丫死磕"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f57.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1680px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="57"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="踢球"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f58.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1710px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="58"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="面壁"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f59.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1740px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="59"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="顶"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f60.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1770px;">&nbsp;</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="60"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="巴西怒"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f61.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1800px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="61"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="伴舞"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f62.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1830px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="62"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="奔跑"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f63.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1860px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="63"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="点赞手"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f64.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1890px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="64"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="加油"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f65.gif?t=20140803"
                                                        data-posflag="0"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1920px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="65"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="哭泣"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f66.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1950px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="66"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="亮红牌"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f67.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -1980px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="67"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="球迷"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f68.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -2010px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="68"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="耶"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f69.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -2040px;">&nbsp;</a>
                                                    </td>
                                                    <td class="s_face j_emotion"
                                                        style="border-collapse:collapse;" data-value="69"
                                                        data-sname="face"
                                                        data-type="normal" data-class="s_face"
                                                        data-stype="img" title="转屁股"
                                                        data-surl="//tb2.bdstatic.com/tb/editor/images/face/i_f70.gif?t=20140803"
                                                        data-posflag="1"><a class="img" href="javascript:void(0)"
                                                                            style="display:block;color:#000;font-size:14px;text-decoration:none;background-position:left -2070px;">&nbsp;</a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="emotion_preview j_emotion_preview" style="display: none;"><img
                                            class="review" alt="" title=""
                                            src="//tb2.bdstatic.com/tb/editor/images/face/i_f04.png?t=20140803"
                                            style="left: 15px; top: 15px;">
                                </div>
                            </div>
                        </div>
                        <div class="edui-popup-caret up" style="display: block;"></div>
                    </div>
                </div>
            </div>
            <div id="emotionbtn" class="edui-icon-emotion edui-icon"><img
                        src="//tb2.bdstatic.com/tb/editor/images/face/i_f01.png?t=20140803" alt="添加表情" title="添加表情">
            </div>
            <div id="addbtn">添加图片</div>
            <div id="addimages">
                <div class="upload">
                    <div class="uploadBox">
                        <span class="inputCover"></span>

                        <input type="file" name="file" id="file" accept="image/jpg,image/jpeg,image/png,image/gif"/>
                        <button type="button" class="submitimg">上传</button>

                        <button type="button" class="upagain">继续上传</button>
                        <div id="process">
                            <span class="processBar"></span>
                            <span class="processNum"></span>
                        </div>
                        <div id="previewimages"></div>
                    </div>
                </div>
            </div>
            <input type="hidden" value="" name="images" id="filesinput">
            <div class="text-right controls controls-row"><?php if ($user_flag) {
                    ?><input type="checkbox" name="anonymity" id="anonymity">匿名<?php } ?><input type="submit"
                                                                                                name="submit"
                                                                                                id="submit"
                                                                                                class="submitmessage"

                                                                                                value="提交留言">
            </div>
        </form> <!--留言部分  结束-->
        <?php if ($_GET["ok"]) { ?>
            <div id="tipok" class="text-center">
                留言成功！
            </div>
        <?php } else {
        } ?>
        <section class="messages"> <!--展示留言部分  开始-->
            <?php if ($user_flag == 1) {
                if (!empty($_SESSION["useronly"])) {
                    ?>
                    <div class="useronly">
                        <a id="useronly"
                           href="Messages.php?useronly=no#leavemessage">取消只看我</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="useronly">
                    <a id="useronly"
                       href="Messages.php?useronly=<?php echo "$user_name" ?>#leavemessage">只看我</a>
                    </div><?php
                }
            } else {
                ?>
                <div style="height: 20px;"></div><!--占位，保持布局稳定-->
                <?php
            }
            ?>
            <form action="Messages.php" method="get" class="text-center form-inline input-append">
                <input id="prependedInput" name="searchcontent" type="search"
                       value="<?php echo $_SESSION["searchinputcontent"] ?>" placeholder="请输入关键字"/>
                <input type="submit" class="add-on " id="searchbutton" name="searchinput" value="搜索留言"/>
            </form>
            <?php
            if ($row)
                do {
                    ?>
                    <article class="messagebox-big row-fluid">
                        <div class="leftbox text-center span2">
                            <?php
                            $portrait = "client1.jpg";
                            try {
                                $pdo->beginTransaction();
                                $sqlportrait = $pdo->query("select portrait from tb_grwzphpusers where username='$row->author'");
                                $reply_contents = $pdo->query("select * from tb_my_reply where replyid=$row->id order by id");
                                $pdo->commit();
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                                echo "PDO事务处理失败，请告知kill370354@qq.com";
                                $pdo->rollBack();
                            }
                            if ($sqlportrait) {
                                $resultportrait = $sqlportrait->fetch(PDO::FETCH_OBJ);
                                if (!empty($resultportrait->portrait))
                                    $portrait = $resultportrait->portrait;
                            }
                            echo "<div class='portrait'><img alt='' title='' src='clientportrait/" . $portrait . "'></div><div class=\"replier\">$row->author</div>";
                            ?>
                        </div>
                        <div class='span10'>
                            <div class="messagebox-small"><?php
                                $content = $row->messages;
                                $content = htmlspecialchars($row->messages, ENT_QUOTES);
                                preg_match_all("/&lt;(\w*)\b(.*?\n*?)*?&gt;/", $content, $imgs, PREG_SET_ORDER);
                                foreach ($imgs as $img) {
                                    if (stripos($img[0], "&lt;img") !== false) {
                                        $image = htmlspecialchars_decode($img[0]);
                                        $content = str_replace($img[0], $image, $content);
                                    }
                                }
                                if (isset($_SESSION['searchinputcontent'])) $content = preg_replace("/" . htmlspecialchars($_SESSION['searchinputcontent']) . "/i", "<span style='color:red;'>$0</span>", $content);
                                echo "<div class='messagecontent'>$content</div>";
                                $images = explode(",", $row->images);

                                if (count($images) > 0)
                                    foreach ($images as $img) {
                                        echo "<div class='messageimages'><img src='" . "//" . $img . "' alt='' title='' /> </div>";
                                    }


                                ?></div>
                            <div>
                                <div class="post-tail-wrap text-right"><span class="tail-info like"><span
                                                class="like praise"></span>(<?php echo '<span class="likenum">' . $row->likenum . '</span>' ?>
                                        )</span><span
                                    ><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" ?></span><span
                                            class="tail-info num"><?php echo "$row->id" . "楼&nbsp;&nbsp;" ?></span><?php if ($user_flag && $row->truename == $_SESSION["username"]) {
                                        echo '<a onClick="return confirm(\'确定删除?\');"
                                      href="DeleteMessage.php?id=' . $row->id . '">删除</a>&nbsp;&nbsp;';
                                    } ?><span>来自<?php echo "$row->agent" . "浏览器&nbsp;&nbsp;" ?></span><span
                                    ></span><span
                                    ><?php echo "$row->createtime &nbsp;" ?></span><span
                                    ><a
                                                class="reply"><?php echo "回复" ?></a></span>
                                </div>
                            </div>
                            <div class="replyall">
                                <?php
                                //$reply_contents = $pdo->query("select * from tb_my_reply where replyid=$row->id order by id");
                                if ($reply_contents) {
                                $reply_obj = $reply_contents->fetch(PDO::FETCH_OBJ); ?>
                                <div class="reply_big"><?php
                                    if ($reply_obj) {
                                        $i = 0;
                                        do {
                                            $i++;
                                            ?>
                                            <div class="singlereply <?php if ($i > 3) echo "hidereply"; ?>">
                                                <div class="replycontent"><?php $content = htmlspecialchars($reply_obj->messages, ENT_QUOTES);
                                                    if (isset($_SESSION['searchinputcontent'])) $content = preg_replace("/" . htmlspecialchars($_SESSION['searchinputcontent']) . "/i", "<span style='color:red;'>$0</span>", $content);
                                                    echo "<span>$reply_obj->author</span>" . "：<span>" . $content . "</span>"; ?></div>
                                                <div class="replierbottom text-right"><?php
                                                    echo "<span class='replytime'>" . $reply_obj->createtime . "&nbsp;</span>";
                                                    echo "<a class='replytoreply'>回复</a>";
                                                    ?></div>
                                            </div>
                                            <?php
                                        } while ($reply_obj = $reply_contents->fetch(PDO::FETCH_OBJ));
                                        if ($i > 3) {
                                            ?>
                                            <div class="showallreply text-center">展开全部</div>
                                            <?php
                                        }
                                    }
                                    }
                                    ?></div>
                                <div class="replydiv">
                                    <form action="SubmitReply.php" method="post" class="form-actions">
                                        <div class="lable control-group">
                                            <div class="lable control-group"><textarea name="replytext"
                                                                                       style=" width: 100%; "></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="num" value="1"><input type="submit"
                                                                                         name="submitreply"
                                                                                         class="submitreply" value="回复">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php
                } while ($row = $result->fetch(PDO::FETCH_OBJ));
            else {
                echo "<div class='text-center'>未找到符合条件的留言</div>";
            }
            ?>
            <div class="text-right">
                &nbsp;&nbsp;第<?php echo $page; ?>页&nbsp;&nbsp;共<span
                        id="totalpage"><?php echo $page_count; ?></span>页&nbsp;记录：<?php echo $message_count; ?>
                条&nbsp;
                <?php
                /*  如果当前页不是首页  */
                if ($page != 1) {
                    echo "<a target='_self' href=Messages.php?page=1>首页</a>&nbsp;";
                    echo "<a target='_self' href=Messages.php?page=" . ($page - 1) . ">上一页</a>&nbsp;";
                }
                if ($page < $page_count) {
                    echo "<a target='_self' href=Messages.php?page=" . ($page + 1) . ">下一页</a>&nbsp;";
                    echo "<a target='_self' href=Messages.php?page=" . $page_count . ">尾页</a>";
                }
                ?>
                <div class="help-inline">跳到<input id="jumpPage" class="jump_input_bright"
                                                  type="text"> 页&nbsp;
                    <input id="pager_go" type="button" value="确定" class="btn-sub btn-small jump_btn_bright"
                           onclick="fnJump()"></div>
            </div>
            <!--展示留言部分  结束-->
        </section>
        <div class="foot text-center">重庆师范大学计算机与信息科学学院16计科王振制作，版权所有</div>
        <!--脚注部分-->
        <div class="rightnav">
            <div class="up">
                <img alt="到顶部" title="到顶部" src="images/top.png" width="50" height="50"></div>
            <!--向上箭头-->
            <a href="#leavemessage">
                <div class="toleavemessage" id="gotoleavemessage">
                </div>
            </a>
            <a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=kill370354@qq.com"
               alt="点击这里给我发邮件" title="点击这里给我发邮件">
                <div id="mail"></div>
            </a>
            <div id="code1" class="code"><img src="images/code.png" title="扫一扫，用手机看" alt="扫一扫，用手机看" width="50"
                                              height="50">
            </div>
            <!--小二维码-->
            <div id="code2"><img src="images/code.png" title="扫一扫，用手机看" alt="扫一扫，用手机看" width="280" height="280">
            </div>
            <!--大二维码-->
        </div>
    </div>
</div>
<div id="rightMenu">
    <ul>
        <div class="text-center">右键菜单</div>
        <li>
            想干嘛
            <ul>
                <li class="toleavemessage">留言</li>
                <li id="tosendbarrage">发弹幕</li>
                <li id="noaction">不想干嘛</li>
                <li id="notell">不告诉你</li>
                <li>还能干嘛
                    <ul>
                        <li>你是专业的吗
                            <ul>
                                <li>是的
                                    <ul>
                                        <li class="toleavemessage">请指教</li>
                                    </ul>
                                </li>
                                <li>不是
                                    <ul>
                                        <li class="toleavemessage">留条言吧</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li id="returnmenu">不喜欢这个菜单</li>
            </ul>
        </li>
    </ul>
</div>
<script type="text/javascript" src="js/base.js"></script><!--引用外部js代码-->
<script type="text/javascript" src="js/messageboard.js"></script><!--引用外部js代码-->
<!--<script type="text/javascript" src="js/rightmenu.js"></script>-->
<!--引用外部js代码-->
</body>
</html>
