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
        <title>创想范分销平台--商品详情</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsDetails.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsList.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/cloudzoom.js"></script>
        <script src="js/public.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/plus.js"></script>
    </head>
    <body>
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
            <?php include_once 'base/index_top_1.php'; ?>
        </div>

        <div class="wrap clearfix">
            <div class="sidebarLeft">

            </div>
            <div class="g-details" id="g-details">
                <div class="details-top clearfix">
                    <div class="g-dpic">
                        <div class="m-dpic-b">
                            <img class="cloudzoom" id="maxImgSrc"  data-bind="attr:{src:detail.img_path,alt:detail.goods_name}" />
                        </div>
                        <div class="m-picControl clearfix">
                            <div class="m-picC-icon" style="float: left"><</div>
                            <div class="m-picC-ul" style="width: 380px;height: 70px;overflow: hidden">
                                <ul class="clearfix e-cloudpic" data-bind="foreach:{data:detail.useZoom,as:'auto'}" style="margin: 0 auto;height: 70px;overflow: hidden">
                                    <li><img class="cloudzoom-gallery" data-bind="attr:{src:img,'data-cloudzoom':zoom}"  width="60" height="60" data-cloudzoom="useZoom: '.cloudzoom', image: '', zoomImage: ''"/></li>
                                </ul>
                            </div>
                            <div class="m-picC-icon" style="float: right">></div>
                        </div>
                    </div>
                    <div class="g-dmes">
                        <div class="m-dtitle">
                            <p><label class="fontS20" data-bind="text:detail.goods_name"></label> </p>
                            <p>商家编码：<label class="fontS12" data-bind="text:detail.buyer_goods_no"></label></p>
                        </div>
                        <div class="m-inPrice m-inP">
                            <dl>
                                <dt>零售价：</dt>
                                <dd><label id="jichujiao" data-bind="text:'¥ '+detail.price.distribution_price"></label></dd>
                            </dl>
                            <dl>
                                <dt>基础价：</dt>
                                <dd class="s-price"><label id="jichujiao" data-bind="text:'¥ '+detail.price.basic_price"></label></dd>
                            </dl>
                            <dl>
                                <dt>中级价：</dt>
                                <dd id="zhongjijia" data-bind="text:'¥ '+detail.price.middle_price"></dd>
                            </dl>
                            <dl>
                                <dt>高级价：</dt>
                                <dd id="gaojijia" data-bind="text:'¥ '+detail.price.senior_price"></dd>
                            </dl>
                            <dl class="s-freight">
                                <dt>运&nbsp;&nbsp;费：</dt>
                                <dd class="clearfix" class="ncs-freight_box" style="position: relative">
                                    <div>广东广州  至 </div>

                                    <input type="text" id="AddInp" style="width: 80px" value="" placeholder="选择地址" readonly>
                                    <div id="hideDiv">
                                        <select id="seleProvince" onchange="getCity(this.value)">
                                            <option value="">省</option>
                                        </select>
                                        <select id="seleCity" onchange="getCounty(this.value)">
                                            <option value="">市</option>
                                        </select>
                                        <select id="seleCounty" onchange="setCountyCode(this.value)">
                                            <option value="">县</option>
                                        </select>
                                        <input type="hidden" name="su.companySxy" value="">
                                        <input type="hidden" name="su.companyCode" value="">
                                    </div>

                                    <div>费用 ：<span id="yunfei">¥0.00</span></div>
                                </dd>
                            </dl>
                        </div>
                        <div class="m-intype m-inP" >
                            <dl>
                                <dt>数&nbsp; &nbsp;&nbsp;&nbsp;量&nbsp; :</dt>
                                <dd>
                                    <div class="s-figure-input">
                                        <input type="text" name="" id="goodsNum" value="1" size="3" maxlength="6" class="input-text">
                                        <a href="javascript:void(0)" class="increase e-fig-add">+</a>
                                        <a href="javascript:void(0)" class="decrease e-fig-reduce">-</a>
                                    </div>
                                    <span>
                                        库存：<label id="stockNum" data-bind="text:detail.stock_num"></label>
                                    </span>
                                </dd>
                            </dl>
                            <dl class="m-btnFunc">
                                <dd style="text-align: center">
                                    <div style="display: none">
                                        <form id="download_from">
                                            <input type="text" name="goods_ids" value="">
                                        </form>
                                    </div>
                                    <a href="javascript:void(0);" class="buynow m-btn" id="exportCsv" title="导出csv数据包">导出csv数据包</a>
                                    <a href="javascript:void(0);" class="m-btn" id="yijianpuhuo" title="一键铺货">一键铺货</a>
                                    <a href="javascript:void(0);" class="buynow m-btn" id="lijigoumai" title="立即购买">立即购买</a>
                                </dd>
                            </dl>
                            <dl class="m-service">
                                <dt>服&nbsp;&nbsp;务：</dt>
                                <dd>
                                    <span>7</span> 7天无理由
                                </dd>
                            </dl>
                            <dl>
                                <dt>分&nbsp;&nbsp;享：</dt>
                                <dd class="m-share">				
                                    <a href="javascript:void(0);" class="weixin"><img src="images/goodsDetails/weixin.jpg"/></a>
                                    <a href="javascript:void(0);" class="weibo"><img src="images/goodsDetails/weibo.jpg"/></a>
                                    <span class="s-collect"><a href="javascript:void(0);"><i><img src="images/goodsDetails/star.png"/></i><span data-bind="text:detail.is_collect==true?'已收藏':'收藏',css:{addKeep:detail.is_collect==false,delKeep:detail.is_collect==true}"></span><span class="collect_countNum" data-bind="text:' '+detail.collect_count"></span></a></span>
                                </dd>
                            </dl>
                        </div>	
                    </div>
                </div>	
                <div class="details-info">
                    <h3><span>商品详情</span></h3>
                    <div id="goodsDetailDiv" data-bind="html:detail.desc"></div>
                </div>
            </div>

            <div class="g-recommen">

                <div class="high-quality" id="high-quality">
                    <h3>精品质量</h3>

                    <div class="hqua-pic" data-bind="foreach:{data:most_goods,as:'auto'}">
                        <div class="hq-picBox" >
                            <a data-bind="attr:{href:'good_detail.php?goodsID='+goods_id+''}"><img data-bind="attr:{src:img_path,alt:goods_name,goodsId:goods_id}"/></a>
                        </div>
                    </div>

                    <div class="hq-picBox">
                        <img src="images/goodsDetails/freight.jpg"/>
                        <div class="freight-announ">
                            <p>包邮地区: 北京 江苏 浙江 上海 安徽广东 福建 湖北 山东 山西 江西 河北。</p>
                            <p>5元邮费区域: 云南 海南 贵州 陕西 广西 四川 河南。</p>
                            <p>8元邮费区域: 内蒙古 青海 吉林 辽宁黑龙江 宁夏 甘肃。 新疆、西藏等地需20元邮费。</p>
                        </div>		
                    </div>
                </div>

                <div class="g-ranking">
                    <div class="rank-title e-rank">
                        <a class="select">收藏排行</a>
                        <a>分销排行</a>
                    </div>
                    <div class="rank-content">
                        <ul class="rank-cUi" id="keep_good_list" style="display: block" data-bind="foreach:{data:keep_good_list,as:'auto'}">
                            <li class="" data-bind="css:{'rank-one':$index()==0,'rank-two':$index()==1,'rank-three':$index()==2}">
                                <a data-bind="attr:{href:'good_detail.php?goodsID='+goods_id+''}" class="rank-c-a">
                                    <div class="clearfix">
                                        <div class="rank-pic">
                                            <img data-bind="attr:{src:img_path,alt:goods_name,goodsId:goods_id,price:price}"/>
                                        </div>
                                        <div class="rank-mes">
                                            <p class="p-ranking"><i></i><span data-bind="text:'Top'+($index()+1)"></span></p>
                                            <p class="p-price">￥<span data-bind="text:price"></span></p>
                                            <p class="p-collect" data-bind="attr:{goodsID:goods_id}"><i></i>收藏</p>
                                        </div>
                                    </div>
                                    <p data-bind="text:goods_name"></p>
                                </a>
                            </li>
                        </ul>

                        <ul class="rank-cUi" id="up_taobao_goodlist" data-bind="foreach:{data:up_taobao_goodlist,as:'auto'}">
                            <li class="rank-one" data-bind="css:{'rank-one':$index()==0,'rank-two':$index()==1,'rank-three':$index()==2}">
                                <a  data-bind="attr:{href:'good_detail.php?goodsID='+goods_id+''}" class="rank-c-a">
                                    <div class="clearfix">
                                        <div class="rank-pic">
                                            <img data-bind="attr:{src:img_path,alt:goods_name,goodsId:goods_id,price:price}"/>
                                        </div>
                                        <div class="rank-mes">
                                            <p class="p-ranking"><i></i><span data-bind="text:'Top'+($index()+1)"></span></p>
                                            <p class="p-price">￥<span data-bind="text:price"></span></p>
                                            <p class="p-collect" data-bind="attr:{goodsID:goods_id}"><i></i>收藏</p>
                                        </div>
                                    </div>
                                    <p data-bind="text:goods_name"></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>			
            </div>
        </div>
        <!--footer-->
        <?php
        include_once 'base/index_footer.php';
        include_once 'base/index_footer_blackdiv.php';
        include_once 'base/index_footer_kefu.php';
        ?>

        <!--弹窗-->
        <div class="marks" id="PH">
            <div class="PopDiv">
                <div class="PopHeader">
                    <img src="images/PopIco/tips.png" alt="">
                    <span class="PopTitle">铺货</span>
                    <div class="PopColse"></div>
                </div>
                <div class="PopBody">
                    <div class="Phcontent">
                        <p>铺货详情：<span>以下商品将发布到您当前的默认店铺：</span><select id="shopList"></select></p>
                        <div class="PhTab">
                            <table>
                                <tr>
                                    <th>商品ID</th>
                                    <th>商家编码</th>
                                    <th>商品标题</th>
                                    <th>铺货结果</th>
                                </tr>
                                <tr>
                                    <td data-bind="text:goodsID"></td>
                                    <td data-bind="text:buyer_goods_no"></td>
                                    <td data-bind="text:goods_name"></td>
                                    <td>等待铺货</td>
                                </tr>
                            </table>
                        </div>
                        <div class="Phsele">
                            <table>
                                <tr>
                                    <td>快递选项：</td>
                                    <td><label><input type="radio" checked name="PhMailType" value="0">包邮</label></td>
                                    <td style="text-align: right">商品分类：<select id="goodsType"></select></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">
                                        <label><input type="radio" name="PhMailType" value="1">买家承担运费</label>运费统一设置为：<input type="text" placeholder="运费金额" id="freight_fee"> 元
                                        <span>买家承担运费的范围为0.001~999.00</span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2"><label><input type="radio" name="PhMailType" value="2">使用卖家运费模板</label><select id="shopTemplate"></select><span>必须选择一个模板，如果没有请至淘宝添加</span></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="PhJD">
                            <p><i></i></p>
                            <span>完成度：0/1</span>
                        </div>
                    </div>
                </div>
                <div class="PopFooter">
                    <button class="startBtn">开始铺货</button>
                </div>
            </div>
        </div>
    </body>

