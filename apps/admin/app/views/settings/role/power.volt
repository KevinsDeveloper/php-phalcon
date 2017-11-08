<form method="post" id="postForm" class="form-horizontal" action="<?php echo $this->url->get('/settings/role/power', ['id' => $model->id]); ?>">
    <div class="ibox-content">
        <table class="table table-striped table-bordered table-hover dataTables-example">
            <tbody>
            {{actionData}}
            </tbody>
        </table>
    </div>
    <div class="footer-div"></div>
    <div class="form-footer">
        <button type="button" id="close" class="btn btn-warning" data-dismiss="modal"> <i class="fa fa-times-circle"></i>关闭</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> 提交</button>
    </div>
</form>
<script type="text/javascript">
$(function(){
    function checkSon(parent)
    {
        var num = 0;
        $('.list_' + parent + '_son').find('td').find('label').find('input[type="checkbox"]').each(function(i, v){
            if($(this).prop('checked'))
            {
                num = num + 1;
            }
        })
        if(num == 0){
            $('.list_' + parent).find('td').find('label').find('input[type="checkbox"]').prop('checked', false)
        }else{
            $('.list_' + parent).find('td').find('label').find('input[type="checkbox"]').prop('checked', true);
        }
    }

    $('.top').find('td').find('label').find('input').on('click', function(){
        var status = $(this).prop('checked');
        var id = $(this).attr('data-pid');
        $('.list_' + id + '_son').find('td').find('label').find('input[type="checkbox"]').prop('checked', status);
    })
    $('.checkAll').on('click', function(){
        var status = $(this).prop("checked");
        var parent = $(this).attr('data-pid');
        $(this).parent().parent().parent().find('td').find('label').find('input[type="checkbox"]').prop("checked", status);
        checkSon(parent);
    });
    $('.checkSign').on('click', function(){
        var num = 0;
        var name = $(this).prop("name");
        $("[name='" + name + "']").each(function(i, v){
           if($(this).prop('checked'))
           {
                num = num + 1;
           } 
        })
        var obj = $(this).parent().parent().prev().prev().find('label').find('input')
        var parent = obj.attr('data-pid');
        var status = obj.prop("checked");
        if(num == 1 && status)
        {
            obj.prop("checked", false);
            checkSon(parent);
        }
        else
        {
            obj.prop("checked", true);
            checkSon(parent);
        }
    });
})
</script>