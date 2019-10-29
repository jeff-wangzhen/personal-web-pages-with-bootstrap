"use strict";
(function () {
    var  xhrScript=document.createElement("script");
    xhrScript.setAttribute("src","/js/xhr.js");
    document.getElementsByTagName('body')[0].appendChild(xhrScript);
    xhrScript.onload=function () {
    var  getCookie=function(cname) {
        var name = cname + "=";var i,c;
        var ca = document.cookie.split(';');
        for ( i = 0; i < ca.length; i++) {
             c = ca[i].trim();
            if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
        }
        return 0;
    };
    var setCookie=function(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    };
    if (getCookie("statistics")) return;
    if (navigator.userAgent.indexOf("kill370354mixed") === -1 ) {
        setCookie("statistics",1,0.5);//存储数据
        ajax({url:"https://a.yangy97.top/php/getViewerInfo.php",
            type:"post",
            data:{
                "url":window.location.href
            },success:function (data) {
                 console.log("欢迎访问！");
            }
        });
    }
};
})();
