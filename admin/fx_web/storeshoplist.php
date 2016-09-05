


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- 设置360浏览器渲染模式,webkit 为极速内核，ie-comp 为 IE 兼容内核，ie-stand 为 IE 标准内核。 -->
        <meta name="renderer" content="webkit">
        <meta name="google" value="notranslate">
        <!-- 禁止Chrome 浏览器中自动提示翻译 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!-- 禁止百度转码 -->
        <meta name="Description" content="" />
        <meta name="Keywords" content="" />
        <meta name="author" content="">
        <meta name="Copyright" content="" />
        <title>创想范分销平台--店铺商品管理</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/plus.js"></script>
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
                                <span>选择店铺：</span>
                                <select name="" id="shopList">
                                </select>

                                <span>选择状态：</span>
                                <select name="" id="list_type">
                                    <option value="1">出售中</option>
                                    <option value="2">仓库中</option>
                                </select>

                                <span>关键字：</span>
                                <input type="text" name="" class="keyword" id="keyWord" placeholder="请输入关键字">
                                <input class="btn" type="button" id="serchKey" value="搜索" />

                            </div>
                            <div class="cont-box-body" id="cont-box-body" style="height: 85%">
                                <table>
                                    <tr>
                                        <th>主图</th>
                                        <th>宝贝名称</th>
                                        <th>采购价</th>
                                        <th>库存</th>
                                        <th>总销量</th>
                                        <th>添加时间</th>
                                        <th>商品状态</th>
                                        <th>操作</th>
                                    </tr>
                                    <tbody  data-bind="foreach:{data:item,as:'auto'}" id="goodsList">
                                        <tr data-bind="attr:{goodStatus:approve_status,num_iid:num_iid,stockNum:num,goods_sale:goods_sale}">
                                            <td id="saleStatus" data-bind="html:goods_sale == 2 ? '<i></i>': '<input >',attr:{'data-src':pic_url}">

                                            </td>
                                            <td>
                                                <p data-bind="text:title"></p>
                                                <p data-bind="text:'商家编码：'+outer_id"></p>
                                            </td>
                                            <td>
                                                <span data-bind="text:price"></span>
                                            </td>
                                            <td>
                                                <p data-bind="text:num"></p>
                                            </td>
                                            <td>
                                                <p data-bind="text:sellout_count"></p>
                                            </td>
                                            <td><span data-bind="text:modified"></td>
                                            <td><span data-bind="text:approve_status=='instock'?'仓库中':'出售中'"></span></td>
                                            <td><span data-bind="style: {display: goods_sale == '1' ? 'inline' : 'none' }"><a data-bind="text:approve_status=='instock'?'上架':'下架',attr:{class:approve_status=='instock'?'oneUp':'oneDown',num_iid:num_iid,stocknum:num}"></a></span> <span><a data-bind="attr:{num_iid:num_iid}" class="oneDel">删除</a></span></td>

                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <div class="cont-box-foot">
                                <div class="cont-box-foot-lf">
                                    <label><input type="checkbox" name="" id="Allselect" value="" />全选</label>
                                </div>
                                <div class="cont-box-foot-rf">
                                    <input type="button" id="" class="btn shelfUp" value="上架" />
                                    <input type="button" id="" class="btn btn-w shelfDown" value="下架" />
                                    <input type="button" id="" class="btn btn-w last-btn delGoods" data-sign="1" value="删除" />
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
        <div class="marks">
            <div class="PopDiv" style="width: 285px;min-width: 285px;margin: 200px auto 0;">
                <div class="PopHeader">
                    <span class="PopTitle">可用总库存：300</span>
                    <div class="PopColse"></div>
                </div>
                <div class="PopBody">
                    <ul>
                        <li>
                            SKU属性1/属性2：<span>1000</span>
                        </li>
                        <li>
                            SKU属性1/属性2：<span>1000</span>
                        </li>
                        <li>
                            SKU属性1/属性2：<span>1000</span>
                        </li>
                        <li>
                            SKU属性1/属性2：<span>1000</span>
                        </li>
                        <li>
                            SKU属性1/属性2：<span>1000</span>
                        </li>
                        <li>
                            SKU属性1/属性2：<span>1000</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </body>


    <script>
        var data = {user_id: getCookieValue('user_id')};
        var tbID;
        var oHtml = $('#goodsList').html();
        CheckUserLogin();
        X.Post(requestUrl.check_is_bindtaobao, 1,data, function (res) {
            if(res.header.stats==0){
                if(res.body.list.is_bind==0){
                    X.notice('您尚未绑定淘宝店铺',3);
                }else {
                    //获取用户店铺列表
                    X.Post(requestUrl.band_shop, 1, data, function (res) {
                        if(res.header.stats==0){
                            var str = '';
                            $(res.body.list).each(function (key, val) {
                                if(this.default==1){
                                    str += '<option selected value="" tb_user_id=' + this.tb_user_id + '>' + this.nick + '</option>'
                                }else {
                                    str += '<option value="" tb_user_id=' + this.tb_user_id + '>' + this.nick + '</option>'
                                }
                            });
                            $('#shopList').html(str);
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                            tbID = tb_user_id;
                            bindShop(tb_user_id, 1);
                        }else {
                            X.notice('获取用户店铺列表失败',3);
                            $('#goodsList').hide();
                            $('.shelfUp,.shelfDown,.delGoods,.delLoseGoods').unbind('click').click(function(){
                                X.notice('请选择商品',3);
                            });
                        }
                    });

                    $('#shopList').change(function () {
                        var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                        var list_type = $('#list_type option:selected').attr('value');
                        bindShop(tb_user_id, list_type);
                        tbID = tb_user_id;
                        cheakFlag = true;
                    });
                    $('#list_type').change(function () {
                        var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                        var list_type = $('#list_type option:selected').attr('value');
                        bindShop(tb_user_id, list_type);
                        tbID = tb_user_id;
                        cheakFlag = true;
                    });
                    $('#serchKey').click(function(){
                        var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                        var list_type = $('#list_type option:selected').attr('value');
                        var keyWord = $('#keyWord').val();
                        if(keyWord==''){
                            X.notice('请输入关键字',3);
                        }else {
                            bindShop(tb_user_id,list_type,keyWord);
                        }
                    });
                    function bindShop(tb_user_id, list_type,keyWord) {      //淘宝用户ID   店铺状态：1仓库中 2出售中
                        $('#Allselect').prop("checked", false);
                        ko.cleanNode(document.getElementById("goodsList"));
                        $('#goodsList').html(oHtml);
                        var shopData = {
                            tb_user_id: tb_user_id,
                            list_type: list_type,
                            q:keyWord
                        };
                        //获取用户店铺商品管理列表
                        X.bindModel(requestUrl.tb_shop_list, 1, shopData, 'body.list', ['goodsList'], function () {
                            $('table tbody>tr').each(function () {
                                $(this).children('td').eq(0).append('<img style="width: 68px;height: 68px" src="' + $(this).children('td').attr('data-src') + '"/>');
                                var oo = $(this).children('td').eq(0).find('input');
                                if (oo) {
                                    oo.attr('type', 'checkbox').css({'margin': '25px 15px'})
                                }
                            });
                            shelfUp();
                            shelfDown();
                            oneUp();
                            oneDown();
                            oneDel();
                            AlldelGoods();
                        },function(res){
                            var totalPage = (res.total/res.per_page);
                            var page = 1,truettt = true;
                            $('#cont-box-body').unbind('scroll').scroll(function(){
                                if($(this).find('table').height()-$(this).scrollTop()-$('#cont-box-body').height()<=0){
                                    var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                                    var list_type = $('#list_type option:selected').attr('value');

                                    if(totalPage>page) {
                                        page++;
                                        var data={
                                            tb_user_id:tb_user_id,
                                            list_type:list_type,
                                            page:page
                                        };
                                        X.Post(requestUrl.tb_shop_list, 1, data, function (res) {
                                            var str='';
                                            $(res.body.list.item).each(function(){
                                                str+='<tr goodStatus="'+this.approve_status+'" num_iid="'+this.num_iid+'" stockNum="'+this.num+'" goods_sale="'+this.goods_sale+'">';
                                                if(this.goods_sale==2){
                                                    str+='<td id="saleStatus"><i></i><img style="width: 68px" src="'+this.pic_url+'"></td>';
                                                }else {
                                                    str+='<td id="saleStatus"><input style="margin: 25px 15px" type="checkbox"><img style="width: 68px;height: 68px" src="'+this.pic_url+'"></td>';
                                                }
                                               str+='<td>'+
                                                    '<p data-bind="text:title"></p>'+
                                                    '<p>'+'商家编码'+this.outer_id+'</p>'+
                                                    '</td>'+
                                                    '<td>'+
                                                    '<span>'+this.price+'</span>'+
                                                    '</td>'+
                                                    '<td>'+
                                                    '<p>'+this.num+'</p>'+
                                                    '</td>'+
                                                    '<td>'+
                                                    '<p>'+this.sellout_count+'</p>'+
                                                    '</td>'+
                                                    '<td><span>'+this.modified+'</td>';
                                                if(this.approve_status=='instock'){
                                                    str+='<td><span>仓库中</span></td>';
                                                }else {
                                                    str+='<td><span>出售中</span></td>';
                                                }
                                                var oo = this.approve_status=='instock'? 'oneUp':'oneDown';
                                                var ii = this.goods_sale == 1?'inline':'none';
                                                str+='<td><span style="display: '+ii+'"><a class="'+oo+'" style="color: #00a0e9" num_iid="'+this.num_iid+'" stocknum="'+this.num+'">';
                                                str+= this.approve_status=='instock'?'上架':'下架';
                                                str+='</a></span> <span><a num_iid="'+this.num_iid+'" class="oneDel" style="color: #00a0e9">删除</a></span></td>'+
                                                    '</tr>';
                                            });
                                            $('#goodsList').append(str);
                                            shelfUp();
                                            shelfDown();
                                            oneUp();
                                            oneDown();
                                            oneDel();
                                            AlldelGoods();
                                        });

                                    }else {
                                        if(truettt){X.notice('没有数据啦',3);}
                                        truettt = false;
                                    }

                                }
                            })
                        });
                    }
                    //全选操作
                    var cheakFlag = true;
                    var goodsIDs = [];
                    var stockNum = [];
                    var checkBoxs = $('#cont-box-body table td:first-child input[type=checkbox]');
                    $('#Allselect').click(function () {
                        if (cheakFlag) {
                            $('#goodsList tr td').find('input[type=checkbox]').prop("checked", true);
                            cheakFlag = false;
                        } else {
                            $('#goodsList tr td').find('input[type=checkbox]').prop("checked", false);
                            cheakFlag = true;
                        }
                    });
                    checkBoxs.click(function () {
                        if (!cheakFlag) {
                            $('#Allselect').prop("checked", false);
                            cheakFlag = true;
                        }
                    });
                    //批量上架
                    function shelfUp(){
                        $('.shelfUp').unbind('click').click(function () {
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                            var list_type = $('#list_type option:selected').attr('value');

                            goodsIDs.length = 0;
                            stockNum.length = 0;
                            $('#goodsList tr').each(function(){
                                var _this = $(this);
                                if($(this).find('input').is(':checked')){
                                    goodsIDs.push(_this.attr('num_iid'));
                                    stockNum.push(_this.attr('stocknum'));
                                }
                            });
                            if(goodsIDs.length>0){
                                if(list_type==1){
                                    X.notice('已是上架状态', 3);
                                }else {
                                    shelf(tb_user_id, goodsIDs, 1, stockNum);
                                    $('.shelfUp,.shelfDown,.delGoods').attr('disabled','disabled').css({'background':'#ccc','color':'#fff'});
                                }
                            }else {
                                X.notice('请选择要上架的商品', 3);
                            }
                        });
                    }

                    //批量下架
                    function shelfDown(){
                        $('.shelfDown').unbind('click').click(function () {
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                            var list_type = $('#list_type option:selected').attr('value');
                            goodsIDs.length = 0;
                            stockNum.length = 0;
                            $('#goodsList tr').each(function(){
                                var _this = $(this);
                                if($(this).find('input').is(':checked')){
                                    goodsIDs.push(_this.attr('num_iid'));
                                    stockNum.push(_this.attr('stocknum'));
                                }
                            });
                           if(goodsIDs.length>0){
                               if(list_type==2){
                                   X.notice('已是下架状态', 3);
                               }else {
                                   shelf(tb_user_id, goodsIDs, 0, stockNum);
                                   $('.shelfUp,.shelfDown,.delGoods').attr('disabled','disabled').css({'background':'#ccc','color':'#fff'});
                               }
                           }else {
                               X.notice('请选择要下架的商品', 3);
                           }
                        });
                    }

                    //单个上架
                    function oneUp(){
                        $('.oneUp').click(function () {
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                            goodsIDs.length = 0;
                            stockNum.length = 0;
                            goodsIDs.push($(this).attr('num_iid'));
                            stockNum.push($(this).attr('stocknum'));
                            $('.shelfUp,.shelfDown,.delGoods').attr('disabled','disabled').css({'background':'#ccc','color':'#fff'});
                            shelf(tb_user_id, goodsIDs, 1, stockNum);
                        });
                    }

                    //单个下架
                    function oneDown(){
                        $('.oneDown').click(function(){
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                            goodsIDs.length = 0;
                            stockNum.length = 0;
                            goodsIDs.push($(this).attr('num_iid'));
                            stockNum.push($(this).attr('stocknum'));
                            $('.shelfUp,.shelfDown,.delGoods').attr('disabled','disabled').css({'background':'#ccc','color':'#fff'});
                            shelf(tb_user_id,goodsIDs,0,stockNum);
                        });
                    }

                    //店铺商品上下架
                    function shelf(tb_user_id,goodsIDs,opt,stockNum){
                        var goodsStr = goodsIDs.join(',');
                        var stockStr = stockNum.join(',');
                        var msg = '';
                        var shelfUpdata= {
                            tb_user_id:tb_user_id,
                            opt:opt,
                            num_iid:goodsStr,
                            num:stockStr
                        };
                        if(opt==1){
                            msg='上架成功';
                        }else {
                            msg='下架成功';
                        }
                        X.Post(requestUrl.tb_shelf,1,shelfUpdata,function(res){
                            if(res.header.stats==0){
                                if(res.body.list.sucess){
                                    $('.shelfUp,.shelfDown,.delGoods').removeAttr('disabled','disabled');
                                    $('.shelfUp').css('background','#F22D00');
                                    $('.shelfDown,.delGoods').css({'background':'#fff','color':'#333'});

                                    X.notice(msg,3);
                                    $(goodsIDs).each(function(){
                                        var _this = this;
                                        $('#cont-box-body table tbody tr').each(function(){
                                            var ids = $(this).attr('num_iid');
                                            if(_this == ids){
                                                $(this).remove();
                                            }
                                        });
                                    })
                                }
                            }else {
                                X.notice(res.header.msg,3);
                            }
                        })
                    }
                    //批量删除
                    function AlldelGoods(){
                        $('.delGoods').unbind('click').click(function(){
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                                goodsIDs.length = 0;
                                $('#goodsList tr').each(function(){
                                    var _this = $(this);
                                    if($(this).find('input').is(':checked')){
                                        goodsIDs.push(_this.attr('num_iid'));
                                    }
                                });
                                if(goodsIDs.length>0){
                                    delGoods(tb_user_id,goodsIDs);
                                    $('.shelfUp,.shelfDown,.delGoods').attr('disabled','disabled').css({'background':'#ccc','color':'#fff'});
                                }else {
                                    X.notice('请选择要删除的商品', 3);
                                }
                        });
                    }

                    //单个删除
                    function oneDel(){
                        $('.oneDel').click(function(){
                            var tb_user_id = $('#shopList option:selected').attr('tb_user_id');
                            goodsIDs.length = 0;
                            goodsIDs.push($(this).attr('num_iid'));
                            delGoods(tb_user_id,goodsIDs);
                        });
                    }

                    //删除商品请求
                    function delGoods(tb_user_id,goodsIDs){
                        var goodsStr = goodsIDs.join(',');
                        var delGoods = {
                            tb_user_id:tb_user_id,
                            num_iid:goodsStr
                        };
                        X.Post(requestUrl.tb_godos_delete,1,delGoods,function(res){
                            if(res.header.stats==0){
                                if(res.body.list.sucess){
                                    $('.shelfUp,.shelfDown,.delGoods').removeAttr('disabled','disabled');
                                    $('.shelfUp').css('background','#F22D00');
                                    $('.shelfDown,.delGoods').css({'background':'#fff','color':'#333'});

                                    X.notice('删除成功',3);
                                    $(goodsIDs).each(function(){
                                        var _this = this;
                                        $('#cont-box-body table tbody tr').each(function(){
                                            var ids = $(this).attr('num_iid');
                                            if(_this == ids){
                                                $(this).remove();
                                            }
                                        });
                                    })
                                }
                            }else {
                                X.notice(res.header.msg,3);
                            }
                        })
                    }
                }
            }
        });




    </script>
</html>