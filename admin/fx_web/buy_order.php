<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <!-- 设置360浏览器渲染模式,webkit 为极速内核，ie-comp 为 IE 兼容内核，ie-stand 为 IE 标准内核。 -->
        <meta name="renderer" content="webkit">
        <meta name="google" value="notranslate"><!-- 禁止Chrome 浏览器中自动提示翻译 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta http-equiv="Cache-Control" content="no-siteapp" /><!-- 禁止百度转码 -->
        <meta name="Description" content=""/>
        <meta name="Keywords" content=""/>
        <meta name="author" content="">
        <meta name="Copyright" content="" />
        <title>创想范分销平台--购买商品</title>
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="stylesheet" type="text/css" href="css/buy_orders.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/jquery.cookie-1.4.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/plus.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
    </head>
    <body>
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
        </div>
        <div class="g-top">
            <div class="order-stepbar clearfix">
                <h1 class="buy-logo">
                    <a href="index.php" target="_blank" title=""><img src="images/goodsDetails/logo.png"/></a>
                </h1>
                <ol class="tb-stepbar">
                    <div class="s-line">
                        <p class="s-line-y"></p>
                    </div>
                    <li class="stepbar stepbar-current">
                        <p class="s-circle">1</p>
                        <p class="stepbar-name">填写核对订单</p>        
                    </li>
                    <li class="stepbar">
                        <p class="s-circle">2</p>
                        <p class="stepbar-name">提交订单</p>
                    </li>
                    <li class="">
                        <p class="s-circle">3</p>
                        <p class="stepbar-name">订单付款</p>
                    </li>
                    <li class="">
                        <p class="s-circle">4</p>
                        <p class="stepbar-name">等待发货</p>
                    </li>
                    <li class="stepbar-last">
                        <p class="s-circle"><i></i></p>
                        <p class="stepbar-name">确认收货</p>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wraper">
            <h2>核对订单信息</h2>
            <div class="g-orderInfor" id="buy_order">
                <div class="order-box g-address">
                    <h3>填写收货人信息</h3>
                    <div class="m-address clearfix">
                        <div class="form-group form-name">
                            <label>第三方平台:</label>
                            <select class="other_shop">
                                <option>淘宝单号</option>
                                <option>微信单号</option>
                                <option>其他平台单号</option>
                            </select>
                            <input type="text" class="input-xs other_order_sn" id="input_accept">
                        </div>
                        <div class="form-group form-name">
                            <label>收货人:</label>
                            <input type="text" class="input-xs contact_name" id="input_accept">
                        </div>
                        <div class="form-group">
                            <label>手机号:</label>
                            <input type="text" class="input-xs tel" id="phone">
                        </div>
                        <div class="form-group">
                            <label>收货地址:</label>
                            <select id="seleProvince" onchange="getCity(this.value)">
                                <option value="">省</option>
                            </select>
                            <select id="seleCity" onchange="getCounty(this.value)">
<!--                                <option value=""></option>-->
                            </select>
                            <select id="seleCounty" onchange="setCountyCode(this.value)">
<!--                                <option value=""></option>-->
                            </select>
                            <input type="hidden" name="su.companySxy" value="">
                            <input type="hidden" name="su.companyCode" value="">
