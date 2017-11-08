<?= $this->partial('layouts/top', ['title' => '默认页']) ?>
<!-- Page Body -->
<div class="page-body">
    <!-- <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="widget">
                <div class="widget-header ">
                    <span class="widget-caption">统计</span>
                    <div class="widget-buttons">
                        <a href="#" data-toggle="maximize">
                            <i class="fa fa-expand"></i>
                        </a>
                        <a href="#" data-toggle="collapse">
                            <i class="fa fa-minus"></i>
                        </a>
                        <a href="#" data-toggle="dispose">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div id="area-chart" class="chart chart-lg"></div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="horizontal-space"></div>
</div>
<!-- /Page Body -->
<!--Basic Scripts-->
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/common.js"></script>
<!--Beyond Scripts-->
<script src="/assets/js/beyond.min.js"></script>
<!-- jQuery Validation plugin javascript-->
<script src="/assets/js/validate/jquery.form.min.js"></script>
<script src="/assets/js/validate/jquery.validate.min.js"></script>
<script src="/assets/js/validate/messages_zh.min.js"></script>
<!-- JqueryForm Scripts -->
<script src="/assets/js/jquery.form.js"></script>
<!--Page Related Scripts-->
<script src="/assets/js/bootbox/bootbox.js"></script>
<!-- Layer Scripts -->
<script src="/assets/js/layer/layer.js"></script>
<script src="/assets/js/layers.js"></script>
<script src="/assets/js/style.js"></script>
<!-- datetimepicker -->
<script type="text/javascript" src="/assets/js/time/jquery.datetimepicker.js" charset="UTF-8"></script>


<!--Page Related Scripts-->
<script src="/assets/js/charts/morris/raphael-2.0.2.min.js"></script>
<script src="/assets/js/charts/morris/morris.js"></script>
<script src="/assets/js/charts/morris/morris-init.js"></script>

<script type="text/javascript">
    $(window).bind("load", function () {

        InitiateAreaChart.init();
    });
</script>