<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
    <style type="text/css">
        .dalog-modal{
            width: 100%;
            height: 100%;
            position: fixed;
            background: rgba(0,0,0,0.5);
            display: none;
            top: 0;
            left: 0;
            z-index: 999;
        }
        .dalog-container{
            width: 574px;
            position: absolute;
            top:300px;
            left: 50%;
            margin-left: -287px;
            margin-top: -200px;
            background: #fff;
            opacity: 1;
            z-index: 9999;
        }
        .dalog-container h2{
        	text-align: center;
        	font-family: "microsoft yahei";
        	font-size: 36px;
        	padding: 20px 0;
        }
        .dalog-container span{
            display: inline-block;
            width: 100px;
            text-align: right;
        }
        .dalog-modal{
            display: none;
        }
        .dalog-modal .g-modal-content.add-entrepot input[type="text"]{
            margin: 0;
            position: relative;
        }
        .dalog-modal .g-modal-content.add-entrepot label strong{
            margin: 0 10px;
            color: #FF2015;
            display: inline;
        }
        .dalog-modal h2{
            padding: 10px 0;
            text-align: center;
        }
        .modal-content{
            padding: 10px 0;
            font-family: "microsoft yahei";
        }
        .dalog-modal  label{
            width: 200px;
            width: 100%;
            padding: 10px 40px;
        }
        .dalog-modal label.error{
            width: 244px;
        }
        .modal-content label span{
            display: inline-block;
            width: 100px;
            text-align: right;
        }
        .dalog-modal .close{
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px;
        }
        .dalog-modal .close:hover{
            cursor: pointer;
            width: 40px;
            height: 40px;
            background: #888888;
            border-radius: 5px;
            border-top-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .sub-btn{
            text-align: center;
            padding: 20px 0;
        }
        .sub-btn input{
            width: 150px;
            height: 40px;
            background: rgb(33,119,199);
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 2px #888888;
            color: #fff;
            font-family: "microsoft yahei";
            font-size: 20px;
            margin: 0 10px;
        }
        .sub-btn input:hover{
            box-shadow: 0 0 10px #888888;
            cursor: pointer;
        }
    </style>
    <script>
//    	var data={
//    		username:<?php echo ($vo["sname"]); ?>,
//    		person:<?php echo ($vo["functionary"]); ?>,
//    	};
    </script>
    <div class="box-body">	
        <div class="row">
            <form class="form-inline" method="get" action="<?php echo U(ACTION_NAME, I('get.'));?>" id="searchForm">
                <div class="form-group"><span>仓库名称:</span>
                    <input type="text" name="search_sname" value="<?php if($_GET['search_sname']){echo $_GET['search_sname'];}?>" class="form-control input-xs" placeholder="输入仓库名称">
                </div>
                <div class="form-group"><span>负责人:</span>
                    <input type="text" name="search_functionary" value="<?php if($_GET['search_functionary']){echo $_GET['search_functionary'];}?>" class="form-control input-xs" placeholder="输入负责人">
                </div>
                <div class="form-group"><span>手机号:</span>
                    <input type="text" name="search_mobile" value="<?php if($_GET['search_mobile']){echo $_GET['search_mobile'];}?>" class="form-control input-xs" placeholder="输入手机号">
                </div>
                <div class="form-group"><span>运费模板:</span>
                    <input type="text" name="search_freight" value="<?php if($_GET['search_freight']){echo $_GET['search_freight'];}?>" class="form-control input-xs" placeholder="输入运费模板">
                </div>
                <div class="form-group btnBox">
                    <input type="submit" class="btn btn-block btn-warning btn-xs" value="搜索">
                </div>
            </form>	
        </div>
        <div class="row">
            <div class="form-group">
                <button class="btn btn-default" id="redact">新增仓库</button>
            </div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>名称</th>
                        <th>负责人</th>
                        <th>手机号</th>
                        <th>运费模板</th>
                        <th>仓库地址</th>
                        <th>操作</th>
                    </tr>
                <?php if(is_array($datas)): $i = 0; $__LIST__ = $datas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>	
                        <td><?php echo ($vo["sname"]); ?></td>
                        <td><?php echo ($vo["functionary"]); ?></td>
                        <td><?php echo ($vo["mobile"]); ?></td>
                        <td><?php echo (get_freight_template($vo["freight"])); ?></td>
                        <td><?php echo ($vo["address"]); ?></td>
                        <td><a href="<?php echo U('storage/elist',array('id'=>$vo['id']));?>">编辑</a></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>	
            </table>
        </div>	
        <div class="box-footer">
            <div class="left">
               <form class="form-inline" id="pagesizeForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
                <!--div class="form-group">
                    <label for="exampleInputName2">全选结果页:  </label><input type="checkbox" class="allGoods" class="choose" name="allGoods" value="">
                </div-->
                <div class="form-group">
                    <select name="pagesize" class="form-control input-xs pagesize">
                        <option <?php echo xeq(I('get.pagesize'), 20, 'selected');?> value="20">20条</option>
                        <option <?php echo xeq(I('get.pagesize'), 50, 'selected');?> value="50">50条</option>
                        <option <?php echo xeq(I('get.pagesize'), 100, 'selected');?> value="100">100条</option>
                    </select>
                </div>
            </form>
            </div>
            <div class="right">
                <div class="pagination">
                    <?php echo ($pager); ?>
            </div>
        </div>
    </div>
</div>
<div class="dalog-modal" id="aleatMoudle">
    <div class="dalog-container">
        <h2>新增仓库</h2>
        <div class="g-modal-content add-entrepot">
            <form id="e_entrepot" action="<?php echo U('storage/addStorage');?>" method="POST">
                <label><span>仓库名称：</span><input type="text" name="sname" id="" value="" /><!--计价方式：<sapn>按重量</sapn><a href="">详情</a--></label>
                <label>
                    <span>仓库地区：</span>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                </label>
                <label><span>详细地址：</span><input class="freight" type="text" name="address" id=""  /></label>
                <label><span>仓库负责人：</span><input  name="functionary" type="text" id="e-person"  /></label>
                <label><span>手机号：</span><input type="text" name="mobile" value="<?php echo ($list["mobile"]); ?>"/></label>
                <label><span>运费模板：</span>
                    <select name="freight" id="">
                        <?php if(empty($freight_template)): ?><option value="">请选择</option>
                            <?php else: ?>
                            <option value="">请选择</option>
                            <?php if(is_array($freight_template)): $i = 0; $__LIST__ = $freight_template;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["freight_template_id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </select>
                </label>
                <div class="sub-btn"><input type="button" id="adress-btn1" class="sumb" value="取消"/><input type="submit" class="sumb" value="新增"/></div>
                {__TOKEN__}
            </form>
        </div>
        <span class="close" id="dalogModalClose">×</span>
    </div>
</div>
<script type="text/javascript" src="/Public/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="/Public/js/cityClass.js"></script>
<script type="text/javascript">
    $(function () {
        $('#clickMe').click(function () {
            $('.dalog-modal').show();
        })
        $('#add-adress').click(function () {
            $('.g-modal-content table').append('<tr><td></td>td></td>td></td>td></td>td></td></tr>');
        })
    });
</script>
<script type="text/javascript">
    $(function () {
        new PCAS("province", "city", "area");
        $('.removeTr').click(function () {
            $(this).parent().parent().remove();
        });
//			$('.sumb').click(function(){
//				document.getElementById('aleatMoudle').style.display = 'none'
//			});
        $('#redact').click(function () {
            $('#aleatMoudle').show();
        })
        $('#adress-btn1').click(function () {
            $('#aleatMoudle').hide();
        })
        $('#dalogModalClose').click(function () {
            $('#aleatMoudle').hide();
        })
        $('#e_entrepot').validate({
            rules: {
                e_person: {
                    required: true
                },
                e_telphone: {
                    required: true,
                    minlength: 11,
                    maxlength: 11,
                    checkarea: true
                }
            },
            messages: {
                e_person: {
                    required: '<strong>请输入负责人</strong>'
                },
                e_telphone: {
                    required: '<strong>请输入电话号码</strong>',
                    minlength: '<strong>请输入正确的电话号码位数</strong>',
                    max: '<strong>请输入正2确的电话号码位数</strong>'
                }
            }
        });
    })
//    var data={
//    	user:<?php echo ($vo["sname"]); ?>;
//    }
</script>


