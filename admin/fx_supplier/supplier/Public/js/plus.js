/*
 
 ** by XuJing(2016/6/13) **
 
 */

(function (factory) {
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
}(function ($) {

// Only continue if we're on IE8/IE9 with jQuery 1.5+ (contains the ajaxTransport function)
    if ($.support.cors || !$.ajaxTransport || !window.XDomainRequest) {
        return $;
    }

    var httpRegEx = /^(https?:)?\/\//i;
    var getOrPostRegEx = /^get|post$/i;
    var sameSchemeRegEx = new RegExp('^(\/\/|' + location.protocol + ')', 'i');

// ajaxTransport exists in jQuery 1.5+
    $.ajaxTransport('* text html xml json', function (options, userOptions, jqXHR) {

        // Only continue if the request is: asynchronous, uses GET or POST method, has HTTP or HTTPS protocol, and has the same scheme as the calling page
        if (!options.crossDomain || !options.async || !getOrPostRegEx.test(options.type) || !httpRegEx.test(options.url) || !sameSchemeRegEx.test(options.url)) {
            return;
        }

        var xdr = null;

        return {
            send: function (headers, complete) {
                var postData = '';
                var userType = (userOptions.dataType || '').toLowerCase();

                xdr = new XDomainRequest();
                if (/^\d+$/.test(userOptions.timeout)) {
                    xdr.timeout = userOptions.timeout;
                }

                xdr.ontimeout = function () {
                    complete(500, 'timeout');
                };

                xdr.onload = function () {
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
                            } catch (e) {
                                status.code = 500;
                                status.message = 'parseerror';
                                //throw 'Invalid JSON: ' + xdr.responseText;
                            }
                        } else if (userType === 'xml' || (userType !== 'text' && /\/xml/i.test(xdr.contentType))) {
                            var doc = new ActiveXObject('Microsoft.XMLDOM');
                            doc.async = false;
                            try {
                                doc.loadXML(xdr.responseText);
                            } catch (e) {
                                doc = undefined;
                            }
                            if (!doc || !doc.documentElement || doc.getElementsByTagName('parsererror').length) {
                                status.code = 500;
                                status.message = 'parseerror';
                                throw 'Invalid XML: ' + xdr.responseText;
                            }
                            responses.xml = doc;
                        }
                    } catch (parseMessage) {
                        throw parseMessage;
                    } finally {
                        complete(status.code, status.message, responses, allResponseHeaders);
                    }
                };

                // set an empty handler for 'onprogress' so requests don't get aborted
                xdr.onprogress = function () {
                };
                xdr.onerror = function () {
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
            abort: function () {
                if (xdr) {
                    xdr.abort();
                }
            }
        };
    });

    return $;

}));



/* 
 * drag 1.0
 * create by tony@jentian.com
 * date 2015-08-18
 * 拖动滑块
 */
var dragyz = false;   //拖动滑块验证

(function ($) {
    $.fn.drag = function (options) {
        var x, drag = this, isMove = false, defaults = {
        };
        var options = $.extend(defaults, options);
        //添加背景，文字，滑块
        var html = '<div class="drag_bg"></div>' +
                '<div class="drag_text" onselectstart="return false;" unselectable="on">拖动滑块验证</div>' +
                '<div class="handler handler_bg"></div>';
        this.append(html);

        var handler = drag.find('.handler');
        var drag_bg = drag.find('.drag_bg');
        var text = drag.find('.drag_text');
        var maxWidth = drag.width() - handler.width();  //能滑动的最大间距

        //鼠标按下时候的x轴的位置
        handler.mousedown(function (e) {
            isMove = true;
            x = e.pageX - parseInt(handler.css('left'), 10);
        });

        //鼠标指针在上下文移动时，移动距离大于0小于最大间距，滑块x轴位置等于鼠标移动距离
        $(document).mousemove(function (e) {
            var _x = e.pageX - x;
            if (isMove) {
                if (_x > 0 && _x <= maxWidth) {
                    handler.css({'left': _x});
                    drag_bg.css({'width': _x});
                } else if (_x > maxWidth) {  //鼠标指针移动距离达到最大时清空事件
                    dragOk();
                }
            }
        }).mouseup(function (e) {
            isMove = false;
            var _x = e.pageX - x;
            if (_x < maxWidth) { //鼠标松开时，如果没有达到最大距离位置，滑块就返回初始位置
                handler.css({'left': 0});
                drag_bg.css({'width': 0});
            }
        });

        //清空事件
        function dragOk() {
            handler.removeClass('handler_bg').addClass('handler_ok_bg');
            text.text('验证通过');
            drag.css({'color': '#fff'});
            handler.unbind('mousedown');
            dragyz = true;
            $(document).unbind('mousemove');
            $(document).unbind('mouseup');
        }
    };
    //	表单序列化为JSON数据
    $.fn.serializeJson = function () {
        var serializeObj = {};
        $(this.serializeArray()).each(function () {
            serializeObj[this.name] = this.value;
        });
        return serializeObj;
    };
})(jQuery);




