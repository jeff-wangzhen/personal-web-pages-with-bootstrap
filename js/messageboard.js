var oGoTomessage = document.getElementById("gotoleavemessage");//alert(oGoTomessage);
oGoTomessage.onmouseover = function fnLeave() {
    this.style.backgroundPosition = "right";
};
oGoTomessage.onmouseout = function () {
    this.style.backgroundPosition = "left";
};
if(oMessageText=document.getElementById('messagetext'))
    oMessageText.focus();
var flag = new Array();
var oMessageText = document.getElementById("messagetext");
$("a.reply").click(
    function fnReply() {
        var oAncestor = $(this).parents()[3];
        oReply = $(oAncestor).find(".replydiv").eq(0);
        if (oReply.get(0).style.display != "block") {//可能为空值
            $(oReply).slideDown(500);
            $(oReply).find("input[name='num']").get(0).value = parseInt($(oAncestor).find(".tail-info.num").get(0).innerText);
            this.innerText = "收起回复";
        }
        else {
            $(oReply).slideUp(500);
            this.innerText = "回复";
        }
    });
$(".replytoreply").click(function () {
    var oAncestor = $(this).parents()[3];
    var oReply = $(oAncestor).find(".replydiv").eq(0);
    var oReplyto = $(this).parents(".singlereply").find("span").eq(0).text();
    if (oReply.get(0).style.display != "block") {//可能为空值
        $(oReply).slideDown(500);
        $(oReply).find("input[name='num']").get(0).value = parseInt($(oAncestor).parent().find(".tail-info.num").get(0).innerText);
        $(oAncestor).prev().find("a.reply").get(0).innerText = "收起回复";
    }
    var oTextarea = oReply.find("textarea").eq(0);
    oTextarea.text("回复" + oReplyto + "：").focus();
});
$(".showallreply").click(
    function () {
        $(this).prevAll(".hidereply").slideToggle(500);
        if (this.innerHTML == "展开全部") this.innerHTML = "收起展开内容";
        else this.innerHTML = "展开全部";
    }
);
var oWordTipDiv = document.getElementById("wordnumtip");
var oWordTipSpan = oWordTipDiv.getElementsByTagName("span")[0];
var oSsubmitMessage = document.getElementsByClassName("submitmessage")[0];
document.getElementById("messagetext").oninput=function () {
    this.style.height=this.scrollHeight<200?'200px':this.scrollHeight+'px';
    var iWordNum = this.value.length;
    if (iWordNum == 0) {
        oWordTipDiv.style.visibility = "hidden";
        oSsubmitMessage.disabled = true;
        return;
    }
    oWordTipSpan.innerText = iWordNum;
    oWordTipDiv.style.visibility = "visible";
    oSsubmitMessage.disabled = false;
};
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
};
oLikeSpan = document.getElementsByClassName("tail-info   like");
for (i = 0; i < oLikeSpan.length; i++) {
    (function f(num) {
        id = parseInt(oLikeSpan[num].parentNode.childNodes[2].innerText);
        if (getCookie("message" + id)) {
            oLikeSpan[num].childNodes[0].style.backgroundPositionY = "bottom";
            oLikeSpan[num].style.color = "rgb(85, 26, 139)";
        }
        oLikeSpan[num].addEventListener("click", function (ev) {
                var oClickLike = this;
                id = parseInt(oLikeSpan[num].parentNode.childNodes[2].innerText);
                var x = ev.pageX, y = ev.pageY, span = document.createElement('span');
                span.textContent = "　　谢谢点赞！";
                if (getCookie("message" + id))
                    span.textContent = "今天您已经点过赞啦";
                else {
                    var oCookieTime = new Date();
                    oCookieTime.setTime((Math.ceil(oCookieTime.valueOf() / (24 * 3600000)) * 24 * 3600000));
                    var expires = oCookieTime.toUTCString();
                    var name = "message" + id;
                    document.cookie = name + "=like;expires=" + expires;
                    oClickLike.style.color = "rgb(85, 26, 139)";
                    likenum = parseInt(oClickLike.childNodes[2].innerText);
                    //  oClickLike.innerHTML="已赞("+oClickLike.childNodes[1].outerHTML+")";
                    //  fnCreateRequest("like.php?id=" + id);
                    $.post("like.php", {"id": id}, function (result) {
                        oClickLike.childNodes[2].innerText = likenum + 1;
                        oClickLike.childNodes[0].style.backgroundPositionY = "bottom";
                        // node.nextSibling.innerHTML++;//=parseInt(this.nextSibling.innerHTML)+1;
                    });
                }
                span.style.cssText = ['z-index: 1; position: absolute; font-weight: bold; color: blue; top: ', y - 20, 'px; left: ', x - 50, 'px;'].join('');
                document.body.appendChild(span);
                animate(span);
                return;
            }
        )
    })(i);
};
//跳转到指定页面
function fnJump() {
    var iJumpPage = document.getElementById("jumpPage").value;
    var iTotalPage = parseInt(document.getElementById("totalpage").innerText);
    var numreg = /\d+/;
    if (iJumpPage > iTotalPage || !numreg.test(iJumpPage)) {
        alert("页码无效，请重新输入！");
        return false;
    }
    else location.href = "messages.php?username=$user_name&page=" + iJumpPage;
};
