<!DOCTYPE html>
<html>
<head>
    <head>
        <meta charset="UTF-8">
        <!-- 设置360浏览器渲染模式,webkit 为极速内核，ie-comp 为 IE 兼容内核，ie-stand 为 IE 标准内核。 -->
        <meta name="renderer" content="webkit">
        <meta name="google" value="notranslate">
        <!-- 禁止Chrome 浏览器中自动提示翻译 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta http-equiv="Cache-Control" content="no-siteapp"/>
        <!-- 禁止百度转码 -->
        <meta name="Description" content=""/>
        <meta name="Keywords" content=""/>
        <meta name="author" content="">
        <meta name="Copyright" content=""/>
        <title>创想范分销平台--我的收藏夹</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon"/>
        <link rel="stylesheet" type="text/css" href="css/zengli.css"/>
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsList.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/plus.js"></script>
        <script src="js/public.js"></script>
        <style>
        	.cont-box .cont-box-body{
        		height: 86%;
        	}
        </style>
    </head>

<body>

<?php include_once 'base/vip_top.php'; ?>
<div class="capital">
    <?php include_once 'base/vip_top_1.php'; ?>

    <div class="capital-box clearfix">
        <?php include_once 'base/vip_left.php'; ?>
        <div class="capital-body">
            <div class="capital-cont">
                <div class="cont-box">
                    <div class="cont-box-title">
                        <div class="title-box">
                            <span>是否铺货：</span>
                            <select name="" id="PHType">
                                <option value="">——请选择——</option>
                                <option value="1">已铺货</option>
                                <option value="2">未铺货</option>
                            </select>
                        </div>
                        <!--<div class="title-box">
                            <span>关键字：</span>
                            <input type="text" name="" class="keyword" placeholder="请输入关键字">
                            <input class="btn" type="button" id="" value="搜索"/>
                        </div>-->
                    </div>
                    <div class="cont-box-body" id="accept">
                        <table>
                            <thead>
                                <tr>
                                    <th>主图</th>
                                    <th>宝贝名称</th>
                                    <th>采购价</th>
                                    <th>库存</th>
                                    <th>添加时间</th>
                                    <th>是否铺货</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody id="_accept" data-bind="foreach:{data:item,as:'auto'}">
                                <tr data-bind="attr:{'data-id':goods_id,'data-num':buyer_goods_no,'data-name':goods_name,'data-taobao':is_up_taobao}">
                                    <td><input  style="float: left;margin: 10px 20px;" type="checkbox" name="" id="" value="" /><img style="width: 50px;float: left;" src="" data-bind='attr:{"src":img_path}'/></td>
                                    <td ><a class="coll-goodsname" data-bind="text:goods_name,attr:{'href':'good_detail.php?goodsID='+goods_id}"></a></td>
                                    <td>
                                        <p class="price_highlight">基础价：<span data-bind="text:price.basic_price"></span></p>
                                        <p class="price_highlight">中级价：<span data-bind="text:price.middle_price"</p>
                                        <p class="price_highlight">高级价：<span data-bind="text:price.senior_price"></span></span></p>
                                    </td>
                                    <td>
                                        <p class="openStock" data-bind="text:total_stock_num"></p>
                                    </td>
                                    <td data-bind="text:addtime"><span></span><span></span></td>
                                    <td><span data-bind="text: is_up_taobao == 1 ?' 已铺货':'未铺货' "></span></td>
                                    <td id="handle"><span class="key_PH">一键铺货</span> | <span class="PHdelet">删除</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cont-box-foot">
                        <div class="cont-box-foot-lf">
                            <label><input type="checkbox" name="" id="all-select" class="checkAll" value=""/>全选</label>

                        </div>
                        <div class="cont-box-foot-rf">
                            <input type="button" id="all-PH" class="btn" value="一键铺货"/>
                            <input type="button" id="all-delet" class="btn btn-w last-btn" value="删除"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'base/vip_right.php'; ?>
    </div>
</div>
<?php include_once 'base/vip_footer.php'; ?>

