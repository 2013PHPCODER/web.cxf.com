<div class="header-search clearfix">
    <div class="logo">
        <a target="_self" href="../index.php" class="logo-box"></a>
        <a target="_self" href="../index.php" class="logo-text"></a>
    </div>
    <div class="search">
        <div class="search-group clearfix">
            <input type="text" class="inp-search" name="searchText" id="searchText" value="" placeholder="请输入想要搜索的关键词" /><input type="button" class="btn-search" id="" value="搜索" />
        </div>
        <div class="search-hot">
            <p><span>热门搜索：</span><span><a href="/goodlist.php?keyword=女装">女装</a></span><span><a href="/goodlist.php?keyword=男装">男装</a></span><span><a href="/goodlist.php?keyword=童装">童装</a></span><span><a href="/goodlist.php?keyword=女鞋">女鞋</a></span><span><a href="/goodlist.php?keyword=男鞋">男鞋</a></span></p>
        </div>
    </div>
    <div class="trait">
        <div class="a-group clearfix">
            <a><i class="wholesale"></i><span>一件代发</span></a>
            <a><i class="shipments"></i><span>48小时发货</span></a>
            <a><i class="replacement"></i><span>15天包换</span></a>
        </div>

    </div>
</div>
<div class="nav">
    <div class="nav-box clearfix">
        <ul class="clearfix">
            <li class="classify" id="category">
                <a href="javascript:;"><i></i>所有商品分类</a>
                <div class="classify-box e-tab" data-bind = "foreach:{data:category,as:'auto'}" >
                    <div class="classify-body clearfix">
                        <div class="classify-icon">
                            <img data-bind = "attr:{src:small_ico}" src="" alt="" />
                        </div>
                        <div class="classify-name">
                            <p><a target="_self" data-bind = "text:name"></a></p>
                            <p data-bind = "foreach:{data:child,as:'auto'}">
                                <a target="_blank" data-bind = "text:title,attr:{href:'goodlist.php?cate_id='+cid}"></a>
                                <!--<a data-bind = "text:child.length>2?child[2].name:'',attr:{href:child.length>2 ? '/goods_center.php?cate_id='+child[2].cid : ''}" href="">新品</a>-->
                            </p>
                        </div>
                        <div class="classify-boult">
                            <img src="images/classify-boult.png" />
                        </div>
                    </div>                         
                </div>
                <div class="tab-box clearfix" data-bind = "foreach:{data:category,as:'auto'}">
                    <div class="menu-tab" data-bind = "foreach:{data:child,as:'auto'}">
                    	<div class="menu-tab-box">
                    		<h2 data-bind = "text:title,attr:{href:'goodlist.php?cate_id='+category_id">男上装</h2>
                    		<div class="tab-box-chilren" data-bind = "foreach:{data:child,as:'auto'}">
                    		    <span><a target="_self" data-bind = "text:name,attr:{href:'goodlist.php?cate_id='+cid}">T恤</a></span>
                    		</div>
                    		
                    	</div>
                    </div>  
                                                 
                </div>
            </li>
            <li class="active nav-secend">
                <a href="../index.php"><span>首页</span><span>HOME</span></a>
            </li>
            <li >
                <a href="../goods_center.php"><span>货源中心</span><span>SUPPLY CENTER</span></a>
            </li>
            <li>
                <a href="../helplist.php"><span>帮助中心</span><span>HELP CENTER</span></a>
            </li>
            <li>
                <a href="../vision.php"><span>软件代理介绍</span><span>CASE SHOW</span></a>
            </li>
            <li class="news-center">
                <a href="../sortware_agent.php"><span>软件介绍与下载</span><span>NEWS CENTER</span></a>
            </li>
            <li class="nav-news">
                <a href="../supplier_comein.php" >
                    <i></i>
                    <span>供应商入驻</span>
                    <div class="news-icon"></div>
                </a>
            </li>
        </ul>
    </div>
</div>


<div class="marks PH"  style="display: none">
    <div class="PopDiv">
        <div class="PopHeader">
            <img src="images/PopIco/tips.png" alt="">
            <span class="PopTitle">铺货</span>
            <div class="PopColse" onclick="colsePh()"></div>
        </div>
        <div class="PopBody">
            <div class="Phcontent">
                <p>铺货详情：<span>以下商品将发布到您当前的默认店铺：</span><select id="shopList"></select></p>
                <div class="PhTab" id="PHGoods">
                    <table>
                        <tr>
                            <th>商品ID</th>
                            <th>货号</th>
                            <th>商品标题</th>
                            <th>铺货结果</th>
                        </tr>
                        <tbody data-bind = "foreach:{data:goodsArr,as:'auto'}">
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
                                淘宝自定义分类：<select id="goodsType"><option>--请选择--</option></select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">
                                <label><input type="radio" name="PhMailType" value="1">买家承担运费</label>运费统一设置为：<input type="text" placeholder="运费金额" id="freight_fee" > 元
                                <span>买家承担运费的范围为0.001~999.00</span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2"><label><input type="radio" name="PhMailType" value="2">使用卖家运费模板</label><select id="shopTemplate"><option>123132</option></select><span>必须选择一个模板，如果没有请至淘宝添加</span></td>
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
            <button class="startPH2">开始铺货</button>
        </div>
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/json2/20150503/json2.min.js"></script>
<script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
<script src="js/plus.js" type="text/javascript" charset="utf-8"></script>
<script src="js/public.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
       
        (function($){
            var url = window.location.href;
                url=url.substring(url.lastIndexOf('/') + 1);
                url =url.substring(0,url.indexOf('.'));

        	var n ;
        	switch (url) {
        		case 'index' :
        		    n=1;
        		    break;
        	    case 'goods_center' :	    
        	        n=2;
        		    break;
        		case 'helplist' :	    
        	        n=3;
        		    break;
        		case 'vision' :	    
        	        n=4;
        		    break;        
        	    case 'sortware_agent' :	    
        	        n=5;
        		    break;    
        	}
//        	console.log(n);
        	$('.nav-box>ul>li').eq(n).addClass('active').siblings().removeClass('active');
        })(jQuery);
        
