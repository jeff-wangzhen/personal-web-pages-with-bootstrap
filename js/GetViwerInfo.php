<?php
/**
 * Created by PhpStorm.
 * User: kill370354
 * Date: 2018/5/2
 * Time: 16:47
 */
header('Content-Type:text/html; charset=utf-8');
include "../grwzb/Connect.php";
$dir = '../grwzb/tmp/';
session_save_path($dir);
session_start();
echo "<p>";
$_SESSION["id"] = session_id();
function getIp()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP") . "HTTP_CLIENT_IP";
    else
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR") . "HTTP_X_FORWARDED_FOR";
        else
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                $ip = getenv("REMOTE_ADDR") . "REMOTE_ADDR";
            else
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                    $ip = $_SERVER['REMOTE_ADDR'] . "REMOTE_ADDR";
                else
                    $ip = "unknown";
    return ($ip);
}

function GetIpLookup($get_Ip = '')
{

    preg_match("/(\d*\.){3}\d*/", $get_Ip, $ip);
    var_dump($ip);
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip[0]);
    if (empty($res)) {
        return false;
    }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if (!isset($jsonMatches[0])) {
        return false;
    }
    $json = json_decode($jsonMatches[0], true);
    if (isset($json['ret']) && $json['ret'] == 1) {
        $json['ip'] = $ip;
        unset($json['ret']);
    } else {
        return false;
    }
    return $json;
}

$get_Ip = getIp();
$ipInfos = GetIpLookup($get_Ip); //baidu.com IP地址
var_dump($ipInfos);
function get_user_device($ua)
{
    if (stripos($ua, "HONOR") !== false || stripos($ua, "HUAWEI") !== false)
        return "华为";
    if (preg_match("/MI(?!cro|x)/i", $ua))
        return "小米";
    if (stripos($ua, "SM-") !== false)
        return "三星";
    if (preg_match("/MX(?!B48T)/i", $ua))
        return "魅族";
    if (stripos($ua, "OPPO") !== false)
        return "OPPO";
    if (stripos($ua, "vivo") !== false)
        return "vivo";
    if (preg_match("/(YQ|OD|SM)\d{3}/i", $ua))
        return "锤子坚果";
    if (stripos($ua, "Coolpad") !== false)
        return "酷派";
    if (stripos($ua, "GIONEE") !== false)
        return "金立";
    if (stripos($ua, "iPhone") !== false)
        return "iPhone ";
    if (stripos($ua, "ipad") !== false)
        return "iPad ";
    if (stripos($ua, "Nokia") !== false)
        return "诺基亚";
    if (preg_match("/letv|Le {0,1}X|EUI/i", $ua))
        return '乐视';
    if (stripos($ua, "ZTE") !== false)
        return "中兴";
    if (stripos($ua, "Lenovo") !== false)
        return "联想";
    return "";
}

function get_user_OS($ua)
{
    $device = get_user_device($ua);
    if (stripos($ua, "Android") || stripos($ua, "ADR") !== false)
        return $device . "安卓版";
    if (stripos($ua, "win") !== false) {
        if (stripos($ua, "windows phone") !== false)
            return $device . "WP系统";
        if (stripos($ua, "NT 6.1") !== false)
            return $device . "Win7系统";
        if (stripos($ua, "NT 6.4") !== false || stripos($ua, "NT 10.0") !== false)
            return $device . "Win10系统";
        if (stripos($ua, "NT 5.1") !== false || stripos($ua, "NT 5.2") !== false)
            return $device . "WinXP系统";
        if (stripos($ua, "NT 6.2") !== false)
            return $device . "Win8系统";
        if (stripos($ua, "NT 6.3") !== false)
            return $device . "Win8.1系统";
        if (stripos($ua, "NT 6.0") !== false)
            return $device . "WinVista系统";
        if (stripos($ua, "NT 5.2") !== false)
            return $device . "Win2003系统";
        if (stripos($ua, "NT 5.0") !== false)
            return $device . "Win2000系统";
        return $device . "Windows系统";
    }
    if (stripos($ua, "iPhone") !== false)
        return $device . "iPhone版";
    if (stripos($ua, "ipad") !== false)
        return $device . "iPad版";
    if (stripos($ua, "iOS") !== false)
        return $device . "iOS版";
    if (stripos($ua, "Symbian") !== false)
        return $device . "塞班版";
    if (stripos($ua, "mobile") !== false)
        return $device . "手机版";
    if (stripos($ua, "Mac") !== false)
        return $device . "Mac系统";
    if (stripos($ua, "Linux") !== false)
        return $device . "Linux系统";
    if (stripos($ua, "Unix") !== false)
        return $device . "Unix系统";
    return $device . "";
}