</html>


<script>
    $(function () {
        $('.e-rank>a').on('click', function () {
            var oThis = $(this).index();
            if (oThis == 0) {
                $('.rank-title').css('background', 'url(images/goodsDetails/ranking01.jpg)');
            } else {
                $('.rank-title').css('background', 'url(images/goodsDetails/ranking02.jpg)')
            }
            $(this).addClass('select').siblings().removeClass('select');
            $('.rank-cUi').eq(oThis).show().siblings().hide();
        });




        //左侧下拉菜单
        $('.sidebarMax').on('click', '.goodsTypeName', function () {
            $(this).prevAll('.goodsTypeName').next('ul').slideUp(function () {
                $(this).removeClass('menuActive')
            }).end().find('i').css({'transform': 'rotate(-90deg)'});
            $(this).nextAll('.goodsTypeName').next('ul').slideUp(function () {
                $(this).removeClass('menuActive')
            }).end().find('i').css({'transform': 'rotate(-90deg)'});
            $(this).next('ul').slideDown(function () {
                $(this).addClass('menuActive')
            }).end().find('i').css({'transform': 'rotate(0deg)'});
        });


        X.bindModel(requestUrl.category, 0,{} ,'',['category'], function () {
            $('.e-tab').find('.classify-body').hover(function () {
                var _index = $(this).index();
                $('.tab-box .menu-tab').eq(_index).addClass('current').siblings().removeClass('current');
            }, function () {
                $('.tab-box .menu-tab').removeClass('current');
            });
            $('.menu-tab').hover(function () {
                $(this).addClass('current').siblings().removeClass('current');
            }, function () {
                $(".menu-tab").removeClass('current');
            });
        }, function (x) {
            x = {'category': x};
            return  x;
        });

    })
