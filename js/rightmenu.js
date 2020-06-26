var getOffset = {
    top: function top(obj) {
        return obj.offsetTop + (obj.offsetParent ? top(obj.offsetParent) : 0)
    },
    left: function left(obj) {
        return obj.offsetLeft + (obj.offsetParent ? left(obj.offsetParent) : 0)
    }
};
//window.onload = function () {
var oMenu = document.getElementById("rightMenu");
var aUl = oMenu.getElementsByTagName("ul");
var aLi = oMenu.getElementsByTagName("li");
var showTimer = hideTimer = null;
var i = 0;
var maxWidth = maxHeight = 0;

oMenu.style.display = "none";
aUl[0].onmouseover = function () {
    var oNextUl = this.getElementsByTagName("ul");
    for (i = oNextUl.length - 1; i > -1; i--) {
        oNextUl[i].style.display = "none";
    }
};
for (i = 0; i < aLi.length; i++) {
//为含有子菜单的li加上箭头
    aLi[i].getElementsByTagName("ul")[0] && (aLi[i].className = "sub glyphicon glyphicon-arrow-right");
//鼠标移入
    aLi[i].addEventListener("click", function (ev) {
        var oUl = this.childNodes;
        if (oUl.length == 1) {
            document.onclick();
        }
        else {
            if (ev && ev.stopPropagation) {
                //W3C取消冒泡事件
                ev.stopPropagation();
            } else {
                //IE取消冒泡事件
                window.event.cancelBubble = true;
            }
            return false;
        }
    });
    aLi[i].onmouseover = function (ev) {
        var oThis = this;
        var oUl = oThis.getElementsByTagName("ul");
//鼠标移入样式
        for (j = oThis.childNodes.length - 1; j > -1; j--) {
            if (ev.target == oThis.childNodes[j]) break;
        }
        if (j == -1) oThis.className += " active";
// //显示子菜单
        var oNextUl = oThis.parentNode.getElementsByTagName("ul");
        setTimeout(function () {
            for (i = oNextUl.length - 1; i > -1; i--) {
                if (oNextUl[i] && oNextUl[i].parentNode != oThis && oNextUl[i].style)
                    oNextUl[i].style.display = "none";
            }
        }, 100);
        if (oUl[0]) {
            clearTimeout(hideTimer);
            showTimer = setTimeout(function () {
                // iCascade = 6;
                // if (index = oThis.parentNode.className.indexOf("cascade") > -1) {
                //     iCascade = oThis.parentNode.className.charAt(index + 6);
                //     //  console.log(iCascade);
                //     for (cascadenum = parseInt(iCascade) + 1; cascadenum < 5; cascadenum++) {
                //         ouls = document.getElementsByClassName("cascade" + cascadenum);
                //            // console.log(ouls);
                //         for (j = 0; j < ouls.length; j++) ouls[j].style.display = "none";
                //     }
                // }
                for (ih = 0; ih < oThis.parentNode.children.length; ih++) {
                    oThis.parentNode.children[ih].getElementsByTagName("ul")[0] &&
                    (oThis.parentNode.children[ih].getElementsByTagName("ul")[0].style.display = "none");
                }
                $(oUl[0]).fadeIn(350);//oUl[0].style.display = "block";
                oUl[0].style.top = oThis.offsetTop + "px";
                oUl[0].style.left = oThis.offsetWidth + "px";
                //    setWidth(oUl[0]);
//最大显示范围
                maxWidth = aDoc[0] - oUl[0].offsetWidth;
                maxHeight = aDoc[1] - oUl[0].offsetHeight;
//防止溢出
                maxWidth < getOffset.left(oUl[0]) && (oUl[0].style.left = -oUl[0].clientWidth + "px");
                maxHeight < getOffset.top(oUl[0]) && (oUl[0].style.top = -oUl[0].clientHeight + oThis.offsetTop + oThis.clientHeight + "px")
            }, 100);
        }
        if (ev && ev.stopPropagation) {
            //W3C取消冒泡事件
            ev.stopPropagation();
        } else {
            //IE取消冒泡事件
            window.event.cancelBubble = true;
        }
        return false;
    };
//鼠标移出
    aLi[i].onmouseout = function () {
        var oThis = this;
        var oUl = oThis.getElementsByTagName("ul");
//鼠标移出样式
        oThis.className = oThis.className.replace(/\s?active/, "");
        clearTimeout(showTimer);
        hideTimer = setTimeout(function () {
        }, 10);
    };
}
// //自定义右键菜单
document.oncontextmenu = function (event) {
    aDoc = [window.innerWidth, window.innerHeight];
    oMenu.style.display = "none";
    for (i = 1; i < aUl.length; i++) {
        aUl[i].style.display = "none";
    }
    ;
    $(oMenu).fadeIn(350);
    // $(aUl[0]).fadeIn(350);
    aUl[0].style.display = "block";
    oMenu.style.display = "block";

    for (i = 0; i < aUl.length; i++) {
        aUl[i].onmousenter = function (ev) {
            //    this.style.display = "block";
            //  console.log(ev.offsetX)
            //  $(this).fadeIn(350);
        }
    }
    var event = event || window.event;
    oMenu.style.left = event.clientX + "px";
    oMenu.style.top = event.clientY + "px";
//最大显示范围
    maxWidth = aDoc[0] - oMenu.offsetWidth;
    maxHeight = aDoc[1] - oMenu.offsetHeight;
//防止菜单溢出
    oMenu.offsetTop > maxHeight && (oMenu.style.top = maxHeight + "px");
    oMenu.offsetLeft > maxWidth && (oMenu.style.left = maxWidth + "px");
    return false;
};
//点击隐藏菜单
document.onclick = function (ev) {
    if (ev && ev.button == 1)
        $(oMenu).fadeOut(350);
    oMenu.style.display = "none";
    // console.log(oTextarea== document.activeElement);
};
window.onscroll = function (ev) {
    if (oMenu.style.display == "block")
        oMenu.style.display = "none";
};

function fnMenuTip(content, ev) {
    var x = ev.pageX, y = ev.pageY, span = document.createElement('span');
    span.textContent = content;
    span.style.cssText = ['z-index: 1; position: absolute; font-weight: bold; color: #000; top: ', y - 20, 'px; left: ', x, 'px;'].join('');
    document.body.appendChild(span);
    animate(span);
    if (ev && ev.stopPropagation) {
        //W3C取消冒泡事件
        ev.stopPropagation();
    } else {
        //IE取消冒泡事件
        window.event.cancelBubble = true;
    }
    for (i = 0; i < aUl.length; i++) {
        aUl[i].style.display = "none";
    }
    return false;
}

var oToleave = document.getElementsByClassName("toleavemessage");
for (i = 0; i < oToleave.length; i++) {
    oToleave[i].addEventListener("click", function (ev) {
        // document.getElementById('leavemessage').focus();
        //window.location.hash = "leavemessage";
        if (oMessageText = document.getElementById('messagetext')){

            oMessageText.focus();}
else window.location = "Messages.php";
        return true;
    })
}
document.getElementById("noaction").addEventListener("click", function (ev) {
    fnMenuTip("请自便", ev);
})
document.getElementById("tosendbarrage").addEventListener("click", function (ev) {
    fnMenuTip("请在首页点击窗口底部", ev);
})
document.getElementById("notell").addEventListener("click", function (ev) {
    fnMenuTip("那好吧", ev);
})
document.getElementById("returnmenu").addEventListener("click", function (ev) {
    fnMenuTip("对不起！", ev);
    document.oncontextmenu = function () {
        return true;
    };
});
