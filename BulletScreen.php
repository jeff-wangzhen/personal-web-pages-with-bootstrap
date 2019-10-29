
    <style>
        .divcontainer {
            position: fixed;
            z-index: 2;
            font-family: "微软雅黑";
            font-size: 18px;
            white-space: nowrap;
            padding: 0;
            margin: 0;
            cursor: pointer;
            box-sizing: border-box;
        }
        .likeicon {
            background-image: url(images/like.png);
            background-position-y: top;
            height: 23.9946px;
            display: inline-block;
            width: 23.9946px;
            vertical-align: bottom;
        }
        .likeicon:hover {
            background-position-y: bottom;
        }
        .dislikeicon {
            background-image: url(images/like.png);
            background-position-y: top;
            height: 23.9946px;
            display: inline-block;
            width: 23.9946px;
            vertical-align: bottom;
            transform: rotate(180deg);
            -ms-transform: rotate(180deg); /* Internet Explorer */
            -moz-transform: rotate(180deg); /* Firefox */
            -webkit-transform: rotate(180deg); /* Safari 和 Chrome */
            -o-transform: rotate(180deg); /* Opera */
        }
        .dislikeicon:hover {
            background-position-y: bottom;
        }
        .hovertip {
            position: fixed;
            display: none;
        }
        #oBigDiv {
            position: fixed;
            text-align: center;
            background-color: rgb(199, 232, 207);
            width: 100%;
            bottom: 0;
            /*    animation: oBigDivshow 3s;*/
            padding: 0px;
            margin: 0;
        }
        @keyframes oBigDivhide {
            from {
                bottom: 0px;
            }
            to {
                bottom: -50px;
            }
        }
        @keyframes tipshow {
            from {
                bottom: 0px;
            }
            to {
                bottom: 50px;
            }
        }
        @keyframes oBigDivanimate {
            from {
                right: 00px;
            }
            to {
                left: -400px;
            }
        }
        @keyframes oBigDivshow {
            from {
                bottom: -50px;
            }
            to {
                bottom: 0;
            }
        }
        #sendtip {
            font-family: 楷体;
            color: #00df00;
            position: absolute;
            visibility: hidden;
            left: 0px;
            right: 0px;
        }
    </style>

<?php //连接数据库语句
$dbms = 'mysql';    //数据库类型 ,对于开发者来说，使用不同的数据库，只要改这个，不用记住那么多的函数
$host = 'localhost';    //数据库主机名
$dbName = 'a0912161003'; //使用的数据库
$user = 'a0912161003';        //数据库连接用户名
$pass = 'qaz123';    //对应的密码
$dsn = "$dbms:host=$host;dbname=$dbName";
$pdo = new PDO($dsn, $user, $pass);    //初始化一个PDO对象，就是创建了数据库连接对象$pdo
//$pdo->query("set names 'g'");if(isset($_POST["txt"])){
//echo $_POST["txt"];
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
$q="";
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
<div id="oBigDiv">
    <input type="text" maxlength="25" name="txt" id="txt"/>
    <input type="button" id="sendbtn" onclick="onsend()" value="发送弹幕"/>
    <span id="sendtip">发送成功！</span>
