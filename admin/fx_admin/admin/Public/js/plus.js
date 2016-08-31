/*

** by XuJing(2016/6/13) **

*/

(function(factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as anonymous module.
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals.
    factory(jQuery);
  }
}(function($) {

// Only continue if we're on IE8/IE9 with jQuery 1.5+ (contains the ajaxTransport function)
if ($.support.cors || !$.ajaxTransport || !window.XDomainRequest) {
  return $;
}

var httpRegEx = /^(https?:)?\/\//i;
var getOrPostRegEx = /^get|post$/i;
var sameSchemeRegEx = new RegExp('^(\/\/|' + location.protocol + ')', 'i');

// ajaxTransport exists in jQuery 1.5+
$.ajaxTransport('* text html xml json', function(options, userOptions, jqXHR) {

  // Only continue if the request is: asynchronous, uses GET or POST method, has HTTP or HTTPS protocol, and has the same scheme as the calling page
  if (!options.crossDomain || !options.async || !getOrPostRegEx.test(options.type) || !httpRegEx.test(options.url) || !sameSchemeRegEx.test(options.url)) {
    return;
  }

  var xdr = null;

  return {
    send: function(headers, complete) {
      var postData = '';
      var userType = (userOptions.dataType || '').toLowerCase();

      xdr = new XDomainRequest();
      if (/^\d+$/.test(userOptions.timeout)) {
        xdr.timeout = userOptions.timeout;
      }

      xdr.ontimeout = function() {
        complete(500, 'timeout');
      };

      xdr.onload = function() {
        var allResponseHeaders = 'Content-Length: ' + xdr.responseText.length + '\r\nContent-Type: ' + xdr.contentType;
        var status = {
          code: 200,
          message: 'success'
        };
        var responses = {
          text: xdr.responseText
        };
        try {
          if (userType === 'html' || /text\/html/i.test(xdr.contentType)) {
            responses.html = xdr.responseText;
          } else if (userType === 'json' || (userType !== 'text' && /\/json/i.test(xdr.contentType))) {
            try {
              responses.json = $.parseJSON(xdr.responseText);
            } catch(e) {
              status.code = 500;
              status.message = 'parseerror';
              //throw 'Invalid JSON: ' + xdr.responseText;
            }
          } else if (userType === 'xml' || (userType !== 'text' && /\/xml/i.test(xdr.contentType))) {
            var doc = new ActiveXObject('Microsoft.XMLDOM');
            doc.async = false;
            try {
              doc.loadXML(xdr.responseText);
            } catch(e) {
              doc = undefined;
            }
            if (!doc || !doc.documentElement || doc.getElementsByTagName('parsererror').length) {
              status.code = 500;
              status.message = 'parseerror';
              throw 'Invalid XML: ' + xdr.responseText;
            }
            responses.xml = doc;
          }
        } catch(parseMessage) {
          throw parseMessage;
        } finally {
          complete(status.code, status.message, responses, allResponseHeaders);
        }
      };

      // set an empty handler for 'onprogress' so requests don't get aborted
      xdr.onprogress = function(){};
      xdr.onerror = function() {
        complete(500, 'error', {
          text: xdr.responseText
        });
      };

      if (userOptions.data) {
        postData = ($.type(userOptions.data) === 'string') ? userOptions.data : $.param(userOptions.data);
      }
      xdr.open(options.type, options.url);
      xdr.send(postData);
    },
    abort: function() {
      if (xdr) {
        xdr.abort();
      }
    }
  };
});

return $;

}));

$.ajaxSetup({cache:false});
$(function(){
   $.ajaxSetup({cache:false});
})


var baseUrl='http://api.mycxf.org';
var requestUrl = {
	'indexAd':baseUrl+'/index',                      //首页广告栏接口
	'indexc':baseUrl+'/category',                 //首页菜单，商品接口
	'admAdviert_l':baseUrl+'/admin/adviert_list',    //后台首页广告管理 
	'admAdd_active':baseUrl+'/admin/add_active',           //后台首页广告管理添加活动专题
	'admAdd_viert':baseUrl+'/admin/add_viert',       //后台首页广告管理添加广告 
	'adviert_type':baseUrl+'/admin/adviert_type'                  //获取广告位，广告类型	
}

