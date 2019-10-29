var oUserName = document.getElementById("username");
var oUserTip = document.getElementById("usertip");
var oUserPwd = document.getElementById("userpwd");
var oCheckId = document.getElementById("checkid");
var oPwdTip = document.getElementById("pwdtip");
var oCheckTip = document.getElementById("checktip");
var oSubmit = document.getElementById("Submit");
if(!navigator.cookieEnabled)alert("为了保证网页正常访问，请启用cookie");


document.getElementById("noscript").style.display="none";
document.getElementById("form1").action="CheckUp.php";
oUserPwd.onblur = function () { 
    fnCheckPwd();
    if (document.form1.checkid.value != "") fnCheckId();//如果确认密码不为空，调用确认密码核对函数
};
oCheckId.oninput = function () {
    //确认密码调用函数
    if (this.value.length >= oUserPwd.value.length)
        fnCheckId();
};

function fnCheckForm() {
    console.log(9)
    //判断是否满足提交条件提交
    if (oUserTip.className == "text-success" && oCheckTip.className == "text-success" && oPwdTip.className == "text-success" && submitflag == 0) {
        oSubmit.disabled = true;//防止重复提交
        return true;
    }
    else {
        if (oUserTip.className != "text-success") {
            oUserTip.className= "text-error";
            //document.form1.username.focus();
        }
        else if (oPwdTip.className != "text-success") {
            oPwdTip.className= "text-error";
           // document.form1.userpwd.focus();
        }
        else if (oCheckTip.className != "text-success") {
            oCheckTip.className= "text-error";
           // document.form1.checkid.focus();
        }
        return false;
    }
};
oUserName.onblur = function fnCheckNameJs() {//检查用户名函数
    // var oUserTip = document.getElementById("usertip");
    var sUserName = oUserName.value;
    var uPattern = /^[a-zA-Z][a-zA-Z0-9_-]{5,20}$/;
    if (this.value == '') {
        return false;
    } else if (!uPattern.test(sUserName)) {
        oUserTip.innerText = "请正确填写用户名，必须以字母开头，可以包括数字、下划线、减号，6~20字符";
        oUserTip.className= "text-error";
       // form1.username.focus();
        return false;
    }
    else fnCheckName();
};

function fnCheckName() {//检查用户名
    //   var oUserTip = document.getElementById("usertip");
    var sUserName = oUserName.value;
    createRequest("checkname.php?username='" + sUserName + "'");
};

function fnCheckPwd() {//检查密码
    // var oPwdTip = document.getElementById("pwdtip");
    var sUserPwd = oUserPwd.value;
    var uPattern = /^[a-zA-Z0-9_-]{6,20}$/;
    if (!uPattern.test(sUserPwd)) {
        oPwdTip.innerText = "请正确填写密码，只能包含字母，数字、下划线、减号，6~20字符";
        oPwdTip.className= "text-error";
       // form1.userpwd.focus();
        return false;
    }
    else {
        oPwdTip.innerText = "密码符合要求";
        oPwdTip.className= "text-success";
    }
};

function fnCheckId() {
    var sUserPwd = document.form1.userpwd.value;
    var sCheckId = document.form1.checkid.value;
    oCheckTip.className= "text-error";

    if (sCheckId == "") {
        oCheckTip.innerText = "请再次输入密码！";
       // form1.checkid.focus();
    }
    else if (sUserPwd != sCheckId || sUserPwd == "") {
        oCheckTip.innerText = "确认密码错误，请检查！";
    }
    else if (oPwdTip.className= "text-success") {
        oCheckTip.innerText = "确认密码正确";
        oCheckTip.className= "text-success";
    }
    else {
        oCheckTip.innerText = "请检查密码！";
    }
};
//var oUserTip = document.getElementById("oUserTip");
var http_request = false;

function createRequest(url) {   //初始化对象并发出XMLHttpRequest请求
    http_request = false;
    if (window.XMLHttpRequest) { //Mozilla等其他浏览器
        http_request = new XMLHttpRequest();
        //修复某些版本的火狐浏览器的bug
        if (http_request.overrideMimeType) {
            http_request.overrideMimeType("text/xml");
        }
    } else if (window.ActiveXObject) {     //IE浏览器
        try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
            }
        }
    }
    if (!http_request) {
        alert("不能创建XMLHTTP实例，请截图联系kill370354@qq.com");
        return false;
    }
    http_request.onreadystatechange = alertContents;
    //指定响应方法函数
    http_request.open("GET", url, true);
    //发出HTTP请求,再设置一次true试。
    http_request.send(null);
};

function alertContents() {   	 //处理服务器返回的信息
    //   var oUserTip = document.getElementById("usertip");
    if (http_request.readyState == 4) {
        if (http_request.status == 200) {
            //oUserTip.style.display = "inline";
            if (http_request.responseText == '<p>y</p>') {    //如果服务器传回的内容为y，则表示用户名已经被占用
                oUserTip.innerText = '该用户名已注册' + "\n ";
                oUserTip.className= "text-error";
              //  form1.username.focus();
                return false;
            } else {       //不为y，则表明用户名未被占用
                oUserTip.innerText = '该用户名可用' + "\n ";
                oUserTip.className= "text-success";
            }
        }
    }
};
document.getElementById("signin").addEventListener("click",function () {
    window.location.href="index.php";
});
