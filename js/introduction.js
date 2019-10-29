var date1 = '1997/09/12 00:00:00';  //开始时间
var date2 = new Date();    //结束时间
var date3 = date2.getTime() - new Date(date1).getTime();   //时间差的毫秒数
var days = Math.floor(date3 / (24 * 3600 * 1000));
document.getElementById("lifedays").innerHTML = days;