<!--弹窗-->
<div class="marks" id='SKU' style="">
    <div class="PopDiv" style="width: 360px;min-width: 285px;margin: 200px auto 0;">
        <div class="PopHeader">
            <span class="PopTitle">可用总库存：<span data-bind = "text:total_stock_num"></span></span>
            <div class="PopColse"></div>
        </div>
        <div class="PopBody">
            <ul data-bind = "foreach:{data:sku,as:'auto'}">
                <li>
                    <span data-bind="text:sku_str_zh">SKU属性1/属性2：</span>库存：<span data-bind="text:stock_num">1000</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--一件铺货-->
<div class="marks PH" style="display: none">
    <div class="PopDiv">
        <div class="PopHeader">
            <img src="images/PopIco/tips.png" alt="">
            <span class="PopTitle">铺货</span>
            <div class="PopColse" onclick="colsePh()"></div>
        </div>
        <div class="PopBody" id="PHGoods">
            <div class="Phcontent">
                <p>铺货详情：<span>以下商品将发布到您当前的默认店铺：</span><select id="shopList"></select></p>
                <div class="PhTab">
                    <table>
                        <tr>
                            <th>商品ID</th>
                            <th>货号</th>
                            <th>商品标题</th>
                            <th>铺货结果</th>
                        </tr>
                        <tbody data-bind="foreach:{data:goodsArr,as:'auto'}">
                            <tr data-bind="attr:{class:'goodsID'+goodsID}">
                                <td data-bind="text:goodsID"></td>
                                <td data-bind="text:buyer_goods_no"></td>
                                <td data-bind="text:goods_name"></td>
                                <td class="PHstatus">等待铺货</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="Phsele">
                    <table>
                        <tr>
                            <td>快递选项：</td>
                            <td><label><input type="radio" name="PhMailType" value="0" checked>包邮</label></td>
                            <td style="text-align: right">
                                淘宝自定义分类：<select id="goodsType">
                                    <option>--请选择--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">
                                <label><input type="radio" name="PhMailType" value="1">买家承担运费</label>运费统一设置为：<input
                                    type="text" placeholder="运费金额" id="freight_fee"> 元
                                <span>买家承担运费的范围为0.001~999.00</span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2"><label><input type="radio" name="PhMailType" value="2">使用卖家运费模板</label><select id="shopTemplate">
                                    <option>123132</option>
                                </select><span>必须选择一个模板，如果没有请至淘宝添加</span></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="PhJD">
                    <p><i></i></p>
                    <span>完成度：<b class="nowNum">0</b>/<b class="PHNum"></b></span>
                </div>
            </div>
        </div>
        <div class="PopFooter">
            <button class="startPH">开始铺货</button>
        </div>
    </div>
</div>
</body>
</html>

