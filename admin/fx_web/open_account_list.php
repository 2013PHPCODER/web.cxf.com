<!DOCTYPE html>
<html>
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
    <title>创想范分销平台--开通账户列表</title>
    <link rel="stylesheet" type="text/css" href="css/common.css"/>
    <link rel="stylesheet" type="text/css" href="css/zengli.css"/>
    <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
    <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/public.js"></script>
    <script src="js/plus.js"></script>
    <script src="js/laydate.js" type="text/javascript" charset="utf-8"></script>
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
                        <!--<input type="button" class="btn btn-open" id="" value="开通账户" />-->
                        <span>选择交易类型：</span>
                        <select name="" id="selecType">
                            <option value="">——请选择——</option>
                            <option value="1">初级版</option>
                            <option value="2">中级版</option>
                            <option value="3">高级版</option>
                        </select>
                        <span>选择时间：</span>
                        <input type="text" id="start" value=""/>至
                        <input type="text" id="end" value=""/>
                    </div>
                    <div class="cont-box-body" id="creat_list">
                        <table>
                            <tr>
                                <th>订单号</th>
                                <th>开户时间</th>
                                <th>用户名</th>
                                <th>开户版本</span></th>
                                <th>版本价格</th>
                                <th>开户费用</th>
                                <th>利润</th>
                                <th>备注</th>
                            </tr>
                            <tbody data-bind="foreach:list,as:'auto'">
                            <tr id="creat-list-tr">
                                <td data-bind="text:vorder_sn"></td>
                                <td data-bind="text:add_time"><span>2016-7-27</span><span>21:39:42</span></td>
                                <td data-bind="text:new_username">fenxiaoshang@qq.com</td>
                                <td data-bind="text:name">基础版</td>
                                <td data-bind="text:price">200.00</td>
                                <td data-bind="text:agent_price">50.00</td>
                                <td data-bind="text:ratio">150.00</td>
                                <td data-bind = "text:mark">售后订单退全款</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cont-box-foot">
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'base/vip_right.php'; ?>
    </div>
</div>
<?php include_once 'base/vip_footer.php'; ?>
</body>
</html>
<script type="text/javascript">
    var start = {
        elem: '#start',
        format: 'YYYY-MM-DD',
        istime: true,
        istoday: false,
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };

    var end = {
        elem: '#end',
        format: 'YYYY-MM-DD',
        istime: true,
        istoday: false,

    };
    laydate.skin('molv');
    laydate(start);
    laydate(end);
    var open_list = {
        'user_id': getCookieValue('user_id')
    }
    var Ohtml = $('#creat_list').html();
    X.bindModel(requestUrl.open_user_list, 1, open_list, 'body.list', ['creat_list'], function () {
        $('#selecType').change(function () {
            $('#creat_list').html(Ohtml);
            leveType = $('#selecType option:selected').val();
            open_type = {
                'user_id': getCookieValue('user_id'),
                'level': leveType
            };
            ko.cleanNode(document.getElementById("creat_list"));
            X.bindModel(requestUrl.open_user_list, 1, open_type, 'body.list', ['creat_list'], function () {
            })
        })
        //时间筛选
        $('#start').blur(function(){
            setTimeout(function(){
                ko.cleanNode(document.getElementById("creat_list"));
                $('#creat_list').html(Ohtml)
                var data={
                    'user_id': getCookieValue('user_id'),
                    'page':1,
                    'start_time':$('#start').val()
                };
                X.bindModel(requestUrl.open_user_list,1,data,'body.list',['creat_list'],function(){})
            },150)
        });

        $('#end').blur(function(){
            setTimeout(function(){
                ko.cleanNode(document.getElementById("creat_list"));
                $('#creat_list').html(Ohtml);
                var data={
                    'user_id': getCookieValue('user_id'),
                    'page':1,
                    'end_time':$('#end').val()
                };
                X.bindModel(requestUrl.open_user_list,1,data,'body.list',['creat_list'],function(){})
            },150)
        });
    })

</script>