</script>
<script>
//    var userID = getCookieValue('user_id')
    var goodsID = getUrlParam('goodsID');
    var data = {'goods_id':goodsID,'user_id':getCookieValue('user_id'),'platform': 1};
    X.bindModel(requestUrl.goodsDetail, 1, data, 'body.list', ['g-details', 'high-quality', 'keep_good_list', 'up_taobao_goodlist'], function () {
        jQuery(function ($) {
            // 放大镜效果 产品图片
            CloudZoom.quickStart();
            // 图片切换效果
            $(".e-cloudpic li").first().addClass('current');
            $('.e-cloudpic').find('li').mouseover(function () {
                $(this).addClass("current").siblings().removeClass("current");
            });
        });
        //添加收藏
        $('.addKeep').click(function(){
            var _this = $(this);
           addKeep(goodsID,function(e){
               var num = parseInt($('.collect_countNum').text());
               if(e){
                   $('.collect_countNum').text(' '+(num+1));
                   _this.removeClass('addKeep').addClass('delKeep');
               }else {
                   $('.collect_countNum').text(' '+num);
               }
               _this.text('已收藏');
           });
        });
        //取消收藏
        $('.delKeep').click(function(){
            var _this = $(this);
            delKeep(goodsID,function(e){
                var num = parseInt($('.collect_countNum').text());
                if(e){
                    $('.collect_countNum').text(' '+(num-1));
                    _this.removeClass('delKeep').addClass('addKeep');
                }else {
                    $('.collect_countNum').text(' '+num);
                }
                _this.text('收藏');
            });
        })
    }, function (res) {
        var res = {'body': {'list': res}};
        var goods_stock_num = res.body.list.detail.stock_num;   //商品总库存
        var str = '';
        var arr = res.body.list.sku;
        var i=0;
        $(res.body.list.sku_list).each(function(key,val){
                  str += '<dl class="skuSign dls"><dt>' + arr[val].name + '：</dt>' +
                      '<dd>' +
                      '<ul class="ul_sign s-size clearfix" sku_val_str="'+val+'">';
                   for( var j in arr[val].val){
                       str += '<li sku_val="' + j + '" >' +arr[val].val[j] +'</li>';
                   }
                  str += '</ul>' +
                      '</dd>' +
                      '</dl>';
        });
        $('.m-intype').prepend(str);
        $('.e-fig-add').on('click', function () {
            if(parseInt($('.s-figure-input .input-text').val())>=parseInt($('#stockNum').text())){
                X.notice('商品库存不足',3);
            }else {
                $('.s-figure-input .input-text').val(parseInt($('.s-figure-input .input-text').val()) + 1);
            }
        });
        $('.e-fig-reduce').on('click', function () {
            $('.s-figure-input .input-text').val() == 0 ? 0 : $('.s-figure-input .input-text').val($('.s-figure-input .input-text').val() - 1)
        });
        //显示隐藏地区
        var slideFlag = true;
        $('#AddInp').val('');
        $('#AddInp').click(function(){
            if(slideFlag){
                $('#hideDiv').slideDown();
                slideFlag=false
            }else {
                $('#hideDiv').slideUp();
                slideFlag=true;
            }
        });
        var dataInfo = {
            goods_id:goodsID
        };
        var goodsStu={
            stuVal:'',
            stuvalstr:'',
            goodsID:res.body.list.detail.goods_id
        };
        var skuInfo = {};
        $('.dls').each(function(key,item){
            $(this).find('li').click(function(){
                var skuVal = $(this).attr('sku_val');
                var skuStr = $(this).parent('ul').attr('sku_val_str');
                skuInfo[key] = skuStr+':'+skuVal;
                var oo = '';
                for(var x in skuInfo){
                    oo  += skuInfo[x]+';'
                }
                skuinfo({goods_id:goodsStu.goodsID,sku_str:oo});
                $(this).addClass('select').siblings().removeClass('select');
            })
        });
        function skuinfo(data) {
            X.bindModel(requestUrl.sku_info, 1, data, 'body.list', [], function () {
            }, function (res) {
                var res = {'body': {'list': res}};
                if (res.body.list.sku_info) {
                    $('#stockNum').text(res.body.list.sku_info.stock_num);
                    $('#jichujia').text('¥ ' + res.body.list.sku_info.price.basic_price);
                    $('#zhongjijia').text('¥ ' + res.body.list.sku_info.price.middle_price);
                    $('#gaojijia').text('¥ ' + res.body.list.sku_info.price.senior_price);
                    dataInfo.stock_lock_num = res.body.list.sku_info.stock_lock_num;
                    dataInfo.stock_num = res.body.list.sku_info.stock_num;

                    dataInfo.skuId = res.body.list.sku_info.id;
                }
            })
        }
//        导出CSV数据包
        $('#exportCsv').click(function(){
            CheckUserLogin();
            $('#download_from').attr({'action':requestUrl.downloadcsv,'method':'post'});
            $('input[name=goods_ids]').attr('value',goodsID);
            $('#download_from').submit();
        });
//        一键铺货
        $('#yijianpuhuo').click(function () {
            if (goods_stock_num > 0) {
                var loca = res.body.list.detail;
                var DetailViewModel={
                    goodsArr:[{goodsID: loca.goods_id,goods_name: loca.goods_name,buyer_goods_no: loca.buyer_goods_no}]
                };
                yijinPH(DetailViewModel);
            }else {
                X.notice('商品库存不足',3)
            }
        });
//         立即购买
        $('#lijigoumai').click(function () {
            var goodsNum = parseInt($('#goodsNum').val());
            if (goodsNum == '') {
                X.notice('请填写需购买的数量', 3);
            } else if (isNaN(goodsNum)) {
                X.notice('数量必须是数字', 3);
            } else if (goodsNum <= 0) {
                X.notice('购买数量不能小于1', 3);
            } else if(dataInfo.stock_num==undefined){
                X.notice('请选择规格',3)
            }else if (goodsNum <= parseInt(dataInfo.stock_num)) {
                CheckUserLogin();
                var data = {
                    'user_id':getCookieValue('user_id'),
                    'user_name':getCookieValue('user_account'),
                    'goods_sku_id':dataInfo.skuId,
                    'select_num':goodsNum
                };
                X.Post(requestUrl.get_order_goods, 1, data, function (res) {
                    if (res.header.stats == 0) {
                        var loca = res.body.list;
                        var goodsdata = {
                            goodsID: dataInfo.goods_id,        //商品ID
                            goods_sku_id: data.goods_sku_id,    //商品SKU id
                            goodsNum: goodsNum,                 //商品数量
                            sku_str_zh: loca.sku_str_zh,        //SKU属性
                            goods_name: loca.goods_name,        //商品名
                            img_path: loca.img_path,            //图片地址
                            distribution_price: loca.distribution_price,        //单价
                            stock_num:loca.stock_num           //库存
                        };
                        sessionStorage.setItem('goodsInfo', JSON.stringify(goodsdata));
                        window.location.href = 'buy_order.php';
                    } else {
                        X.notice(res.header.msg, 3);
                    }
                });
            }else{
                X.notice('库存不足', 3);
            }
        });
        var x = res;
        x.body.list.detail.useZoom =[];
        for(var  i in res.body.list.detail.img_paths){
            x.body.list.detail.useZoom.push({'img':res.body.list.detail.img_paths[i],'zoom':"useZoom: '.cloudzoom',image:'"+res.body.list.detail.img_paths[i]+"',zoomImage:'"+res.body.list.detail.img_paths[i]+"'"})
        }
        var aa = x.body.list;
        return   aa;
    })