<script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
<script src="js/plus.js" type="text/javascript" charset="utf-8"></script>
<script src="js/public.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var PHGood = $('#PHGoods').html();
    function yijinPH(DetailViewModel) {
        CheckUserLogin();
        var ids = [];
        var userID = getCookieValue('user_id');
        X.Post(requestUrl.check_is_bindtaobao, 1,{user_id:userID}, function (res) {
            if(res.header.stats==0){
                if(res.body.list.is_bind==0){
                    X.notice('您尚未绑定淘宝店铺',3);
                }else {
                    $('.PH').show();
                    $('#PHGoods').html(PHGood);
                    ko.cleanNode(document.getElementById("PHGoods"));
                    $('#PHGoods').html(PHGood);
                    var ii = 609 / parseInt($(DetailViewModel.goodsArr).length);
                    //绑定数据
                    ko.applyBindings(DetailViewModel, document.getElementById('PHGoods'));

                    $('.Phcontent select,.Phcontent input,.startPH').attr('disabled','disabled');

                    $('.PHNum').text($(DetailViewModel.goodsArr).length);
                    $(DetailViewModel.goodsArr).each(function () {
                        ids.push(this.goodsID);
                    });

                    //获取用户店铺列表
                    var userid = getCookieValue('user_id');
                    X.Post(requestUrl.band_shop, 1, {user_id: userid}, function (res) {
                        if (res.header.stats == 0) {
                            var str = '';
                            $(res.body.list).each(function (key, val) {
                                str += '<option value="" tb_user_id=' + this.tb_user_id + '>' + this.nick + '</option>'
                            });
                            $('#shopList').html(str);
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                            shopType(tb_user_id);
                        } else {
                            X.notice('获取用户店铺信息失败', 3)
                        }
                    });

                    $('#shopList').change(function () {
                        var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                        shopType(tb_user_id);
                    });

                    //获取店铺的类目和运费模板
                    function shopType(tb_user_id) {
                        var templateData = {
                            user_id: userid,
                            shop_id: tb_user_id
                        };
                        X.Post(requestUrl.tb_template, 1, templateData, function (res) {
                            if (res.header.stats == 0) {
                                var catStr = '', templateStr = '';
                                //店铺商品分类
                                var cats = res.body.list.seller_cats;
                                if(cats.length<=0){
                                    catStr = "<option value=''>--请选择--</option>";
                                }
                                var templates = res.body.list.delivery_templates;
                                $(cats).each(function () {
                                    catStr += '<option value="' + this.cid + '">' + this.name + '</option>'
                                });
                                $('#goodsType').html(catStr);
                                //店铺运费模板
                                $(templates).each(function () {
                                    templateStr += '<option value="' + this.template_id + '">' + this.name + '</option>'
                                });
                                $('#shopTemplate').html(templateStr);

                                $('.Phcontent select,.Phcontent input,.startPH').removeAttr('disabled','disabled');
                            } else {
                                $('#goodsType').html('<option value="">--请选择--</option>');
                                $('#shopTemplate').html('<option value="">--请选择--</option>');
                                X.notice('获取用户运费模板失败', 3);
                            }
                        });
                    }

                    //快递选项
                    var freightType = 0;
                    $('.Phsele table input[type=radio]').click(function () {
                        freightType = $(this).attr('value');
                    });

                    //一键铺货
                    $('.startPH').unbind('click').click(function () {
                        allPhFun(ids);
                    });

                    function allPhFun(goodsID) {
                        var PHdata = {
                            goods_id: goodsID, //商品ID
                            user_id: userid, //用户ID
                            cid: '', //商品分类ID
                            tb_user_id: $('#shopList option:selected').attr('tb_user_id'), //淘宝用户ID
                            freight_type: freightType, //邮费方式
                            freight_fee: '', //自填邮费
                            template_id: '', //淘宝运费模板ID
                            platform: 1          //平台
                        };
                        if (freightType == 1) {
                            var freightText = $('#freight_fee').val();
                            if (freightText == '') {
                                X.notice('请填写运费金额', 3);
                            } else if (isNaN(freightText)) {
                                X.notice('运费金额必须为数字', 3);
                                $('#freight_fee').val('');
                            } else if (freightText < 0) {
                                X.notice('运费金额不能小于0', 3);
                                $('#freight_fee').val('');
                            } else {
                                PHdata.freight_fee = parseFloat(freightText).toFixed(2);
                                PH();
                            }
                        } else if (freightType == 2) {
                            var templateid = $('#shopTemplate option:selected').attr('value');
                            if (templateid == undefined || templateid == '') {
                                X.notice('请选择运费模板', 3);
                            } else {
                                PHdata.template_id = parseInt(templateid);
                                PH();
                            }
                        } else {
                            PH();
                        }

                        //一键铺货请求
                        function PH() {
                            var goodsType = $('#goodsType option:selected').attr('value');
                            var nowNum = 0;
//                            if (goodsType == undefined || goodsType == '') {
//                                X.notice('请选择商品分类', 3);
//                            } else {
                                $('.Phcontent select,.Phcontent input,.startPH').attr('disabled','disabled');
                                $('.startPH').text('铺货中...').css('background','#ccc');

                                PHdata.cid = goodsType;
                                var len = $(PHdata.goods_id).length;
                                $(PHdata.goods_id).each(function (key, item) {
                                    PHdata.goods_id = item;
                                    X.Post(requestUrl.item_add_taobao, 1, PHdata, function (res) {
                                        if (res.header.stats == 0) {
                                            if (res.body.list.sucess == true) {
                                                nowNum++;
                                                $('.goodsID' + item + '>.PHstatus').text('铺货完成').css('color', '#1def12');
                                                $('.nowNum').text(nowNum);
                                                $('.PhJD p').animate({'width': ii * nowNum + 'px'}, 500);
                                                if(nowNum==len){
                                                    $('.startPH').text('铺货完成').removeAttr('disabled','disabled').css('background', '#ff6537').removeClass('startPH').addClass('endPH');
                                                    X.notice('铺货完成',3);
                                                    $('.endPH').unbind('click').click(function(){
                                                        colsePh();
                                                    })
                                                }
                                            }
                                        } else {
                                            $('.Phcontent select,.Phcontent input,.startPH').removeAttr('disabled','disabled');
                                            $('.startPH').text('开始铺货').css('background','#ff6537');
                                            X.notice(res.header.msg, 3);
                                        }
                                    })
                                });
//                            }
                        }
                    }
                }
            }
        });
    }

    function colsePh(){
        $('.Phcontent select,.Phcontent input,.startPH').removeAttr('disabled','disabled');
        $('.endPH').removeClass('endPH').addClass('startPH');
        $('.PhJD p').css('width','15px');
        $('.startPH').text('开始铺货');
        $('.nowNum').text(0);
        $('.marks,.PH').hide();
    }