//        if (getCookieValue('user_nickname') != '' && getCookieValue('user_nickname') != null) {
//			$('.nav-box .nav-news>a').click(function(){
//				X.notice('对不起，您已是分销商',3)
//				return false
//			})
//	    }
        
        $(function(){
        	$('.btn-search').on('click',function(){
        		var url = window.location.href;
                url=url.substring(url.lastIndexOf('/') + 1);
                url =url.substring(0,url.indexOf('.'));
        		if(url == 'goodlist'){       			
        			var data = searchCondition();
        			if( $('#searchText').val() == '' ){
        				data.keyword = ''
        			} 
        			search(data)    			
        		}else{
        			var val =  $('#searchText').val();
        		    window.location.href = 'goodlist.php?keyword='+encodeURIComponent(val);
        		}       		
        	});
        });

        $(window).keydown(function(e){
            var  isFocus=$(".inp-search").is(":focus");
            if(isFocus&& e.keyCode == 13){
                $('.btn-search').click();
                $(".inp-search").blur();
            }
        });
</script>
<!--//一键铺货-->
<script type="text/javascript">
    var PHGood = $('#PHGoods').html();
    function yijinPH(DetailViewModel){
        CheckUserLogin();
        var userID = getCookieValue('user_id');
        var ids = [];
        X.Post(requestUrl.check_is_bindtaobao, 1,{user_id:userID}, function (res) {
            if(res.header.stats==0){
                if(res.body.list.is_bind==0){
                    X.notice('您尚未绑定淘宝店铺',3);
                }else {
                    $('.PH').show();
                    $('#PHGoods').html(PHGood);
                    var ii = 609/ parseInt($(DetailViewModel.goodsArr).length);
                    ko.cleanNode(document.getElementById("PHGoods"));
                    $('#PHGoods').html(PHGood);
                    //绑定数据
                    ko.applyBindings(DetailViewModel, document.getElementById('PHGoods'));

                    $('.Phcontent select,.Phcontent input,.startPH2').attr('disabled','disabled');

                    $('.PHNum').text($(DetailViewModel.goodsArr).length);
                    $(DetailViewModel.goodsArr).each(function(){
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

                                $('.Phcontent select,.Phcontent input,.startPH2').removeAttr('disabled','disabled');
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
                    $('.startPH2').unbind('click').click(function () {
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
                                $('.Phcontent select,.Phcontent input,.startPH2').attr('disabled','disabled');
                                $('.startPH2').text('铺货中...').css('background','#ccc');
                                PHdata.cid = goodsType;
                                var len = $(PHdata.goods_id).length;
                                $(PHdata.goods_id).each(function (key, item) {
                                    PHdata.goods_id = item;
                                    X.Post(requestUrl.item_add_taobao, 1, PHdata, function (res) {
                                        if (res.header.stats == 0) {

                                            if(res.body.list.sucess == true){
                                                nowNum ++;
                                                $('.goodsID'+item+'>.PHstatus').text('铺货完成').css('color','#1def12');
                                                $('.nowNum').text(nowNum);
                                                $('.PhJD p').animate({'width': ii*nowNum + 'px'}, 200);
                                                if(nowNum==len){
                                                    $('.startPH2').text('铺货完成').removeAttr('disabled','disabled').css('background', '#ff6537').removeClass('startPH2').addClass('endPH');
                                                    X.notice('铺货完成',3);
                                                    $('.endPH').unbind('click').click(function(){
                                                        colsePh();
                                                    })
                                                }
                                            }
                                        } else {
                                            $('.Phcontent select,.Phcontent input,.startPH2').removeAttr('disabled','disabled');
                                            $('.startPH2').text('开始铺货').css('background','#ff6537');
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
        $('.Phcontent select,.Phcontent input,.startPH2').removeAttr('disabled','disabled');
        $('.endPH').removeClass('endPH').addClass('startPH2');
        $('.PhJD p').css('width','15px');
        $('.startPH2').text('开始铺货');
        $('.nowNum').text(0);
        $('.marks,.PH').hide();

//        $('.PH').hide();$('.startPH2').removeAttr('disabled','disabled');$('.startPH2').text('开始铺货');$('.PhJD p').css('width','17px');$('.nowNum').text(0);
    }
</script>