</script>
<script type="text/javascript" src="js/Add.js"></script>
<script type="text/javascript">
    /*  select显示标题*/
    var opt0 = new Array("省","市","县");
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
                        $('#hideDiv').slideUp();
                        slideFlag = true;
                        freight(areaJson[x].areaId);
                    }else{
                        for(var y = 0; y < areaJson[x].aearList.length; y++)
                        {
                            seleCity.append("<option value='"+areaJson[x].aearList[y].areaId+"'>"+areaJson[x].aearList[y].areaName+"</option>");
                        }
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
                                $('#hideDiv').slideUp();
                                slideFlag = true;
                                freight(areaJson[x].areaId+areaJson[x].aearList[y].areaId);
                            }else{
                                for(var h = 0; h < areaJson[x].aearList[y].aearList.length; h++)
                                {
                                    seleCounty.append("<option value='"+areaJson[x].aearList[y].aearList[h].areaId+"'>"+areaJson[x].aearList[y].aearList[h].areaName+"</option>");
                                }
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
        $('#hideDiv').slideUp();
        slideFlag = true;
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
            goods_id:goodsID
        };
        X.Post(requestUrl.get_freight, 1, data, function (res) {
            if(res.header.stats==0){
                $('#yunfei').text('¥'+(res.body.list.freight).toFixed(2));
            }else {
                X.notice(res.header.msg,3)
            }
        })
    }
</script>