</script>
<script type="text/javascript">
	var oHtml = $('#SKU').html();
	//库存
	
//	var kuc = X.bindModel(requestUrl.accept, 1, data, 'body.list', ['accept'], function () {
//      	
//		})
    $('#SKU .PopColse').click(function () {
        $('#SKU').fadeOut()
    });
    var DetailViewModel = {
        goodsArr:[]
    };
    $(function () {
        var level = getCookieValue("user_level"), levelStr = "", o = $(".price_highlight");
        switch (level) {
            case "0":
                $(o[0]).css({color: "#f40"});
                break;
            case "1":
                $(o[0]).css({color: "#f40"});
                break;
            case "2":
                $(o[1]).css({color: "#f40"});
                break;
            case "3":
                $(o[2]).css({color: "#f40"});
                break;
        }
        var data = {
            'user_id': getCookieValue('user_id')
        };
        var kuc = X.bindModel(requestUrl.accept, 1, data, 'body.list', ['accept'], function () {
              $('#accept table tbody>tr').each(function () {
                  if($(this).attr('data-taobao')==1){
                  	$(this).children('td').children('.key_PH').remove();
                  }
              });
              
              //库存
            $('.openStock').on("click", function () {
                var ku_cun = $('#SKU');
                ku_cun.fadeIn();
                var xx = kuc.item[$(this).parents('tr').index()];
                ko.cleanNode(document.getElementById("SKU"));
                ku_cun.html(oHtml);
                ko.applyBindings(xx, document.getElementById('SKU'));
                $('#SKU .PopColse').click(function () {
                    $('#SKU').fadeOut();
                })
            });
              
            //单个商品铺货
            $('.key_PH').click(function () {
                DetailViewModel.goodsArr.length=0;
                var id = $(this).parents('tr').attr('data-id');
                var code = $(this).parents('tr').attr('data-num');
                var name = $(this).parents('tr').attr('data-name');
                DetailViewModel.goodsArr.push({goodsID: id,goods_name: name,buyer_goods_no: code});
                yijinPH(DetailViewModel)
            });

            $('.PHdelet').click(function () {
                var dataId = $(this).parents('tr').attr('data-id');
                addCookie('goods_id', dataId);
                var user_id = getCookieValue('user_id');
                var delData = {
                    'user_id': user_id,
                    'goods_id': dataId,
                    'page': 1,
                    'is_up_taobao': 1
                };
                var self = this;
                X.Post(requestUrl.coll_delet + "?random=" + Math.random(), 1, delData, function (e) {
                    if (e.header.stats == 0) {
                        X.notice(e.body.list.msg, 3);
                        $(self).parents("tr").remove();
                    } else {
                        X.notice(e.header.msg, 3)
                    }
                })
            })
        }, function (e) {
            if (e.item == undefined) {
                e.item = [];
                return e
            }
        })
    });
    var PHhtml = $('#accept').html();
    $('#PHType').change(function () {
        ko.cleanNode(document.getElementById("accept"));
        $('#accept').html(PHhtml);
        data = {
            'user_id': getCookieValue('user_id'),
            'is_up_taobao': $('#PHType option:selected').val()
        };
//  	console.log(data.is_up_taobao);
        X.bindModel(requestUrl.accept, 1, data, 'body.list', ['accept'], function () {
            $('#accept table tbody>tr').each(function () {
                var oo = $(this).children('td').eq(0).find('input');
                if (oo) {
                    oo.attr('type', 'checkbox').css({'margin-right': '15px'})
                }
            });
            $('.PopColse').click(function () {
                $('#PH').hide();
            });
            $('.key_PH').click(function () {
                  var id = $(this).parents('tr').attr('data-id');
                  var code = $(this).parents('tr').attr('data-num');
                  var name = $(this).parents('tr').attr('data-name');
                var DetailViewModel = {
                    goodsArr: [
                        {
                            goodsID: id,
                            goods_name: name,
                            buyer_goods_no: code
                        }]
                };
                yijinPH(DetailViewModel)
            });
            $('.PHdelet').click(function () {
                var dataId = $(this).parents('tr').attr('data-id');
                addCookie('goods_id', dataId);
                var delData = {
                    'user_id': getCookieValue('user_id'),
                    'goods_id': getCookieValue('goods_id'),
                    'page': 1,
                    'is_up_taobao': 1
                };
                X.Post(requestUrl.coll_delet + "?random=" + Math.random(), 1, delData, function (e) {
                    if (e.header.stats == 0) {
                        X.notice(e.body.list.msg, 3);
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000)
                    } else {
                        X.notice(e.header.msg, 3)
                    }
                })
            })
        }, function (e) {
            if (e.item == undefined) {
                e.item = [];
                return e
            }
        })
    })
