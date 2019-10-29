// JavaScript Document
/*
//对二维码部分
window.onload=function(){
  var code1=document.getElementById("code1");
	//getElementById("son1")函数取出的son1对象不是数组
  var code2=document.getElementById("code2");
	code1.style.visibility="visible";
  code1.onmouseenter=function(){code2.style.display="block";code2.style.visibility="visible";
	code2.className=" flipInXCode";//style表示行内定义样式
	};
  code1.onmouseleave=function(){code2.style.display="block";
	code2.className=
		code2.className.replace("flipInXCode","flipOutXCode");//style表示行内定义样式
	};
//行内定义样式级别>id样式>内联样式>外联样式
};
*/
//下面的JS代码来源于腾讯课堂，对箭头加上慢速滚动效果
/*
var oCodeSmall = document.getElementById("code1");
var oCodeBig = document.getElementById("code2");
oCodeSmall.onmouseenter = function () {
    oCodeBig.style.visibility = "visible";
    if (oCodeBig.style.opacity < 1) {
        var i=0;
        i+=0.01;
        var oTimer1 = setInterval(function () {
            oCodeBig.style.opacity =i;
        }, 10)
    }
    ;
    if (oCodeBig.style.opacity > 1) {
        oCodeBig.style.opacity = 1;
        clearInterval(oTimer1);
    }
};
oCodeSmall.onmouseout = function () {
    if (oCodeBig.style.opacity > 0) {
        var i=0;
        i+=0.01;
        var oTimer2 = setInterval(function () {
            oCodeBig.style.opacity = i;
        }, 10)
    };
    if (oCodeBig.style.opacity < 0) {
        oCodeBig.style.visibility = "hidden";
        oCodeBig.style.opacity = 1;
        clearInterval(oTimer2);
    }
};
*/
    $("#code1").mouseenter(function () {
        $("#code2").fadeIn(500);//鼠标移到小二维码上浮现大二维码
    });
    $("#code1").mouseleave(function () {
            $("#code2").fadeOut(500);//慢速消失
        }
    );
if(!navigator.cookieEnabled)alert("为保证网页正常访问，请启用cookie");
function fnAvoidnavigationCover() {//防止点击导航条列表项要留言时，由于导航条固定定位遮挡住文本框，点击时调用
    var oNavigationBar = document.getElementsByClassName("top")[0];
    var oStyle = window.getComputedStyle(oNavigationBar, null);
    var iHeight = parseInt(oStyle.height) + 10;
    //console.log(iHeight, "  ", window.innerWidth);
    if (iHeight < 11) iHeight = 96;
    var oTextareaDiv = document.getElementById("leavemessage");
    if (iHeight > 84) {
        oTextareaDiv.style.marginTop = "-" + iHeight + "px";
        oTextareaDiv.style.paddingTop = iHeight + "px";
    }
    else {
        oTextareaDiv.style.marginTop = "-100px";
        oTextareaDiv.style.paddingTop = "100px";
    }
};
document.getElementsByClassName("top")[0].getElementsByClassName("toleavemessage")[0].addEventListener("click", function (ev) {
    if(window.innerWidth<980)document.getElementsByClassName("btn-navbar")[0].click();});