<!--                            <select name="province" id="province"></select>-->
<!--                            <select name="city" id="city"></select>-->
<!--                            <select name="area" id="area"></select>-->
                        </div>
                        <div class="form-group form-address">
                            <label>详细地址:</label>
                            <input type="text" class="input-xs contact_address" id="minute_adress">
                        </div>
                    </div>
                </div>
                <div class="order-box g-goodsMes">
                    <h3>确认商品信息</h3>
                    <div class="m-table">
                        <ul class="table-header clearfix">
                            <li style="width:112px">主图</li>
                            <li style="width:256px">标题</li>
                            <li style="width:154px">SKU属性</li>
                            <li style="width:320px">单价</li>
                            <li style="width:140px">数量</li>
                            <li style="width:152px">小计</li>
                        </ul>
                        <table class="table table-hover" id="goodsInfos">
                            <tbody>								
                                <tr>
                                    <th  width="96"><img  style="width: 100%" data-bind="attr:{src:img_path}"/></th>
                                    <th width="256" data-bind="text:goods_name"></th>
                                    <th width="154" class="s-SKU" data-bind="foreach:{data:sku_str_zh,as:'auto'}">
                            <p data-bind="text:name"></p>
                            </th>
                            <th width="330" class="unit-price" data-bind="text:distribution_price"></th>
                            <th width="140" class="s-num"><div class="s-num-i clearfix"><input type="button" class="e-reduce" value="-"><input class="s-p-num" type="text" id="goodsNum" data-bind="value:goodsNum" value=""><input class="e-add" type="button" value="+"></div></th>
                            <th class="s-subtotal"></th>
                            </tr>
                            </tbody>	
                        </table>
                    </div>
                    <div class="m-settle clearfix">
                        <div class="leave-message clearfix">
                            <label>给卖家留言:</label>
                            <textarea type="text" class="input-xs message"></textarea>
                        </div>
                        <div class="m-tolSubmit">
                            <dl>
                                <dt>商品总数:</dt>
                                <dd class="t-total-num"><span class="m-tol-num">4</span><span class="col-balck">件</span></dd>
                            </dl>
                            <dl>
                                <dt>总商品金额:</dt>
                                <dd>¥<span class="m-tol-price">589.00</span></dd>
                            </dl>
                            <dl>
                                <dt>运费:</dt>
                                <dd>¥<span class="m-tol-freight" id="freight">0.00</span></dd>
                            </dl>
                            <dl>
                                <dt>应付金额:</dt>
                                <dd class="t-total-price">¥<span class="m-tol-amount">597.00</span></dd>
                            </dl>
                            <p><button id="buy_order_submit">提交订单</button></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>			
        <!--footer-->

        <?php
          include_once 'base/index_footer.php';
        ?>
    </body>
    <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/Add.js"></script>
    <script type="text/javascript">
        $(function ($) {

            $('.e-add').on('click', function () {
                var num = parseInt($('#goodsNum').val());
                if(num>=getGoodsInfo.stock_num){
                    X.notice('库存不足',3);
                }else {
                    $('#goodsNum').val(num+1);
                }
                updateDate();
            });
            $('.e-reduce').on('click', function () {
                var q = $(this).parent();
                q.find('.s-p-num').val() <= 1 ? 1 : q.find('.s-p-num').val(parseInt(q.find('.s-p-num').val()) - 1);
                updateDate();
            });
            $('.s-p-num').on('blur', function () {
                var num = parseInt($('#goodsNum').val());
                if(num<=1){
                    $('#goodsNum').val(1);
                    X.notice('购买数量不能小于1',3)
                }else if(num>=getGoodsInfo.stock_num){
                    X.notice('库存不足',3);
                }else {
                    updateDate();
                }
            });
            function updateDate() {
                var p = 0, n = 0;
                $('.table>tbody>tr').each(function () {
                    var s = $(this).find('.s-subtotal');
                    s.html(($(this).find('.unit-price').text() * parseInt($(this).find('.s-p-num').val())).toFixed(2));
                    p += parseFloat(s.html());
                    n += parseFloat($(this).find('.s-p-num').val());
                });
                $('.m-tolSubmit .m-tol-num').html(n);
                $('.m-tolSubmit .m-tol-price').html(p.toFixed(2));
//				$('.m-tolSubmit .m-tol-freight').html(p);   //运费
                $('.m-tolSubmit .m-tol-amount').html((parseFloat($('.m-tolSubmit .m-tol-price').html()) + parseFloat($('.m-tolSubmit .m-tol-freight').html())).toFixed(2));
            }
            updateDate();
        });
    </script>
    <!--地址-->
    <script type="text/javascript">
        var addflag = false;
        $('.s-line-y').animate({'width': 256 + 'px'}, 600);
        var getGoodsInfo = JSON.parse(sessionStorage.getItem('goodsInfo'));
        console.log(getGoodsInfo);
        var goodsInfo = {
            user_id: sessionStorage.getItem('user_id'), //用户ID
            user_name: sessionStorage.getItem('user_name'), //用户名
            goodsID: getGoodsInfo.goodsID, //商品ID
            goods_sku_id: getGoodsInfo.goods_sku_id, //商品SKU
            goodsNum: getGoodsInfo.goodsNum, //商品数量
            sku_str_zh: getGoodsInfo.sku_str_zh, //商品属性
            goods_name: getGoodsInfo.goods_name, //商品名
            img_path: getGoodsInfo.img_path, //商品图片地址
            distribution_price: getGoodsInfo.distribution_price,     //商品单价
            stock_num:getGoodsInfo.stock_num //库存
        };
        var arr = [];
        var a = goodsInfo.sku_str_zh.split(';');
        var b = a.pop();
        for (var i in a) {
            arr.push({'name': a[i]})
        }
        goodsInfo.sku_str_zh = arr;
        ko.applyBindings(goodsInfo,document.getElementById('goodsInfos'));

        $('#buy_order_submit').click(function () {
            var goodsNum = $('#goodsNum').val();
            var data = {
                user_id: getCookieValue('user_id'), //用户ID
                user_name: getCookieValue('user_account'), //用户名
                goods_id: goodsInfo.goodsID, //商品ID
                goods_sku_id: goodsInfo.goods_sku_id, //Sku ID
                goods_count: goodsNum, //购买数量
                other_shop: $('.other_shop option:selected').val(), //第三方平台
                other_order_sn: $('.other_order_sn').val(), //第三方订单号
                contact_name: $('.contact_name').val(), //收货人
                tel: $('.tel').val(), //收货人联系电话
                province: $('#seleProvince option:selected').text(), //省
                city: $('#seleCity option:selected').text(), //市
                dist: $('#seleCounty option:selected').text(), //区
                contact_address: $('.contact_address').val(), //收货人详细地址
                message: $('.message').val(),                     //留言信息
                receiver_address:goodsInfo.receiver_address,   //收货地区编码
                platform:platform                                 //平台来源
        };
            var reg = /^1[3456789]\d{9}$/;
            if (data.contact_name == '') {
                X.notice('收货人姓名未填写', 3);
            } else if (data.tel == '') {
                X.notice('收货人联系方式未填写', 3);
            } else if (!reg.test(data.tel)) {
                X.notice('联系方式输入错误', 3);
            }else {
                if(addflag){
                    if(data.contact_address==''){
                        X.notice('请填写详细的收货地址',3);
                    }else {
                        X.Post(requestUrl.add_order, 1, data, function (res) {
                            if (res.header.stats == 0) {
                                var loca = res.body.list;
                                var buyOrder = {
                                    order: loca.order_id,
                                    orderSn: loca.order_sn,
                                    pay_amount: loca.pay_amount
                                };
                                sessionStorage.setItem('orderInfo', JSON.stringify(buyOrder));
                                window.location.href = 'pay_order.php';
                            } else {
                                X.notice(res.header.msg, 3);
                            }
                        })
                    }
                }else {
                    X.notice('请选择收货地址',3);
                }
            }
        });
    </script>

    <script type="text/javascript">
        /*  select显示标题*/
        var opt0 = new Array("--省--","--市--","--区--");
        /*字符串连接 符*/
        var concatStr = "";
        /*获取所有省*/
        function getProvince()
        {
            $("input[name='su.companyCountyCode']").val("");
            $("input[name='su.companySxy']").val("");
            var seleProvince = $("#seleProvince");
            seleProvince.empty();
            seleProvince.append("<option value=''>"+opt0[0]+"</option>");
            $("#seleCity").empty();
            $("#seleCity").append("<option value=''>"+opt0[1]+"</option>");
            $("#seleCounty").empty();
            $("#seleCounty").append("<option value=''>"+opt0[2]+"</option>");
            for(var x = 0; x < areaJson.length;x++)
            {
                seleProvince.append("<option value='"+areaJson[x].areaId+"'>"+areaJson[x].areaName+"</option>");
            }
        }
        /*获取所有市*/
        function getCity(areaId)
        {
            $("input[name='su.companyCountyCode']").val("");
            $("input[name='su.companySxy']").val("");
            var seleCity = $("#seleCity");
            seleCity.empty();
            seleCity.append("<option value=''>"+opt0[1]+"</option>");
            $("#seleCounty").empty();
            $("#seleCounty").append("<option value=''>"+opt0[2]+"</option>");
            if(areaId!="")
                for(var x = 0; x < areaJson.length;x++)
                {
                    var areaIdTemp = areaJson[x].areaId;
                    if(areaIdTemp == areaId)
                    {
                        //如果没有市，则将当前省做为最后一级
                        if(areaJson[x].aearList == null || areaJson[x].aearList.length==0)
                        {
                            $("input[name='su.companyCountyCode']").val(areaId);
                            $("input[name='su.companySxy']").val(areaJson[x].areaName);
                            $('#AddInp').val(areaJson[x].areaName);
                            $('#AddInp').attr('title',areaJson[x].areaName);
                            $("input[name='su.companyCode']").val(areaJson[x].areaId);
                            addflag = true;
                            freight(areaJson[x].areaId);
                        }else{
                            for(var y = 0; y < areaJson[x].aearList.length; y++)
                            {
                                seleCity.append("<option value='"+areaJson[x].aearList[y].areaId+"'>"+areaJson[x].aearList[y].areaName+"</option>");
                            }
                            addflag = false;
                        }
                        break;
                    }
                }
        }
        /*根据省和市获取县*/
        function getCounty(cityId)
        {
            $("input[name='su.companyCountyCode']").val("");
            $("input[name='su.companySxy']").val("");
            var proId = $("#seleProvince").val();
            var seleCounty = $("#seleCounty");
            seleCounty.empty();
            seleCounty.append("<option value=''>"+opt0[2]+"</option>");
            if(cityId!="")
                for(var x = 0; x < areaJson.length;x++)
                {
                    if(areaJson[x].areaId == proId)
                    {
                        for(var y = 0; y < areaJson[x].aearList.length; y++)
                        {
                            if(cityId==areaJson[x].aearList[y].areaId)
                            {
                                //如果没有县了，则将当前市做为最后一级
                                if(areaJson[x].aearList[y].aearList == null || areaJson[x].aearList[y].aearList.length==0)
                                {
                                    $("input[name='su.companyCountyCode']").val(cityId);
                                    $("input[name='su.companySxy']").val(areaJson[x].areaName+concatStr+areaJson[x].aearList[y].areaName);
                                    $('#AddInp').val(areaJson[x].areaName+concatStr+areaJson[x].aearList[y].areaName);
                                    $('#AddInp').attr('title',areaJson[x].areaName+concatStr+areaJson[x].aearList[y].areaName);
                                    $("input[name='su.companyCode']").val(areaJson[x].areaId+areaJson[x].aearList[y].areaId);
                                    addflag = true;
                                    freight(areaJson[x].areaId+areaJson[x].aearList[y].areaId);
                                }else{
                                    for(var h = 0; h < areaJson[x].aearList[y].aearList.length; h++)
                                    {
                                        seleCounty.append("<option value='"+areaJson[x].aearList[y].aearList[h].areaId+"'>"+areaJson[x].aearList[y].aearList[h].areaName+"</option>");
                                    }
                                    addflag = false;
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
        }
        /*选择县后  赋值  编号和拼接地址信息*/
        function setCountyCode(areaId)
        {
            addflag = true;
            $("input[name='su.companyCountyCode']").val(areaId);
            var spr = $("select[id='seleProvince'] > option[value='"+$("#seleProvince").val()+"']").text();
            var sci = $("select[id='seleCity'] > option[value='"+$("#seleCity").val()+"']").text();
            var sco = $("select[id='seleCounty'] > option[value='"+areaId+"']").text();
//        var sprCode = $("select[id='seleProvince'] > option:selected").val();
//        var sciCode = $("select[id='seleCity'] > option:selected").val();
            var scoCode = $("select[id='seleCounty'] > option:selected").val();


            $("input[name='su.companySxy']").val(spr+concatStr+sci+concatStr+sco);
            $("input[name='su.companyCode']").val(scoCode);
            $('#AddInp').val(spr+concatStr+sci+concatStr+sco);
            $('#AddInp').attr('title',spr+concatStr+sci+concatStr+sco);

            freight(scoCode);
        }

        /*初始化加载所有省份*/
        $(document).ready(function(){
            getProvince();
        });

        //查询运费接口
        function freight(areaId){
            var data = {
                send_address:440100,
                receiver_address:areaId,
                goods_id:getGoodsInfo.goodsID
            };
            X.Post(requestUrl.get_freight, 1, data, function (res) {
                if(res.header.stats==0){
                    goodsInfo.freight = res.body.list.freight;
                    goodsInfo.receiver_address = areaId;
                    $('#freight').text((res.body.list.freight).toFixed(2));
                }else {
                    X.notice(res.header.msg,3)
                }
            })
        }
    </script>
</html>

