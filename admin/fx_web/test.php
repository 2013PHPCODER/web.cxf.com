<?php

$name = '浅水游';
print <<<EOT

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Untitled Document</title>
</head>
<body>
<!--12321-->
Hello,$name!
</body>
</html>

EOT;

echo <<<EOF
  <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
    
    <script type="text/javascript">
      $(function(){
        alert(33);    
      })     
   </script>
    
EOF;    



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
//        $.post('http://192.168.20.191:85/downloadcsv', {'goods_ids': "32"}, function (retData) {
//            $("body").append("<iframe src='" + retData.url + "' style='display: none;' ></iframe>");
//        });
        var us = {goods_ids: 32};

        $.ajax({
            url: 'http://192.168.20.191:85/downloadcsv',
            dataType: 'JSON',
            data: us,
            success: function (response) {
                debugger
                if (response.zip) {
                    location.href = response.zip;
                }
            }
        });
    })


</script>