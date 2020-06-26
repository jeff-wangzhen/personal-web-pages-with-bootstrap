var oUserName = document.getElementById("username");
var oUserPwd = document.getElementById("userpwd");
var oUserTip = document.getElementById("usertip");
var oPwdTip = document.getElementById("pwdtip");//许多地方在if判断条件中获取值，因为函数每次调用都非获取不可，所以不必存于变量中
if(!navigator.cookieEnabled)alert("为了保证网页正常访问，请启用cookie");
oUserTip.style.visibility="hidden";
oPwdTip.style.visibility="hidden";
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return 0;
};
if(sCookieName=getCookie("username"))oUserName.value=sCookieName;
if(sCookiePassword=getCookie("password"))oUserPwd.value=sCookiePassword;
if(getCookie("autologin")==1 || getCookie("signedin")!=0 )document.getElementById("submit").click();
document.getElementById("noscript").style.display="none";
oUserName.onblur = function fnCheckNameJs() {
    if (oUserName.value == "" || oUserName.value == "用户名") {
        oUserTip.style.visibility="visable";
        return false;
    }
    else {
        oUserTip.style.visibility="hidden";
    }
};

oUserPwd.onblur = function fnCheckPwdJs() {
    if (oUserPwd.value == '' || oUserPwd.value == this.placeholder) {
        oPwdTip.style.visibility="visable";
        return false;
    }
    else {
        oPwdTip.style.visibility="hidden";
    }
};

function fnCheckForm(event) {
    event = event || window.event;
    if (oUserName.value == "" || oUserPwd.value == "") {
        event.preventDefault(); // 兼容标准浏览器
        //window.event.returnValue = false; // 兼容IE6~8
        return false;
    }
};
document.getElementById("signup").addEventListener("click",function () {
    window.location.href="SignUp.php";
});