////接口地址
//var baseUrl='http://api.mycxf.org';
//var requestUrl = {
//	'indexAd':baseUrl+'/index',                      //首页广告栏接口
//	'indexc':baseUrl+'/category',                 //首页菜单，商品接口
//	'admAdviert_l':baseUrl+'/admin/adviert_list',    //后台首页广告管理 
//	'admAdd_active':baseUrl+'/admin/add_active',           //后台首页广告管理添加活动专题
//	'admAdd_viert':baseUrl+'/admin/add_viert',       //后台首页广告管理添加广告 
//	'adviert_type':baseUrl+'/admin/adviert_type'                  //获取广告位，广告类型	
//}



var X = {
    Name: 'Xplus',
    // 数据绑定方法，传入接口地址，外层id， type 0 不需要登录 ， 1 需要登录。第三个参数可选：数据是字符型json数组时，不传值，当是json型数据时须传入定位到绑定对象前一级如“body.ch”中间以.号隔开，如无父级传入空 '';
    // 该方法可遍历可单绑    可混用可单用；
    NoToken: {
        "time_stamp": new Date().getTime()
    },
    hasToken: {
        "time_stamp": new Date().getTime()
    },
    bindModel: function (url, type, data, pos, arr, callback, callback1) {
        var self = {};
        if (typeof pos == "function") {
            self.callback = pos;
            pos = undefined;
        }
        if (callback) {
            self.callback = callback;
        }
        if (callback1) {
            self.callback1 = callback1;
        }
        if (type == 0) {
            if (data != '') {
                self.data = $.extend(data, X.NoToken);
            } else {
                self.data = X.NoToken;
            }
        } else if (type == 1) {
            if (data != '') {
                self.data = $.extend(data, X.hasToken);
            } else {
                self.data = X.hasToken;
            }
        }
        $.post(url, JSON.stringify(self.data), function (data) {
            var x;
            if (pos != undefined)
            {
                self.pos = pos.split('.');
                if (typeof data == 'string') {
                    var data = eval("(" + data + ")");
                }
                x = data;
                if (self.pos != '') {
                    for (i in self.pos) {
                        x = x[self.pos[i]];
                    }
                }
                if (self.callback1) {
                    var b = self.callback1(x);
                    if (b != undefined) {
                        x = b;
                    }
                }
                self = $.extend(self, x);
            } else {
//		        x = eval("("+data+")");
                $.each(x, function (i, x) {
                    self.list.push(x);
                });
            }
            //console.log(self);
            for (var i in arr) {
                ko.applyBindings(self, document.getElementById(arr[i]));
            }
            if (self.callback) {
                self.callback()
            }
        })
        return self;
    },
    //交互post使用接口   ， type 0 不需要登录 ， 1 需要登录。
    Post: function (url, type, data, callback) {
        if (type == 0) {
            var data = $.extend(data, X.NoToken);
        } else if (type == 1) {
            var data = $.extend(data, X.hasToken);
        }
        $.post(url, JSON.stringify(data), function (x) {
            if (typeof x == 'string') {
                var x = eval("(" + x + ")")
            }
            callback(x);
        })
    },
    // 翻页数据绑定方法，传入接口地址，外层id， type 0 不需要登录 ， 1 需要登录，每行条数，第四个参数可选：数据是必须是字符型json数组，传入定位到绑定对象如“body.ch.list”中间以.号隔开，如无父级则不传;
    turnPage: function (url, id, n, type, data, pos) {
        var n = n;
        if (pos != undefined) {
            var selfPos = pos;
        }
        var time;
        if (type == 0) {
            if (data != '') {
                time = $.extend(data, X.NoToken);
            } else {
                time = X.NoToken;
            }
        } else if (type == 1) {
            if (data != '') {
                time = $.extend(data, X.hasToken);
            } else {
                time = X.hasToken;
            }
        }
        $.post(url, time, function (data)
        {
            var x = data;
            //console.log(x);
            if (selfPos != undefined) {
                var pos = selfPos.split('.');
                ;
                for (i in pos) {
                    x = x[pos[i]];
                }
            }
//			x = eval("("+x+")");
            if (pos != undefined) {
                X.paging(x, url, n, time, id, selfPos);
            } else {
                X.paging(x, url, n, id, time);
            }
        })
    },
    paging: function paginationViewModel(data, url, n, time, id, pos) {   //分页
        var self = {};
        self.rechargeInfo = null;
        self.list = null;
        self.bindTure = true;
        self.time = time;
        if (pos != undefined) {
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
        } else
        {
            self.list = ko.observableArray(undefined);
        }
        self.url = url;
        self.row = data.length;
        //每页显示多少个标签(多少页码)
        self.pageshow = n;
        //总共多少页
        self.totalpage = Math.ceil(self.row / self.pageshow)
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
            $.post(self.url, self.time, function (data) {
                var x = data;
                ;
                self.list.removeAll();
                if (self.pos != undefined) {
                    for (i in self.pos) {
                        x = x[self.pos[i]];
                    }
                }
//	   	   	    x = eval("("+x+")");	
                //          var oo = JSON.parse(x);
                $.each(x, function (i, x) {
                    if ((self.currentpage() - 1) * self.pageshow <= i && i < self.currentpage() * self.pageshow) {   //新添加
                        self.list.push(x);
                    }
                });
                if (self.bindTure) {
                    ko.applyBindings(self, document.getElementById(id));
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
            $.post(self.url, obj, function (x) {
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
    mod: {                  //自定义模块

    },
    setMod: function (packageName) {
        if (packageName) {
            eval(packageName + "={}");
        }
    },
    //1,轮播传入父级名称，2,轮播间隔时间，3,轮播方式：传入opacity即淡入淡出效果  转动效果则传入空如'' 4,及是否返回再次调用
    lbChange: function (name, time, way, swt) {
        var my = {};
        my.num = 0;
        my.way = way;
        my.n = $('.' + name + 'Ui>li').length;
        my.time = time + '000';

        $('.' + name + 'C>li').hover(function () {
            clearInterval(my.timer);
            var numO = $(this).index();
            my.lbChangeTo(numO);
        }, function () {
            my.setTimer();
        });
        $('.' + name + '_l').on('click', function () {
            var numO = my.num - 1;
            if (numO <= -1) {
                numO = 2
            }
            my.lbChangeTo(numO);
        });
        $('.' + name + '_r').on('click', function () {
            var numO = my.num + 1;
            if (numO >= my.n) {
                numO = 0
            }
            my.lbChangeTo(numO);
        });
        $('.' + name).hover(function () {
            clearInterval(my.timer);
        }, function () {
            my.setTimer();
        })
        my.lbChangeTo = function (numO) {
            if (my.num == numO) {
                return;
            } else {
                if (my.way == 'opacity') {
                    $('.' + name + 'Ui>li').eq(my.num).stop().animate({'opacity': 0}, 500)
                    my.num = numO;
                    $('.' + name + 'Ui>li').eq(my.num).stop().animate({'opacity': 1}, 500)
                    $('.' + name + 'C>li').eq(my.num).addClass('hover').siblings().removeClass('hover');  // 淡入淡出效果
                } else {
                    $('.' + name + 'Ui').stop().animate({'left': -numO + '00%'}, 500);
                    $('.' + name + 'C>li').eq(numO).addClass('hover').siblings().removeClass('hover');
                    my.num = numO;
                }
            }
        };
        my.setTimer = function () {
            my.timer = setInterval(function () {
                var numO = my.num + 1;
                if (numO >= my.n)
                    numO = 0;
                my.lbChangeTo(numO);
            }, my.time)
        };
        my.setTimer();
        if (swt) {
            return my
        }
    },
    search: function () {
        $("#search").keyup(function () {
            $.ajax({
                type: "get",
                url: "",
                async: true,
                data: "txt_search=" + escape($("#search").val()),
                success: function (data) {
                    if (data != "") {
                        var ss;
                        ss = data.split("@");
                        var layer;
                        layer = "<table>";
                        for (var i = 0; i < ss.length - 1; i++) {
                            layer += "<tr><td class='line'>" + ss[i] + "</td></tr>";
                        }
                        layer += "</table>";
                        $("#searchresult").empty();
                        $("#searchresult").append(layer);
                        $(".line").hover(function () {
                            $(this).addClass("hover");
                        }, function () {
                            $(this).removeClass("hover");
                        });
                        $(".line").click(function () {
                            $("#search").val($(this).text());
                        });
                    } else {
                        $("#searchresult").empty();
                    }
                },
                error: function () {
                    alert("对不起，获取数据失败！");
                }
            });
        })
        $("#search").click(function () {
            $("#searchresult").empty();
        })
    },
    notice: function (mes, time) {
        var div = document.createElement("div");
        div.innerHTML = mes;
        var times = time + '000';
        div.style.cssText += 'position:fixed;z-index: 9999; top: 20%;left: 50%;opacity:0;filter: alpha(opacity:0);padding: 20px 25px;border:2px solid #fb2653; border-radius: 5px;background: #fff; color: #fb2653;font-size: 20px';
        document.body.appendChild(div);
        div.style.cssText += 'margin-left: -' + $(div).width() * 0.5 + 'px';
        $(div).stop().animate({'opacity': 1, 'filter': 'alpha(opacity:1)'}, 600)
        setTimeout(function () {
            $(div).fadeOut(600);
            setTimeout(function () {
                document.body.removeChild(div);
            }, 600);
        }, times)
    },
    // 弹出框 
    alert: function () {
        if (!document.getElementById('tank')) {
            switch (arguments.length) {
                case 1:
                    new X.alertBox(arguments[0]).show();
                    break;
                case 2:
                    new X.alertBox(arguments[0], arguments[1]).show();
                    break;
            }
        }
    },
    alertBox: function () {
        var me = {
            fnShow: function () {
                this.div1.style.cssText += "width:300px;height:300px;position:absolute;left:50%;opacity:0;filter: alpha(opacity:0);margin-left:-150px;top:50%;margin-top:-150px;background:#fff;z-index:9999;";
                $(this.div1).stop().animate({'opacity': '1', 'filter': 'alpha(opacity:100)'}, 600)
            },
            fnHide: function () {
                $(this.div1).stop().animate({'opacity': '0', 'filter': 'alpha(opacity:0)'}, 600);
                $(this.div2).stop().animate({'opacity': '0', 'filter': 'alpha(opacity:0)'}, 600)
            },
            canCel: function () {
                this.fnHide();
                setTimeout(function () {
                    document.body.removeChild(me.div1);
                    document.body.removeChild(me.div2);
                }, 600);
            }
        };
        me.callback = arguments[1];
        me.id = "tank";
//      me.btnId = ;
        me.content = arguments[0];
        me.show = function () {
            if (!me.div1) {
                me.div1 = document.createElement("div");
                me.div2 = document.createElement("div");
                me.div2.style.cssText += 'position:fixed;top: 0;left: 0;width:100%;height:100%;z-index:99;opacity:.5;background: #000;filter: alpha(opacity:50)';
                me.div1.setAttribute('id', me.id);
                document.body.appendChild(me.div1);
                document.body.appendChild(me.div2);
                me.div1.innerHTML = '<h4 style="text-align:left;margin-top:25px;">' + '提示' + '</h4>'
                        + '<p id="tCancel" style="position: absolute;top: 0;right: 0;font-size: 24px;cursor: pointer;width: 30px;height: 30px;">&Chi;</p>'
                        + '<p style="font-weight: bold;text-align: center;margin-top: 120px;">' + this.content + '</p>'
                        + '<div style="margin-right: 20px;text-align: right;margin-top: 65px;">'
                        + '<input id="tConfirm" type="button" value="确定" style="cursor: pointer;"/>' + '</div>';
                me.oBtn = document.getElementById('tConfirm');
                me.oCancel = document.getElementById('tCancel');
            }
            me.fnShow();
            me.oCancel.onclick = function () {
                me.canCel();
            }
            me.oBtn.onclick = function () {
                me.canCel();
                me.callback();
            };
        };
        return me;
    },
    sendMess: function (callback) {
        if ($('.tank').size() <= 0) {
            $('head').append('<link class="tank" href="/shop/templates/default/css_new/tank.css" rel="stylesheet" type="text/css"/>')
        }
        var oT = document.createElement('div');
        $(oT).addClass('Modal');
        var html = '<div class="modal-content">'
                + '<label><input type="" name="mobile" class="code" id="" placeholder="请输入要获取验证码的手机号" value="" /><a href="javascript:void(0);" id="send_auth_code" class="ncm-btn ml5">获取短信验证码</a><span class="send_success_tips"><strong id="show_times" class="red mr5">60</strong>秒后再次发送</span></a></label>'
                + '<label><input type="" name="mobile" class="codeMobile" id="" placeholder="输入获取的验证码" value="" /></label>'
                + '<label><div class="sub-btn"><input type="submit" class="sumb" value="提交"/></div></label>'
                + '</div>'
                + '<span class="close">×</span>'
        $(oT).append(html);
        if ($('.Modal').size() <= 0) {
            $('body').append(oT);
        }
        $('.close').click(function () {
            document.body.removeChild(oT);
        })
        $('.Modal').delegate('#send_auth_code', 'click', function () {
            var oThis = $(this);
            var datar = {
                "mobile": $('input[name="mobile"]').val()
            }
            if (datar.mobile.length == 11 && datar.mobile.match(/^1[3-9][0-9]+$/)) {
                //				 $.post('<?php echo SHOP_SITE_URL?>/shop/index.php?act=bindmobile&op=sendsms',datar,function(data){
                oThis.hide();
                $('.send_success_tips').show();
                var n = 59;
                var timer = setInterval(function () {
                    if (n >= 0) {
                        $('.mr5').html(n);
                        n--;
                    } else {
                        $('#send_auth_code').show();
                        $('.send_success_tips').hide();
                        clearInterval(timer);
                    }
                }, 1000);
//							if(data.status == 'fail'){
//								 X.notice(data.msg,3);
//							}	
                //			     })
            } else {
                X.notice('手机号格式有误', 3)
            }
        });
        $('.Modal').delegate('.sumb', 'click', function () {
            callback();
        });
    },
    //图片展示放大镜效果，依次传入下列数组值
    magnifyImg: function (arr) {
        var objDemo = $(arr[0])[0], //小图定位外层
                objSmallBox = $(arr[1])[0], //小图层
                objMark = $(arr[2])[0], //小图
                objFloatBox = $(arr[3])[0], //小图层浮动选区块
                objBigBox = $(arr[4])[0], //大图层
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

            var left = _event.clientX - objDemo.offsetLeft - objSmallBox.offsetLeft - objFloatBox.offsetWidth / 2;
            var top = _event.clientY - objDemo.offsetTop - objSmallBox.offsetTop - objFloatBox.offsetHeight / 2;

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
    //模块导入函数
    require: function (name) {
        if (name.substring(0, 1) == '.') {
            name = this.Name + name;
        }
        var src = name.replace(/\./g, '/') + '.js';
        this.writeScript(src);
    },
    writeScript: function (src) {     //模块写入函数
        document.write('<script type="text/javascript" src="' + src + '"></' + 'script>');
    },
//    验证为空
    toSerchVaild: function (obj) {
        var val = [];
        var q = $(obj).find('select');
        for (var i = 0; i < q.size(); i++) {
            if (q.eq(i).find('option:selected').index() != 0) {
                return true;
            }
        }
        $(obj).find('input[type="text"]').each(function () {
            val.push($(this).val());
        })
        for (var i in val) {
            if (val[i] != '') {
                return true
            }
        }
        return false
    },
//		非空验证
//		nounVerify:function(obj){
//				var val = [];
//				var q = $(obj).find('select');
//				for(var i=0;i<q.size();i++){
//					 if(q.eq(i).find('option:selected').index() == 0){
//					 	  return true;
//					 }
//				}
//				$(obj).find('input[type="text"]').each(function(){
//					 val.push($(this).val());
//				})
//				for(var i in val){
//					if(val[i] == ''){		
//						return true
//					}
//				}
//				return false
//		}
//  图片上传  只传arr['按钮 id'，是否多传 true 为多传： false 单传，'存放图片预览的div',1 为机密 ，其他0,第六个参数，如果不定义默认goods，不然传入类型  如 ‘ad’]
    upLoadImg: function (arr, fun, callback) {    //arr[btn,多传ture:单传false,图片放置位置id或class,]
        var upParameter = {
            browse_button: arr[0], /*默认的浏览文件按钮id*/
            // resize : {width : 1000, height : 750,quality : 80},
            runtimes: 'html5,flash,silverlight,html4',
            url: arr[4] == 1 ? 'http://v0.api.upyun.com/cxf-scret' : 'http://v0.api.upyun.com/cxf-img-new',
            flash_swf_url: 'plupload-2.1.2/js/Moxie.swf',
            multi_selection: arr[1],
            silverlight_xap_url: 'plupload-2.1.2/js/Moxie.xap',
            filters: {max_file_size: '10mb', prevent_duplicates: true},
            preserve_headers: true,
            multipart_params: {'policy': '', 'signature': ''}
        };
        var my = {
            i: 0,
            ii: 0,
            file: [],
            previewImage: function (file, callback) {
                if (!file || !/image\//.test(file.type))
                    return;
                if (file.type == 'image/gif') {
                    var fr = new mOxie.FileReader();
                    fr.onload = function () {
                        callback(fr.result);
                        fr.destroy();
                        fr = null;
                    }
                    fr.readAsDataURL(file.getSource());
                } else {
                    var preloader = new mOxie.Image();
                    preloader.onload = function () {
                        preloader.downsize(160, 120);
                        var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 60) : preloader.getAsDataURL();
                        callback && callback(imgsrc);
                        preloader.destroy();
                        preloader = null;
                    };
                    preloader.load(file.getSource());
                }
            },
            del: function (n) {
                for (var i in uploader.files) {
                    if (uploader.files[i].id == n) {
                        var nn = i;
                    }
                }
                uploader.removeFile(uploader.files[nn]);
            }, delView: function (n) {
                my.file.splice(n, 1);
                $(arr[2] + ' .img-wrap').eq(n).remove();
            }
        };

        var uploader = new plupload.Uploader(upParameter);
        uploader.init();
        uploader.bind('FilesAdded', function (uploader, files) {
            if (!arr[1] && uploader.files.length > 1) {
                return false;
            }
            if (arr[3]) {
                $(arr[3]).fadeOut()
            }
            my.file = [];
            $(arr[2]).html('第'+(my.i+1)+'张 准备上传');
            var data = new Date().getTime();
            for (var i = 0; i < files.length; i++) {
//                my.file.push(md5(data + Math.random().toString() + Math.random()) + '.' + files[i].type.split('/')[1])
                my.file.push(files[i].name);
                !function (i) {
                    my.previewImage(files[i], function (imgsrc) {
//                        if (arr[2] != '') {
//                            $(arr[2]).append('<li class="img-wrap"><span class="upImgMask" style="position:absolute;z-index:2;display:block;width:100%;height:100%;background:rgba(0,0,0,.5);color:#fff;line-height:50px;text-align: center;font-size: 12px;"></span><img id="' + files[i].id + '" src="' + imgsrc + '" ><b class="imgDelete" data-id="' + files[i].id + '">-</b></li>');
//										$(arr[2]).append('<div class="col-sm-3 img-wrap" style="position: relative;"><span class="upImgMask" style="position:absolute;z-index:2;display:block;width:100%;height:100%;background:rgba(0,0,0,.5);color:#fff;line-height:120px;text-align: center;font-size: 30px;"></span><p class="imgDelete" data-id="'+files[i].id+'" style="position:absolute;right:0;top:0;width:20px;height:20px;font-size:25px;z-index:5;">X</p><img id="'+files[i].id+'" src="'+ imgsrc +'" /></div>');
//										$('#'+files[i].id).height($('#'+files[i].id).width()*3/4);	//固定高宽比
//                        }
                    })
                }(i);
            }
            var datar = {
                'file_type': arr[5] == undefined ? 'goods' : arr[5], 'file_name': my.file, 'secret': arr[4]
            }
            X.Post("http://192.168.20.191:85/get_img_token", 1, datar, function (data) {
                my.crede = data.body.list;
//          	   uploader.settings.url = 'http://v0.api.upyun.com/imgscret';
                uploader.settings.multipart_params.policy = my.crede.policy[my.i];
                uploader.settings.multipart_params.signature = my.crede.sign[my.i];
                uploader.start();
            })
        });
        uploader.bind('UploadProgress', function (uploader, file) {
//            $(arr[2] + ' .img-wrap').eq(my.ii).children('.upImgMask').html(file.percent + '%')
             $(arr[2]).html('第'+(my.i+1)+'张 '+file.percent + '%');
        });
        uploader.bind('FileUploaded', function () {
            $(arr[2] + ' .img-wrap').eq(my.ii).children('.imgDelete').removeClass('imgDelete').addClass('imgOverDelete');
            $(arr[2] + ' .img-wrap').eq(my.ii).children('.upImgMask').remove();
            my.i++;
            my.ii++;
            uploader.settings.multipart_params.policy = my.crede.policy[my.i];
            uploader.settings.multipart_params.signature = my.crede.sign[my.i];
        });
        uploader.bind('UploadComplete', function (uploader, file) {
	    X.notice('图片上传完成',2);					 // console.log(uploader.files);
            $(arr[2]).html('');
            if (arr[3]) {
                $(arr[3]).fadeIn()
            }
            $('.moxie-shim').hide();
            $.post(idd2, {'up_path': JSON.stringify(idd1.file)}, function (e) {
                if (e == undefined) {
                    var e = eval("(" + e + ")")
                }
//                console.log(e);
                X.notice(e.msg, 3);
            })
        });
        uploader.bind('Error', function (uploader, file) {
            X.notice('上传失败', 3);
//					  my.delView(my.i);
            if (arr[3]) {
                $(arr[3]).fadeIn()
            }
            ;
            my.del(my.i);
            my.delView(my.i);
        });
        $(arr[2]).delegate('.imgDelete', 'click', function () {
            var oIndex = $(this).parent().index();
            var n = $(this).attr('data-id');
            my.del(n);
            my.delView(oIndex);
        })
        $(arr[2]).delegate('.imgOverDelete', 'click', function () {
            var oIndex = $(this).parent().index();
            var n = $(this).attr('data-id');
            my.delView(oIndex);
            my.del(n);
            my.i--;
            my.ii--;
        })
        return my;
    }
}





