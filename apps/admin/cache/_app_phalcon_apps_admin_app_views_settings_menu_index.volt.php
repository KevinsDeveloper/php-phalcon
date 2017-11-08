<?= $this->partial('../layouts/top', ['title' => '菜单管理']) ?>
<!-- Page Body -->
<div class="page-body">
    <div class="well with-header with-footer">
        <div class="header">
            <?= $this->layers->open('/settings/menu/add', '添加菜单', [], 600, 500) ?>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead class="bordered-berry">
                <tr>
                    <th class="text-center">ID</th>
                    <th>名称</th>
                    <th>url</th>
                    <th>icon</th>
                    <th>是否可用</th>
                    <th>排序</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?= $menuTable ?>
            </tbody>
        </table>
        <!--<div class="footer"></div>-->
    </div>
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