/*
var oTextarea = document.getElementsByTagName("textarea")[0];
oTextarea.addEventListener("focus", function () {
        // console.log(oTextarea== document.activeElement);
        fnAvoidnavigationCover();
    }
);*/
function fnCreateFrag(iNum) {
    var oFrag = document.createDocumentFragment();
    var oReply = document.createElement("div");
    oReply.style.textAlign = "right";
    oReply.style.display = "block";
    var oForm = document.createElement("form");
    oForm.action = "SubmitReply.php";
    oForm.method = "post";
    oForm.className = "form-actions";
    var oControlGroupDiv = document.createElement("div");
    oControlGroupDiv.className = "lable control-group";
    var oControlsDiv = document.createElement("div");
    oControlsDiv.className = "lable control-group";
    var oTextarea = document.createElement("textarea");
    oTextarea.name = "replytext";
    var oHiddenInput = document.createElement("input");
    oHiddenInput.type = "hidden";
    oHiddenInput.name = "num";
    oHiddenInput.value = parseInt(iNum);
    var oSubmitReply = document.createElement("input");
    oSubmitReply.type = "submit";
    oSubmitReply.name = "submitreply";
    oSubmitReply.className = "submitreply";
    oSubmitReply.value = "回复";
    /*   oSubmitReply.onclick=function () {
           var oContent=oTextarea.innerText;
           if(oContent=="")alert("内容不能为空！");
           else
               createRequest("SubmitReply.php?username='" + oContent + "'");
       }*/
    oControlsDiv.appendChild(oTextarea);
    oControlGroupDiv.appendChild(oControlsDiv);
    oForm.appendChild(oControlGroupDiv);
    oForm.appendChild(oHiddenInput);
    oForm.appendChild(oSubmitReply);
    oTextarea.style.boxSizing = "border-box";
    oTextarea.style.width = "100%";
    oTextarea.style.height = "70px";
    oTextarea.style.display = "block";
    oReply.style.width = "100%";
    oReply.className = "replydiv";
    oReply.appendChild(oForm);
    oFrag.appendChild(oReply);
    oReply.style.display = "none";
    return oReply;
}
/*
$(".submitreply").click(
    function () {
        var oReplyTextarea = $(this).siblings("textarea");
        alert(oReplyTextarea.value.length);
        if (oReplyTextarea.value.length < 1) {
            alert("fdgfd");
            return false;
        }
    }
)*/
/*
调试网页代码切记：
清除浏览器缓存！
清除浏览器缓存！
清除浏览器缓存！
因未清除浏览器缓存而浪费的调试时间，永世不补！悔甚！悔甚！
为了达到二维码淡入淡出效果，已经浪费了不少时间，尝试过css动画flipX，和js代码，和jq代码，都在上面，只因未清除浏览器缓存难以调试成功。
或亦可换浏览器调试。
另外，网上说在html文档开头可补加：
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
清除浏览器缓存！
切记！
切记！
切记！
*/
if ($('html,body').scrollTop() < 200) {
    $('.up').hide();//默认初始时箭头不显示
}
$('.up').click(function () {
    $('html,body').animate({'scrollTop': '0px'}, 500);//滚动动画
});
$(window).scroll(function () {
    if ($(this).scrollTop() < 200) {//高度不足200px，箭头自动隐藏，否则出现
        $('.up').fadeOut("slow");//慢速消失
    } else {
        $('.up').fadeIn("slow");//慢速显现
    }
});
(function () {
    var coreSocialistValues = ["富强", "民主", "文明", "和谐", "自由", "平等", "公正", "法治", "爱国", "敬业", "诚信", "友善"],
        index = Math.floor(Math.random() * coreSocialistValues.length);
    if (window.addEventListener)
        document.body.addEventListener('click',
            function (e) {
                fnShowText(e);
            });
    else {
        document.body.attachEvent('onclick', function (e) {
            fnShowText(e);
        });
    }
    function fnShowText(e) {
        //   console.log(e.target.className)
         if (e.target.tagName == 'A' ||e.target.tagName == 'TEXTAREA'||e.target.tagName == 'INPUT' || e.target.className.indexOf("like") > -1) {
            return;
        }
        //console.log(e.target.className)
        var x = e.pageX, y = e.pageY, span = document.createElement('span');
        span.textContent = coreSocialistValues[index];
        index = (index + 1) % coreSocialistValues.length;
        span.style.cssText = ['z-index: 1; position: absolute; font-weight: bold; color: #ff6651; top: ', y - 20, 'px; left: ', x, 'px;'].join('');
        document.body.appendChild(span);
        animate(span);
    }
}());
function animate(el) {
    var i = 0, top = parseInt(el.style.top), id = setInterval(frame, 16.7);
    function frame() {
        if (i > 180) {
            clearInterval(id);
            el.parentNode.removeChild(el);
        } else {
            i += 2;
            el.style.top = top - i + 'px';
            el.style.opacity = (180 - i) / 180;
        }
    }
}
/*
function iEsc(){console.log("esc"); return false; }
function iRec(){ console.log("rec");return true; }
function DisableKeys() {
    if(event.ctrlKey || event.shiftKey || event.altKey)  {
        console.log("DisableKeys");
        window.event.returnValue=false;
        iEsc();}
}
document.ondragstart=iEsc;
document.onkeydown=DisableKeys;
document.oncontextmenu=iEsc;
console.log(document.onselectstart !="undefined");
if (typeof document.onselectstart !="undefined") document.onselectstart=iEsc;
else
{
    document.onmousedown=iEsc;
    document.onmouseup=iRec;
}
function DisableRightClick(e)
{
    if (window.Event){ console.log(ie); if (e.which == 2 || e.which == 3) iEsc();}
    else
    if (event.button == 2 || event.button == 3)
    {
        event.cancelBubble = true
        event.returnValue = false;
        iEsc();
    }
}
*/
