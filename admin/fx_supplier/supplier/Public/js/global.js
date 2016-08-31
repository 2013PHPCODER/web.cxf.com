function plusArray(arr){
  var q=0;
  for (var i = 0; i < arr.length; i++) {
    q+=arr[i];
  };
  return q;
}
function pager(total, per){  /*n为页码值，p为页码名,将页码参数放在所有参数之后.用？传参*/ 
  var per=per || 20;            //默认20条一页
    kkpager.generPageHtml({
        pno:getPage(),
        total:Math.ceil(total/per),
        totalRecords:total,
        getLink : function(n){return getHref(n);}
    });
  function getPage(){return $_GET['p']} 
}
function getHref(pageValue){    //获得超链接地址
  if ( ($_GET['p'] && count($_GET)==1) || count($_GET)==0) {
    var q=window.location.href.split('?p=',2);
    return q[0]+'?p='+pageValue;  
  };
  if (count($_GET)>=1) {
    var q=window.location.href.split('&p=',2);
    return q[0]+'&p='+pageValue;      
  };    
}
/*获取get参数*/
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})(); 
function count(o){  //获得关联数组或对象的长度
    var t = typeof o;
    if(t == 'string'){
        return o.length;
    }else if(t == 'object'){
        var n = 0;
        for(var i in o){
                n++;
        }
        return n;
    }
    return false;
}