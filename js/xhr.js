function ajax(options) {
    "use strict";
    //将对象转为字符串
    var str = changeDataType(options.data);
    var xmlHttpRequest;
    var timer;
    //兼容ie 1、创建一个异步对象
    if (window.XMLHttpRequest) {
        xmlHttpRequest = new XMLHttpRequest();
    } else {//IE5和6
        xmlHttpRequest = new ActiveXObject('Microsoft.XMLHTTP');
    }
    if (options.type.toLowerCase() === 'post') {
        xmlHttpRequest.open(options.type, options.url, true);
        // xmlHttpRequest.setRequestHeader('Content-type', 'application/json;charsetset=UTF-8');
        xmlHttpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlHttpRequest.send(str);
    } else {
        xmlHttpRequest.open(options.type, options.url + "?" + str, true);
        xmlHttpRequest.send(null);
    }
    //IE缓存 4、监听状态变化
    xmlHttpRequest.onreadystatechange = function () {
        //判断服务器处理
        if (xmlHttpRequest.readyState === 4) {
            clearInterval(timer);
            if (xmlHttpRequest.status >= 200 && xmlHttpRequest.status < 300 || xmlHttpRequest.status === 304) {
                // console.log('请求成功');
                //访问服务器
                // console.log(xmlHttpRequest.responseText);
                options.success(xmlHttpRequest.responseText);
            } else {
                // console.log('请求失败');
                options.error(xmlHttpRequest.status);
            }
        }
    };
    //判断是否超时
    if (options.timeout) {
        timer = setInterval(function () {
            alert('网络请求超时');
            xmlHttpRequest.abort();
            clearInterval(timer);
        }, options.timeout);
    }
}

var nextStr = '';

function changeDataType(obj) {
    "use strict";
    var str = '';
    if (typeof obj == 'object') {
        for (var i in obj) {
            if (typeof obj[i] != 'function' && typeof obj[i] != 'object') {
                str += i + '=' + obj[i] + '&';
            } else if (typeof obj[i] == 'object') {
                nextStr = '';
                str += changeSonType(i, obj[i])
            }
        }
    }
    return str.replace(/&$/g, '');
}

function changeSonType(objName, objValue) {
    "use strict";
    if (typeof objValue == 'object') {
        for (var i in objValue) {
            if (typeof objValue[i] != 'object') {
                var value = objName + '[' + i + ']=' + objValue[i];
                nextStr += encodeURI(value) + '&';
            } else {
                changeSonType(objName + '[' + i + ']', objValue[i]);
            }
        }
    }
    return nextStr;
}