</div>
<script src="/js/jquery.js"></script>
<script>

    
    document.getElementById("txt").addEventListener("keyup", function (ev) {  //alert(event.keyCode)
        if (event.keyCode == 13) {
            event.cancelBubble = true;
            event.returnValue = false;
            document.getElementById('sendbtn').click();
            return false;
        }
    });
    oBigDiv = document.getElementById("oBigDiv");
    window.addEventListener("mousemove", function fnShowDiv(ev) {
            if (parseInt(ev.y) > eval(parseInt(window.innerHeight) - 50)) {
                oBigDiv.style.animation = "oBigDivshow 1s";
                setTimeout(
                    function () {
                        oBigDiv.style.bottom = "0px";
                    }, 1000
                )
            }
            else {
                oBigDiv.style.animation = "oBigDivhide 2s";
                oBigDiv.style.bottom = "-50px";
            }
        }
    )
    function onsend() {
        var sBulletScreen = document.getElementById("txt").value;
        if (sBulletScreen.length > 0) {
            send(sBulletScreen);
            createRequest("AddBulletScreen.php?sBulletScreen=" + sBulletScreen + "");
        }
    }
    var oxmlHttpRequest = false;
    function createRequest(url) {   //初始化对象并发出XMLHttpRequest请求
        oxmlHttpRequest = false;
        if (window.XMLHttpRequest) { //Mozilla等其他浏览器
            oxmlHttpRequest = new XMLHttpRequest();
            //修复某些版本的火狐浏览器的bug
            if (oxmlHttpRequest.overrideMimeType) {
                oxmlHttpRequest.overrideMimeType("text/xml");
            }
        } else if (window.ActiveXObject) {     //IE浏览器
            try {
                oxmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    oxmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                }
            }
        };
        if (!oxmlHttpRequest) {
            alert("不能创建XMLHTTP实例，请截图联系kill370354@qq.com");
            return false;
        };
        oxmlHttpRequest.onreadystatechange = alertContents;
        sUrl = url.match(/.*php/)[0];
        sRequest = url.substring(sUrl.length + 1);
        //指定响应方法函数
        oxmlHttpRequest.open("POST", sUrl, true);
        oxmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        oxmlHttpRequest.send(sRequest);
    };
    function alertContents() {   	 //处理服务器返回的信息
        //   var oUserTip = document.getElementById("usertip");
        if (oxmlHttpRequest.readyState == 4) {
            if (oxmlHttpRequest.status == 200) {
                //oUserTip.style.display = "inline";
                document.getElementById("txt").value = "";
                oSendTip = document.getElementById("sendtip");
                oSendTip.style.visibility = "visible";
                oSendTip.style.animation = "tipshow 3s";
                setTimeout(
                    function () {
                        oSendTip.style.visibility = "hidden";
                    }, 2000);
                if (oxmlHttpRequest.responseText == '<p>y</p>') {
                    document.getElementById("oSendTip").style.visibility = "visible";
                } else {
                }
            }
        }
    };
    $(document).ready(function () {
        var i = 1;
        function fnShow() {//获取PHP中的json格式的数据,这一步很重要,卡了一晚上如何获得数据
            var a = <?php echo(($res))?>; //将json格式数据用eval()函数转化为JS能处理的数组
           //   console.log(a);
            var b = eval(a); //通过for循环比较数据,进行判断
             //console.log(b);
            for (var j = 0; j < b.length; j++) {
                if (b[j].id == i) {
                    send(b[j]);
                }
            }
            i++;
        };
        osend = setInterval(function () {
            fnShow();
        }, 2000);
        window.onblur = function () {
            clearInterval(osend);
        };
        window.onfocus = function () {
            osend = setInterval(function () {
                fnShow();
            }, 1000)
        }
    });
    rows=[-1,-1];index=0;
    function send(word) {
        do{var row = Math.floor(Math.random() * 10);}
        while (rows.indexOf(row)>-1);
        rows[(index++)%5]=row;
        var oBigDiv = document.createElement('div');
        var top = parseInt(row * 30);
        var color1 = parseInt(Math.random() * 256);
        var color2 = parseInt(Math.random() * 256);
        var color3 = parseInt(Math.random() * 256);
        var color = "rgb(" + color1 + "," + color2 + "," + color3 + ")";
        top = top < 90 ? 90 : top;
        oBigDiv.className = "divcontainer";
        oBigDiv.style.top = top + "px";
        oBigDiv.style.color = color;
        oBigDiv.style.left = parseInt(window.innerWidth) + "px";
        if (send.caller == onsend) {
            oBigDiv.style.border = "solid 2px " + "rgb(" + color3 + "," + color2 + "," + color1 + ")";
        };
        var nub = Math.floor(Math.random() * 10 + 20);
        var oWordDiv = document.createElement('div');
        oWordDiv.innerHTML = word.message || word;
        var oHoverDiv = document.createElement('div');
        var oLikeSpan = document.createElement('span');
        var oId = document.createElement('span');
        var oDisLikeikeSpan = document.createElement('span');
        var oLikeSpanNum = document.createElement('span');
        var oDisLikeikeSpanNum = document.createElement('span');
        oId.innerHTML = word.id;
        oId.style.display = "none";
        // oId.style.display="none";
        oLikeSpan.className = "likeicon";
        oDisLikeikeSpan.className = "dislikeicon";
        oLikeSpanNum.innerHTML = word.likenum || "自己的不能点";
        oDisLikeikeSpanNum.innerHTML = word.dislikenum || "自己的不能点";
        $(oHoverDiv).append(oId);
        $(oHoverDiv).append(oLikeSpan);
        $(oHoverDiv).append(oLikeSpanNum);
        $(oHoverDiv).append(oDisLikeikeSpan);
        $(oHoverDiv).append(oDisLikeikeSpanNum);
        oHoverDiv.className = "hovertip";
        $(oBigDiv).append(oWordDiv);
        $(oBigDiv).append(oHoverDiv);
        $('body').append(oBigDiv);
        fnAnimate(oBigDiv, nub);
        it = 0;
        function fnAnimate(el, nub) {
            var i = 0, iLeft = parseInt(el.style.left), oAnimation = setInterval(frame, nub);
            el.addEventListener("mouseenter", function (ev) {
                clearInterval(oAnimation);
                var oHoverBox = this.childNodes[1];
                el.style.zIndex=3;
                oHoverBox.style.display = "inline-block";
                if (ev.clientX - oHoverBox.clientWidth / 2 > parseInt(this.style.left))
                    oHoverBox.style.left = ev.clientX - oHoverBox.clientWidth / 2 + "px";
                else oHoverBox.style.left = parseInt(this.style.left) + "px";
                oBigDiv.style.backgroundColor = "rgba(" + color2 + "," + color3 + "," + color1 + ",0.1)";
            });
            el.childNodes[1].childNodes[1].addEventListener("click", function () {
                var node = this;
                $.post("LikeAndDislike.php", {"id": this.previousSibling.innerHTML, "like": 1}, function (result) {
                    node.nextSibling.innerHTML++;
                });
            });
            el.childNodes[1].childNodes[3].addEventListener("click", function () {
                var node = this;
                $.post("LikeAndDislike.php", {
                    "id": this.previousSibling.previousSibling.previousSibling.innerHTML,
                    "dislike": 1
                }, function (result) {
                    node.nextSibling.innerHTML++;//=parseInt(this.nextSibling.innerHTML)+1;
                });
            });
            el.addEventListener("mouseleave", function () {
                el.style.backgroundColor = "transparent";
                this.childNodes[1].style.display = "none";
                oAnimation = setInterval(frame, nub);
            });
            function frame() {
                if (parseInt(el.style.left) < -400) {
                    clearInterval(oAnimation);
                    el.parentNode.removeChild(el);
                } else {
                    i += 2;
                    el.style.left = (iLeft - i) + 'px';
                }
            }
        }
    }
</script>