var X = {
	Name:'Xplus',
	// 数据绑定方法，传入接口地址，外层id，第三个参数可选：数据是字符型json数组时，不传值，当是json型数据时须传入定位到绑定对象前一级如“body.ch”中间以.号隔开，如无父级传入空 '';
	// 该方法可遍历可单绑    可混用可单用；
	bindModel:function(url,data,pos,arr,callback){   
		var self = {};
		if(typeof pos =="function"){
			self.callback = pos;
			pos = undefined;
		}
		if(callback){
			self.callback = callback;
		}		
		if(data != ''){
			self.data = data;
		}else{
			self.data = {"Time_stamp":new Date().getTime()};
		}
		$.post(url,self.data,function(data){  
			var x;
			if (pos != undefined)
		    {
		        self.pos = pos.split('.'); 
		        x = data;
		        if(self.pos != ''){
			         for( i in self.pos){
			        	x = x[self.pos[i]];
			        }
		        }
		        self = $.extend(self,x);
		    }else{
//		        x = eval("("+data+")");
		        $.each(x, function (i, x){ 
	        		self.list.push(x);
		        });
		    }	
		    //console.log(self);
		    for(var i in arr){
		    	ko.applyBindings(self, document.getElementById(arr[i])); 
		    }  	   	      	
   	   	    if(self.callback){self.callback()}
   	   })	
      return self; 	      	
	},
	addManage:function(url,data,callback){
		var data = $.extend(data,{"Time_stamp":new Date().getTime()});
		$.post(url,data,function(data){
			callback(data);
		})
	},
	// 翻页数据绑定方法，传入接口地址，外层id，每行条数，第四个参数可选：数据是必须是字符型json数组，传入定位到绑定对象如“body.ch.list”中间以.号隔开，如无父级则不传;
	turnPage:function(url,id,n,data,pos){
		var n = n;
		if (pos != undefined){
		    var selfPos = pos;
		}
		if(data != ''){
			var time = data;
		}else{
			var time = {"Time_stamp":new Date().getTime()};
		}
		$.post(url,time,function(data)
		{	
			var x = data;
			//console.log(x);
			if (selfPos != undefined){
			    var pos = selfPos.split('.');;
			    for( i in pos){
		        	x = x[pos[i]];
			    }
		  }
//			x = eval("("+x+")");
            if (pos != undefined){
               X.paging(x,url,n,time,id,selfPos);
            }else{
               X.paging(x,url,n,id,time); 
            }          
   	    })
	},
	paging:function paginationViewModel(data,url,n,time,id,pos) {   //分页
	    var self = {};
	    self.rechargeInfo = null;
	    self.list = null;
	    self.bindTure = true;
	    self.time = time;
	    if (pos != undefined){
		    self.pos = pos;
		    self.pos = self.pos.split('.'); 
	    }
	    if (data != undefined)
	    {
	//		if(data.user.list.userShow[0].Point == ".00")
	//		{
	//			data.body.list.userShow[0].Point = "0";
	//		}
	//      self.rechargeInfo = data.body.list.userShow;
	        self.list = ko.observableArray(data);
	    }else
	    {
	        self.list = ko.observableArray(undefined);
	    }
	    self.url = url;
	    self.row = data.length;
	    //每页显示多少个标签(多少页码)
	    self.pageshow = n;
	    //总共多少页
	    self.totalpage =  Math.ceil(self.row/self.pageshow)
	    //当前页
	    self.currentpage = ko.observable(1);
	    self.page = ko.observableArray([]);
	
	    self.setpagetr = function (pageNum) {
	        //加入页码
	        self.obj = new Array();
	        var startNum = 1;
	        var endNum = self.totalpage > 7 ? 7 : self.totalpage;
	        //var trsize = self.totalpage;
	        if (pageNum > 3 && self.totalpage > 7) {
	            if (pageNum + 3 > self.totalpage) {
	                startNum = self.totalpage - 6;
	                endNum = self.totalpage;
	            } else {
	                startNum = pageNum - 3;
	                endNum = pageNum + 3;
	            }
	        }
	        for (var j = startNum; j <= endNum; j++) {
	            self.obj.push(j);
	        }
	        self.currentpage(pageNum);
	        self.page.removeAll();
	        $.each(self.obj, function (i, x) {
	            self.page.push(x);
	        })
	    }
	
	    self.Result = function () {
	        var sendObj = new Object();
	        sendObj.action = "select";
	        sendObj.currentPage = self.currentpage();
	        $.post(self.url,self.time,function(data){
	        	var x = data;;
	        	self.list.removeAll();
	        	if (self.pos != undefined){			        
			        for( i in self.pos){
			        	x = x[self.pos[i]];
			        }
			    }
//	   	   	    x = eval("("+x+")");	
	//          var oo = JSON.parse(x);
	            $.each(x, function (i, x) {
	            	if((self.currentpage()-1)*self.pageshow <=i && i< self.currentpage()*self.pageshow ){   //新添加
	            		 self.list.push(x);
	            	}               	
	            });
	            if(self.bindTure){
	            	 ko.applyBindings(self,document.getElementById(id));
	            	 self.bindTure = false;            	 
	            }          
	        });
	    }
	
	    //下一页
	    self.next = function () {
	        if (self.currentpage() < self.totalpage) {
	            self.setpagetr(self.currentpage() + 1);
	            self.Result();
	        }
	
	    }
	    //上一页
	    self.pre = function () {
	        var cur = self.currentpage();
	        if (cur > 1) {
	            self.setpagetr(cur - 1);
	            self.Result();
	        }
	    }
	
	    //跨页码翻页(下一页)
	    self.goNext = function () {
	        if (self.currentpage() + self.pageshow > self.totalpage) {
	            self.setpagetr(self.totalpage);
	        } else {
	            self.setpagetr(self.currentpage() + self.pageshow);
	        }
	        self.Result();
	    }
	
	    //跨页码翻页(上一页)
	    self.goPre = function () {
	        if (self.currentpage() - self.pageshow > 1) {
	            self.setpagetr(self.currentpage() - self.pageshow);
	        } else {
	            self.setpagetr(1);
	        }
	        self.Result();
	    }
	
	    //首页
	    self.first = function () {
	        self.setpagetr(1);
	        self.Result();
	    }
	
	    //末页
	
	    self.last = function () {
	        self.setpagetr(self.totalpage);
	        self.Result();
	    }
	
	    //跳转页面
	    self.jumpPage = function () {
	        var jumpNum = Number($("#pageNum").val());
	        if (jumpNum != null && jumpNum != "" && jumpNum > 0 && jumpNum <= self.totalpage && /^[1-9]*[1-9][0-9]*$/.test(jumpNum)) {
	            self.setpagetr(jumpNum);
	            $("#pageNum").focus();
	        } else {
	            $("#pageNum").val("").focus();
	        }
	        self.Result();
	    }
	
	    self.Search = function (obj) {
	        object.pageIndex = self.currentpage();
	        $.post(self.url,obj, function (x) {
	            self.list.removeAll();
//	            var oo = JSON.parse(x);
	            $.each(oo, function (i, x) {
	                self.list.push(x);
	            });
	        });
	    }
	
	    self.current = function (currentPage) {
	        self.setpagetr(currentPage);
	        self.Result();
	    }
	    self.setpagetr(1);
	    self.Result(self.currentpage());
	    return self;
	},
    mod:{                  //自定义模块
    	
    },
    setMod:function(packageName){
    	if(packageName){					
			eval(packageName+"={}");								
		}		
    },
    //1,轮播传入父级名称，2,轮播间隔时间，3,轮播方式：传入opacity即淡入淡出效果  转动效果则传入空如'' 4,及是否返回再次调用
    lbChange:function(name,time,way,swt){   
    	var my = {};
    	my.num = 0;
    	my.way = way;
    	my.n = $('.'+name+'Ui>li').length;
    	my.time = time+'000';
    	    
		$('.'+name+'C>li').hover(function(){
			clearInterval(my.timer);
			var numO = $(this).index();
			my.lbChangeTo(numO);
		},function(){
			my.setTimer();
		});
		$('.'+name+'_l').on('click',function(){
			var numO = my.num-1;
			if(numO<=-1){
				numO=2
			}
			my.lbChangeTo(numO);
		});
		$('.'+name+'_r').on('click',function(){
			var numO = my.num+1;
			if(numO>=my.n){
				numO=0
			}
			my.lbChangeTo(numO);
		});
		$('.'+name).hover(function(){
			clearInterval(my.timer);
		},function(){
			my.setTimer();
		})
		my.lbChangeTo = function(numO){
	    	if(my.num==numO){
				return;
			}else{
				if(my.way == 'opacity'){
					$('.'+name+'Ui>li').eq(my.num).stop().animate({'opacity':0},500)
					my.num=numO;
					$('.'+name+'Ui>li').eq(my.num).stop().animate({'opacity':1},500)
					$('.'+name+'C>li').eq(my.num).addClass('hover').siblings().removeClass('hover');  // 淡入淡出效果
				}else{					
	                $('.'+name+'Ui').stop().animate({'left': -numO+'00%'},500);
	                $('.'+name+'C>li').eq(numO).addClass('hover').siblings().removeClass('hover');
	                my.num=numO;
				}		               
			}
	    };
	    my.setTimer = function(){
			my.timer = setInterval(function(){
				var numO = my.num+1;
				if(numO>=my.n)
					numO=0;			
				my.lbChangeTo(numO);
		    },my.time)
		};
		my.setTimer();	
		if(swt){return my}
    },
    search:function(){
		$("#search").keyup(function(){
			$.ajax({
				type:"get",
				url:"",
				async:true,
				data:"txt_search="+escape($("#search").val()),
				success:function(data){
					if(data!=""){
						var ss;
						ss=data.split("@");
						var layer;
						layer="<table>";
						for (var i=0;i<ss.length-1;i++) {
							layer+="<tr><td class='line'>"+ss[i]+"</td></tr>";
						}
						layer+="</table>";
						$("#searchresult").empty();
						$("#searchresult").append(layer);
						$(".line").hover(function(){
							$(this).addClass("hover");
						},function(){
							$(this).removeClass("hover");
						});
						$(".line").click(function(){
							$("#search").val($(this).text());
						});
					}else{
						$("#searchresult").empty();
					}
				},
				error:function(){
					alert("对不起，获取数据失败！");
				}
			});
		})
		$("#search").click(function(){
			$("#searchresult").empty();
		})
	},
    notice:function(mes,time){  	
    	var div = document.createElement("div");
    	div.innerHTML = mes;
    	var times = time+'000';
    	div.style.cssText+='position:fixed;z-index: 9999; top: 20%;left: 50%;opacity:0;filter: alpha(opacity:0);padding: 20px 25px;border:2px solid #fb2653; border-radius: 5px;background: #fff; color: #fb2653;font-size: 20px';
    	document.body.appendChild(div);
    	div.style.cssText+='margin-left: -'+$(div).width()*0.5+'px';
    	$(div).stop().animate({'opacity':1,'filter': 'alpha(opacity:1)'},600)	    
		setTimeout(function(){
    		 $(div).fadeOut(600);
    		 setTimeout(function(){
    		 	 document.body.removeChild(div);
    		 },600);
    	},times)
    },
    // 弹出框 
    alert:function(){
        if(!document.getElementById('tank')){
            switch (arguments.length){
                case 1:
                    new X.alertBox(arguments[0]).show();
                    break;
                case 2:
                    new X.alertBox(arguments[0],arguments[1]).show();
                    break;
            }
        }
    },
    alertBox:function(){
        var me={
        	fnShow:function (){
	            this.div1.style.cssText+="width:300px;height:300px;position:absolute;left:50%;opacity:0;filter: alpha(opacity:0);margin-left:-150px;top:50%;margin-top:-150px;background:#fff;z-index:9999;";
	            $(this.div1).stop().animate({'opacity':'1','filter': 'alpha(opacity:100)'},600)
	        },
	        fnHide:function(){
                $(this.div1).stop().animate({'opacity':'0','filter': 'alpha(opacity:0)'},600);
                $(this.div2).stop().animate({'opacity':'0','filter': 'alpha(opacity:0)'},600)
	        },
	        canCel:function(){
	        	this.fnHide();
                setTimeout(function(){
                    document.body.removeChild(me.div1);
                    document.body.removeChild(me.div2);
                },600);
	        }
        };
        me.callback=arguments[1];
        me.id="tank";
//      me.btnId = ;
        me.content=arguments[0];
        me.show = function (){
            if(!me.div1){
                me.div1 = document.createElement("div");
                me.div2 = document.createElement("div");
                me.div2.style.cssText+='position:fixed;top: 0;left: 0;width:100%;height:100%;z-index:99;opacity:.5;background: #000;filter: alpha(opacity:50)';
                me.div1.setAttribute('id',me.id);
                document.body.appendChild(me.div1);
                document.body.appendChild(me.div2);
                me.div1.innerHTML = '<h4 style="text-align:left;margin-top:25px;">'+'提示'+'</h4>'
                        +'<p id="tCancel" style="position: absolute;top: 0;right: 0;font-size: 24px;cursor: pointer;width: 30px;height: 30px;">&Chi;</p>'
                        +'<p style="font-weight: bold;text-align: center;margin-top: 120px;">'+this.content+'</p>'
                        +'<div style="margin-right: 20px;text-align: right;margin-top: 65px;">'
                        +'<input id="tConfirm" type="button" value="确定" style="cursor: pointer;"/>'+'</div>';
                me.oBtn = document.getElementById('tConfirm');
                me.oCancel = document.getElementById('tCancel');
            }
            me.fnShow();
            me.oCancel.onclick=function(){
            	me.canCel();
            }
            me.oBtn.onclick=function(){
                me.canCel();
                me.callback();
            };
        };
        return me;
    },
     sendMess:function(callback){
     	   if($('.tank').size()<=0){
     	     	$('head').append('<link class="tank" href="/shop/templates/default/css_new/tank.css" rel="stylesheet" type="text/css"/>')
     	   }	   
	       var oT = document.createElement('div');
	       $(oT).addClass('Modal');
	       var html =     '<div class="modal-content">'
			        + '<label><input type="" name="mobile" class="code" id="" placeholder="请输入要获取验证码的手机号" value="" /><a href="javascript:void(0);" id="send_auth_code" class="ncm-btn ml5">获取短信验证码</a><span class="send_success_tips"><strong id="show_times" class="red mr5">60</strong>秒后再次发送</span></a></label>'
			      +  '<label><input type="" name="mobile" class="codeMobile" id="" placeholder="输入获取的验证码" value="" /></label>'
					+  '<label><div class="sub-btn"><input type="submit" class="sumb" value="提交"/></div></label>'
					+  '</div>'
					+ '<span class="close">×</span>'
					$(oT).append(html);	
					if($('.Modal').size()<=0){
					  $('body').append(oT); 
					}
					$('.close').click(function(){
						document.body.removeChild(oT);
					})
					$('.Modal').delegate('#send_auth_code','click',function(){
						 var oThis = $(this);
						 var datar = {
							"mobile":$('input[name="mobile"]').val()
						 }
						 if(datar.mobile.length==11 && datar.mobile.match(/^1[3-9][0-9]+$/)){
	//				 $.post('<?php echo SHOP_SITE_URL?>/shop/index.php?act=bindmobile&op=sendsms',datar,function(data){
					 	   	oThis.hide();
								$('.send_success_tips').show();
								var n = 59;
								var timer=setInterval(function(){
									if(n>=0){
										$('.mr5').html(n);
										n--;
									}else{			
										$('#send_auth_code').show();
										$('.send_success_tips').hide();
										clearInterval(timer);
									}
							  },1000);	
//							if(data.status == 'fail'){
//								 X.notice(data.msg,3);
//							}	
	//			     })
              }else{
              	X.notice('手机号格式有误',3)
              }
			    }); 
			    $('.Modal').delegate('.sumb','click',function(){
			    	  callback();
			    });
		},  
    //图片展示放大镜效果，依次传入下列数组值
    magnifyImg:function(arr){           
    	var objDemo = $(arr[0])[0],     //小图定位外层
	        objSmallBox = $(arr[1])[0], //小图层
	        objMark = $(arr[2])[0],     //小图
	        objFloatBox = $(arr[3])[0], //小图层浮动选区块
	        objBigBox = $(arr[4])[0],   //大图层
	        objBigBoxImage = objBigBox.getElementsByTagName("img")[0];  //大图层图片

        objMark.onmouseover = function () {
            objFloatBox.style.display = "block"
            objBigBox.style.display = "block"
        }

        objMark.onmouseout = function () {
            objFloatBox.style.display = "none"
            objBigBox.style.display = "none"
        }

        objMark.onmousemove = function (ev) {

            var _event = ev || window.event;  //兼容多个浏览器的event参数模式

            var left = _event.clientX -objDemo.offsetLeft - objSmallBox.offsetLeft - objFloatBox.offsetWidth / 2;
            var top = _event.clientY -objDemo.offsetTop - objSmallBox.offsetTop - objFloatBox.offsetHeight / 2;

            if (left < 0) {
                left = 0;
            } else if (left > (objMark.offsetWidth - objFloatBox.offsetWidth)) {
                left = objMark.offsetWidth - objFloatBox.offsetWidth;
            }

            if (top < 0) {
                top = 0;
            } else if (top > (objMark.offsetHeight - objFloatBox.offsetHeight)) {
                top = objMark.offsetHeight - objFloatBox.offsetHeight;
            }

            objFloatBox.style.left = left + "px";   //oSmall.offsetLeft的值是相对什么而言
            objFloatBox.style.top = top + "px";

            var percentX = left / (objMark.offsetWidth - objFloatBox.offsetWidth);
            var percentY = top / (objMark.offsetHeight - objFloatBox.offsetHeight);

            objBigBoxImage.style.left = -percentX * (objBigBoxImage.offsetWidth - objBigBox.offsetWidth) + "px";
            objBigBoxImage.style.top = -percentY * (objBigBoxImage.offsetHeight - objBigBox.offsetHeight) + "px";
        }
    },
    //手风琴效果
//  accordion:function(name){
//  	$(name).hover(function(){
//			$(this).siblings().stop().animate({'width':'148px'},600);
//			$(this).stop().animate({'width':'472px'},600);
//			$(this).siblings().children('dl').stop().animate({'left':0},400);
//			$(this).children('dl').stop().animate({'left':'-148px'},400);
//		},function(){
//			var num = $(name).size()/3;
//			for(var i = 0;i<num;i++){
//				$(name).eq(i*3-2).siblings().stop().animate({'width':'148px'},600);
//				$(name).eq(i*3-2).stop().animate({'width':'472px'},600);
//				$(name).eq(i*3-2).siblings().children('dl').stop().animate({'left':0},400);
//				$(name).eq(i*3-2).children('dl').stop().animate({'left':'-148px'},400);
//			}
//		})
//  },
    //模块导入函数
    require:function(name){    
    	if(name.substring(0,1)=='.'){name = this.Name+name;}
    	var src = name.replace(/\./g,'/')+'.js';  
    	this.writeScript(src);
    },
    writeScript:function(src){     //模块写入函数
    	document.write('<script type="text/javascript" src="' +src + '"></' + 'script>');
    },
    toSerchVaild:function(obj){
				var val = [];
				var q = $(obj).find('select');
				for(var i=0;i<q.size();i++){
					 if(q.eq(i).find('option:selected').index() != 0){
					 	  return true;
					 }
				}
				$(obj).find('input[type="text"]').each(function(){
					 val.push($(this).val());
				})
				for(var i in val){
					if(val[i] != ''){		
						return true
					}
				}
				X.notice('请输入搜索内容',3)
				return false
		}
}





