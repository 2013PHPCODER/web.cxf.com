<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
    <div class="box box-warning">

        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" >
                <form class="form-inline" method="get" action="<?php echo U('storage/storageManage/logEdit',$mp);?>">
                    <div class="form-group">
                        <label for="exampleInputName2">仓库名称:</label>
                        <select class="form-control input-xs" name="depot">
                            <option value="">选择仓库</option>
                            <?php if(is_array($depot)): $i = 0; $__LIST__ = $depot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$depot): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.depot'),$depot['id'],'selected');?> value="<?php echo ($depot["id"]); ?>"><?php echo ($depot["sname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputName2">商品类目:</label>
                        <select class="form-control input-xs" name="goods_category">
                            <option value="">主类目</option>
                            <?php if(is_array($goods_category)): $i = 0; $__LIST__ = $goods_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  <?php echo xeq(I('get.goods_category'),$vo['cid'],'selected');?> value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["name"]); ?>
                                </option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputName2">操作人:</label>
                        <input type="text" class="form-control input-xs" name="user_id" value="<?php echo I('get.user_id');?>">
                    </div>
                    <div class="row" >
                        <div class="form-group">
                            <label>操作时间:</label>
                            <input type="text" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.startTime');?>" name="startTime" placeholder="开始时间">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.endTime');?>" name="endTime" placeholder="结束时间">
                        </div>

                        <div class="form-group">
                            <select class="form-control input-xs" name="order_search" >
                                <option value="">选择关键字</option>
                                <option <?php echo xeq(I('get.order_search'),'goods_name','selected');?> value="goods_name">商品名称</option>
                                <option <?php echo xeq(I('get.order_search'),'goods_no','selected');?> value="goods_no">商品ID</option>
                                <option <?php echo xeq(I('get.order_search'),'buyer_goods_no','selected');?> value="buyer_goods_no">商家编码</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="search_word" <?php echo xeq(I('get.order_search'),'','disabled');?>  class="form-control input-xs" value="<?php echo I('get.search_word');?>"  placeholder="商品名称、商品ID、商家编码">
                        </div>
                        <div class="form-group">
                            <input type="submit"  class="btn btn-block btn-warning btn-xs" value="搜索">
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>系统时间</th>
                        <th>操作人</th>
                        <th>商品ID</th>
                        <th>修改时商家编码</th>
                        <th>修改时商品标题</th>
                        <th>SKU</th>
                        <th>原库存</th>
                        <th>变更后库存</th>
                    </tr>
                <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo date('Y-m-d H:i',$list['log_time']);?></td>
                        <td><?php echo ($list["user_id"]); ?></td>
                        <td><?php echo ($list["goods_no"]); ?></td>
                        <td><?php echo ($list["buyer_goods_no"]); ?></td>
                        <td><?php echo ($list["goods_name"]); ?></td>
                        <td><?php echo ($list["sku_str_zh"]); ?></td>
                        <td><?php echo ($list["start_num"]); ?></td>
                        <td><?php echo ($list["end_num"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>  
        </div>

        <div class="box-footer">
            <div class="left" >
                <form class="form-inline" id="pagesizeForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
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
                    <?php echo ($datas["page"]); ?> 
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>    


    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name="order_search"]').change(function (event) {
                if ('' == $(this).val()) {
                    $('input[name="search_word"]').attr('disabled', true);
                } else {
                    $('input[name="search_word"]').removeAttr('disabled');
                }
            });
        });
    </script>
 