function get_user_browser()
{
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if ($ua == "") return '';
    $os = get_user_OS($ua);
    echo $ua;
    if (stripos($ua, "MicroMessenger") !== false)
        return $os . '微信';
    if (stripos($ua, "QQBrowser") !== false) {
        if (stripos($ua, "QQ/") !== false)
            return $os . 'QQ客户端';
        return $os . 'QQ';
    }
    if (stripos($ua, "2345Explorer") !== false)
        return $os . '2345加速';
    if (stripos($ua, "MetaSr") !== false)
        return $os . '搜狗高速';
    if (stripos($ua, "LBBROWSER") !== false)
        return $os . '猎豹';
    if (stripos($ua, "Maxthon") !== false)
        return $os . '傲游';
    if (stripos($ua, "TheWorld") !== false)
        return $os . '世界之窗';
    if (stripos($ua, "weibo") !== false)
        return $os . '微博';
    if (stripos($ua, "IDU") !== false)
        return $os . '百度';
    if (stripos($ua, "AliApp") !== false)
        return $os . '阿里应用';
    if (stripos($ua, "UC") !== false || stripos($ua, "UBrowser") !== false)
        return $os . 'UC';
    if (stripos($ua, "360SE") !== false)
        return $os . '360安全';
    if (stripos($ua, "360EE") !== false)
        return $os . '360极速';
    if (stripos($ua, "360") !== false)
        return $os . '360';
    if (stripos($ua, "EUI") !== false)
        return $os . '乐视';
    if (stripos($ua, "Edge") !== false)
        return $os . 'Edge';
    if (stripos($ua, "Firefox") !== false)
        return $os . 'Firefox';
    if (stripos($ua, "OPR") !== false || stripos($ua, "Opera") !== false)
        return $os . 'Opera';
    if (stripos($ua, "MSIE") !== false) {
        if (stripos($ua, "rv:11") !== false)
            return $os . 'IE11';
        if (stripos($ua, "MSIE 10.0") !== false)
            return $os . 'IE10';
        if (stripos($ua, "MSIE 9.0") !== false)
            return $os . 'IE9';
        if (stripos($ua, "MSIE 8.0") !== false)
            return $os . 'IE 8.0';
        if (stripos($ua, "MSIE 7.0") !== false)
            return $os . 'IE 7.0';
        if (stripos($ua, "MSIE 6.0") !== false)
            return $os . 'IE 6.0';
        return $os . 'IE';
    }
    if (stripos($ua, "Chrome") !== false)
        return $os . 'Chrome';
    if (stripos($ua, "Safari") !== false)
        return $os . 'Safari';
    return $os;
}
$browser = get_user_browser();
$ip = getIP();
$HTTP_X_REAL_IP = $_SERVER['HTTP_X_REAL_IP'];
$HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
$datetime = date("Y-m-d H:i:s");
$useragent = $_SERVER['HTTP_USER_AGENT'];
//$url = substr($_POST['url'], 0, strpos($_POST['url'], '?'));
$url = $_POST['url'];
$address = $ipInfos["country"] . "  " . $ipInfos["province"] . "  " . $ipInfos["city"];
echo "000000000000".$_POST['url']."111111111111";
var_dump($_POST);
?>
<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>
<?php
echo "<br/><br/>";
echo "<br/><br/>";
//$str = '123/456/789/abc';
//echo substr($str, 0, strpos($str, '/'));
//echo "<br/><br/>";
//$array = explode('/', $str);
echo "<br/><br/>111111111111111111111111111111";
echo $url;
echo "<br/><br/>";

try {
    $pdo->beginTransaction();
    if (stripos($useragent, "kill370354mixed") === false){
    $query = "INSERT INTO tb_viewerinfo (ip,browser,viewtime,HTTP_X_REAL_IP,HTTP_X_FORWARDED_FOR,REMOTE_ADDR,address,useragent,url) VALUES ('$get_Ip','$browser','$datetime','$HTTP_X_REAL_IP','$HTTP_X_FORWARDED_FOR','$REMOTE_ADDR','$address','$useragent','$url')";
    $result = $pdo->query($query); //查询符合条件的记录总条数
    echo $query;
    if($result)echo "插入成功！";
    else echo "插入失败！";}
    ?>
    <style>
        td{ border: 1px cyan solid; word-break: break-all;word-wrap: break-word; }
    </style>
    <table>
        <tr><td>id</td><td>url</td><td>ip</td><td>HTTP_X_REAL_IP</td><td>HTTP_X_FORWARDED_FOR</td><td>REMOTE_ADDR</td><td>address</td>
            <td>useragent</td><td>browser</td><td>viewtime</td></tr>
    <?php
    $query2 = "SELECT * FROM tb_viewerinfo";
    $result2 = $pdo->query($query2); //查询符合条件的记录总条数
   while($res=$result2->fetch(PDO::FETCH_ASSOC))
   {?>
      <tr>
          <td> <?php echo $res["id"];?></td>   <td><?php echo $res["url"];?></td> <td><?php echo $res["ip"];?></td>
          <td><?php echo $res["HTTP_X_REAL_IP"];?></td> <td><?php echo $res["HTTP_X_FORWARDED_FOR"];?></td> <td><?php echo $res["REMOTE_ADDR"];?></td><td><?php echo $res["address"];?></td><td><?php echo $res["useragent"];?></td><td><?php echo $res["browser"];?></td><td><?php echo $res["viewtime"];?></td>
      </tr>
<?php

   };
   ?>
    </table>
    <?php
    $pdo->commit();
} catch (PDOException $e) {
    echo $e->getMessage();
    $pdo->rollBack();
}
echo "</p>";

?>