</script>

<!--批量铺货  批量删除-->
<script type="text/javascript">
//全选
    var chackFlag = false;
    $('#all-select').click(function () {
      if(!chackFlag){
          $('#accept td').find('input').prop('checked', true);
          chackFlag = true;
      }else {
          $('#accept td').find('input').prop('checked', false);
          chackFlag = false;
      }
    });


    //批量一键铺货
    $('#all-PH').click(function () {
        var len = $("#_accept input[type='checkbox']:checked").length;
        if(len<=0){
            X.notice('请选择商品',3);
        }else{
            DetailViewModel.goodsArr.length = 0;
            $('#_accept tr').each(function(){
                    var _this = $(this);
                    if(_this.attr('data-taobao')==1){
                    	_this.find('input').prop('checked',false);
//                    	X.notice('已自动为您排除已铺货的商品',3)
                    }else{
                    	if($(this).find('td').find('input').is(':checked')){
		                    DetailViewModel.goodsArr.push({'goodsID':_this.attr('data-id'),'goods_name':_this.attr('data-name'),'buyer_goods_no':_this.attr('data-num')});
		                }	
                    }
            });
            yijinPH(DetailViewModel);
        }
    });

    //批量删除
    $('#all-delet').click(function () {
        var checked = $('#_accept').find('input:checked').parents('tr');
        var goods_id = [];
        $.each(checked, function (i, d) {
            goods_id[i] = $(d).attr('data-id');
        });
        var allDeletdata = {
            user_id: getCookieValue('user_id'),
            goods_id: goods_id
        };
        if(goods_id.length > 0) {
            X.Post(requestUrl.coll_delet + "?random=" + Math.random(), 1, allDeletdata, function (e) {
                if (e.body.list.sucess == 1) {
                    $('#accept').find('input:checked').parents('tr').remove();
                    X.notice(e.body.list.msg, 3);
                } else {
                    X.notice(e.header.msg, 3)
                }
            })
        }else {
            X.notice("请选择商品", 3)
        }
    })
</script>
