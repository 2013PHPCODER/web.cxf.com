$(document).ready(function($) {
    try{
        $('#startTime,#endTime').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            language:'zh-CN'
      	});
    }catch(err){}

    $('#checkAll').change(function(){
        if($(this).prop('checked') == true){
            $('.choose').prop('checked',true).prop('checked',true);
        }
        else{
            $('.choose').prop('checked',false);
        } 
    });

    $(".pagesize").change(function(){
        $('#pagesizeForm').submit();
    });
		
});