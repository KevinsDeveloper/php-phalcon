{{ partial('layouts/top', ['title': '提示']) }}
<!-- Page Body -->
<div class="page-body" style="text-align: center;">
    <div class="row">
        <div class="col-lg-4 col-sm-4 col-xs-6">
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6">
            <div class="well with-header">
                <div class="header bordered-darkorange">提醒</div>
                <div class="alert alert-warning fade in">
                    <i class="fa-fw fa fa-warning"></i>
                    <strong>抱歉</strong> 操作权限不足
                </div>
                <div class="padding-5"><span id="time">3</span>秒自动跳转中...</div>
                <div class="buttons-preview">
                <button class="btn" data-toggle="modal" data-target="#modal-warning" onclick="javascript:history.go(-1);">返回</button>
                </div>
            </div>

        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6">
            
        </div>
    </div>
</div>
<!-- /Page Body -->
{% include 'layouts/bot.volt' %}
<script type="text/javascript">
    var countdown = 3;
    function settime() {
        if (countdown == 0) {
            history.go(-1);
            return;
        } else {
            $('#time').html(countdown);
        }
        countdown--;
    }
    $(function(){
        //setInterval(function(){settime()},1000);
    })
</script>