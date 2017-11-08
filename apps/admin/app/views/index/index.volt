{{ partial('layouts/top', ['title': '默认页']) }}
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
{% include 'layouts/bot.volt' %}

<!--Page Related Scripts-->
<script src="/assets/js/charts/morris/raphael-2.0.2.min.js"></script>
<script src="/assets/js/charts/morris/morris.js"></script>
<script src="/assets/js/charts/morris/morris-init.js"></script>

<script type="text/javascript">
    $(window).bind("load", function () {

        InitiateAreaChart.init();
    });
</script>