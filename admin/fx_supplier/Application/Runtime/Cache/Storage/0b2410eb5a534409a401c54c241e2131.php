<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Public\/static//webuploader/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/my.css">
</head>
<body>
    <div class="box-body">
        <div class="row" >
            <div class="col-xs-3">
                <div id="uploader" class="wu-example">
                    <!--用来存放文件信息-->
                    <div class="btns">
                        <div id="picker">选择文件</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3 col-xs-offset-5" >
                <button id="ctlBtn" class="btn btn-default">开始上传</button>
            </div>
        </div>
        <div class="row filelist">
            <div class="col-xs-12"></div>
        </div>
    </div>
</body>
<script src="/Public/js/plugins/jQuery-2.2.0.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script src="/Public/js/app.min.js"></script> 
<script type="text/javascript" src="/Public\/static//webuploader/js/webuploader.min.js"></script>
<script type="text/javascript" src="/Public\/static//layer/layer.js"></script>
</html>
<script type="text/javascript">
    $(document).ready(function ($) {
        var uploader = WebUploader.create({
            // swf文件路径
            swf: '/js/Uploader.swf',
            // 文件接收服务端。
            server: "<?php echo U('storage/loadStock');?>",
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#picker',
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            threads: 5
        })
        $list = $('.filelist');
        uploader.on('fileQueued', function (file) {
            $list.append('<div id="' + file.id + '" class="item col-xs-12">' +
                    file.name +
                    '<span class="state">等待上传...</span>' +
                    '</div>');
        });
        uploader.on('uploadBeforeSend', function (object, data, headers) {
            // do some things.
            data.shop_id = $("select[name='shop_id']").val();
        });
        $('#ctlBtn').click(function (event) {
            if (0 == uploader.getFiles().length) {
                layer.alert('请选择要导入库存表！', {icon: 6});
                return false;
            }
            /* Act on the event */
            uploader.upload();
        });
        uploader.on('uploadProgress', function (file, percentage) {
            var $li = $('#' + file.id);
            $li.find('span.state').text('上传中');
        });
        uploader.on('uploadSuccess', function (file, response) {
            if (0 == uploader.getStats().queueNum) {
                // var index = parent.layer.getFrameIndex(window.name);
                // console.log(index);
                //parent.layer.close();
                $('#' + file.id).find('span.state').text(response.message);
                parent.refurbish();
            } else {
                parent.refurbish(response);
            }

        });
        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function (file) {
            $('#' + file.id).find('span.state').text('上传失败');
            layer.alert('上传失败', {icon: 6});
        });
    });
</script>