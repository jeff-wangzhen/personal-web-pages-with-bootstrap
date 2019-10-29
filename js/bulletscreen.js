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
    }
    if (!oxmlHttpRequest) {
        alert("不能创建XMLHTTP实例，请截图联系kill370354@qq.com");
        return false;
    }
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
            oSendTip.style.bottom = "0px";
            var ibottom = 0;
            //oSendTip.style.animation = "tipshow 3s";
            var oTipMove = setInterval(function () {
                ibottom++;
                oSendTip.style.bottom = ibottom + "px";
            }, 30);
            setTimeout(
                function () {
                    ibottom = 0;
                    clearInterval(oTipMove);
                    oTipMove = null;
                    oSendTip.style.visibility = "hidden";
                }, 2000);
            if (oxmlHttpRequest.responseText == '<p>y</p>') {
                document.getElementById("oSendTip").style.visibility = "visible";
            }
        }
    }
};
$(document).ready(function () {
        var i = 1;    
        var oContents = eval(sContents); //通过for循环比较数据,进行判断
    function fnShow() {//获取PHP中的json格式的数据,这一步很重要,卡了一晚上如何获得数据
        // var  //将json格式数据用eval()函数转化为JS能处理的数组
        //   console.log(a);
        //console.log(b);
        for (var j = 0; j < oContents.length; j++) {
            if (oContents[j].id == i) {
                send(oContents[j]);
            }
        }
        i++;
    }
    osend = setInterval(function () {
        fnShow();
    }, 2000)
    window.onblur = function () {
        clearInterval(osend);
    }
    window.onfocus = function () {
        osend = setInterval(function () {
            fnShow();
        }, 1000)
    }
});
rows = [-1, -1];
index = 0;
function send(word) {
    do {
        var row = Math.floor(Math.random() * 10);
    }
    while (rows.indexOf(row) > -1);
    rows[(index++) % 5] = row;
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
    }
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
            el.style.zIndex = 3;
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
