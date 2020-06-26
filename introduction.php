<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="renderer" content="webkit" />
    <meta name="author" content="王振"/>
    <meta name="generator" content="phpstorm"/>
    <meta name="keywords" content="HTML, CSS, 个人网页,学生,初级"/>
    <meta name="description" content="这是一个普通高等学校计算机科学与技术专业二年级学生的作业网页，欢迎访问！限于作者水平，难免有些不足，敬请见谅！"/>
    <title>王振的个人主页</title>
    <link rel="stylesheet" type="text/css" href="css/base.css"/>
    <link rel="stylesheet" type="text/css" href="css/introduction.css"/>
    <link rel="stylesheet" type="text/css" href="css/bulletscreen.css"/>
    <link rel="stylesheet" type="text/css" href="css/rightmenu.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script></head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: kill370354
 * Date: 2018/6/11
 * Time: 21:25
 */
header('Content-Type:text/html; charset=utf-8');
include "Connect.php";
error_reporting(0);
if (isset($_SESSION["username"])) $user_name = $_SESSION["username"];
else $user_name = $_GET["username"];
$dir = 'tmp/';
session_save_path($dir);
session_start();
$_SESSION["id"] = session_id();$_SESSION["lastpage"] = "introduction.php";
if (!isset($_SESSION["username"]) || empty($_SESSION["username"]))    //登录
    $user_flag = 0;
else $user_flag = 1;
if (isset($_POST["txt"])) {
    //echo $_POST["txt"];
    try {
        $pdo->beginTransaction();
        // $pdo->query("set names 'utf8'");
        $query_bullet_screen = "insert into tb_danmu (message,datetime) values (? , date('Y-m-d H:i:s') )";
        $query_bullet_screen = $pdo->prepare($query_bullet_screen);
        $query_bullet_screen->bindParam(1, $_POST['txt']);
        $query_bullet_screen->execute();
        echo $query_bullet_screen->errorCode();
        $pdo->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "<br/><br/>PDO事务处理失败，请告知kill370354@qq.com";
        $pdo->rollBack();
    }
}
$query_bullet_screens = $pdo->query("select * from tb_danmu ");
//var_dump($query_bullet_screens);
$res = array();
$i = 0; //通过遍历获取$sql语句取出的内容,将其存入数组中
$q = "";
while ($row = $query_bullet_screens->fetch(PDO::FETCH_OBJ)) {
    $res[$i] = $row;
    $i++;
};
$i--; //将数据数组封装为json格式,用于js的接收
json_encode($res, JSON_UNESCAPED_UNICODE);
//echo implode(" ",$res);
//$res=urldecode( $comma_separated );
//echo $res[--$i][2];
//var_dump($res);
$res = json_encode($res);
?>
<?php
include "top.php";
?>
    <div class="container">
        <!--制作主体部分-->
        <!--制作banner部分-->
        <div class="banner text-center">
            <div class="myname text-center">王振</div>
            <div class="htmlname">的个人主页</div>
        </div>
        <!--调整内容位置，以使中间不至留大片空白-->
        <div class="resume text-center row-fluid  ">
            <!--制作照片部分-->
            <div class="resumetable  text-center">
                <div class="span5"><img src="images/myself.jpg" class="img-circle" alt="王振" title="王振"></div>
                <!--调整内容位置，以使中间不至留大片空白-->
                <table class=" text-left table-bordered  table-hover table-striped" cellpadding="6px"
                       cellspacing="10px">
                    <!--用表格说明个人信息
                    以下内容使用了行内样式，是因为我觉得没有必要分离，毕竟只有那一个地方才会用到对应样式，分离出来反而不好找
                    -->
                    <tr>
                        <td scope="row" class="text-center">姓名</td>
                        <td style="letter-spacing:16px;">王振</td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-center"> 性别</td>
                        <td>男</td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-center">血型</td>
                        <td>AB</td>
                    </tr>
                    <tr>
                        <td class="text-center" scope="col"> 生日</td>
                        <td>1997-09-12</td>
                    </tr>
                    <tr>
                        <td class="text-center" scope="col"> 虚度人生</td>
                        <td><span id="lifedays"></span> 日</td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-center"> 出生地</td>
                        <td>江西省&nbsp;&nbsp;上饶市&nbsp;&nbsp;上饶县</td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-center">现居地</td>
                        <td>重庆市&nbsp;&nbsp;沙坪坝区&nbsp;&nbsp;虎溪镇</td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-center">学校</td>
                        <td>重庆师范大学</td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-center">手机号</td>
                        <td>188 7522 0381</td>
                    </tr>
                </table>
                <!--表格结束-->
            </div>
        </div>
        <br/><br/>
        <!--增加br是为了消除误差-->
        <div class="grzs text-left">
            <form>
                <fieldset>
                    <!--这是从网上找的属性，为了实现边框中加文字的效果-->
                    <!--个人自述开始-->
                    <legend>个人自述</legend>
                    <p><span style="word-spacing:30px">我</span>出生于江西省上饶县，自从初中开始，我的成绩就不怎么好。初中时，在老师们的熏陶下，感觉到似乎只有上重点中学才能实现多年的大学梦想，可惜我成绩不佳不能被县里的重点中学录取。所以，我一直倾慕重点中学的同学，在我眼中，他们都是人才，我又何德何能，岂能追及！
                    </p>
                    <p>后来我还是和他们一起参加高考，但是，成绩仍旧不能满足升学的愿望。于是只好去复读了。</p>
                    <p> 现在我考进了一所大学，受着高等教育，终于体会到了幼时梦想的地方的现实版本，身边也有一些从重点中学来的人。通过与他们的交往，我感觉到，所谓的重点中学，并不是那么高不可攀。</p>
                    <p>不管怎样，人之生于世，不能总是仰望别人的高度，生命是自己的，要为自己活着，为自己努力。</p>
                    <p></p>
                    <p class="zhyh lead ">一个坚强的人，无论身处何时何地，都不会因外界环境而改变自己的<span class="qd">意志与操守</span>。</p>
                </fieldset>
            </form>
        </div>
    </div>
    <div id="oBigDiv" class="text-center">
        <!--弹幕发送框-->
        <input type="text" maxlength="25" name="txt" id="txt"/>
        <input type="button" id="sendbtn" onclick="onsend()" value="发送弹幕"/>
        <span id="sendtip">发送成功！</span>
    </div>
    <div class="rightnav">
        <div class="up">
            <img src="images/top.png" width="50" height="50"></div>
        <!--向上箭头-->
        <a href="Messages.php">
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
    <div class="foot text-center">重庆师范大学计算机与信息科学学院16计科王振制作，版权所有</div>
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
    <script type="text/javascript" src="js/base.js"></script><!--引用基础js代码-->
    <script type="text/javascript" src="js/introduction.js"></script><!--引用基础js代码-->
    <script type="text/javascript" src="js/bulletscreen.js"></script><!--引用弹幕js代码-->
    <script type="text/javascript" src="js/rightmenu.js"></script><!--引用右键菜单js代码-->
    <script>
        sContents = <?php echo(($res))?>;
    </script>
</body>
</html>
