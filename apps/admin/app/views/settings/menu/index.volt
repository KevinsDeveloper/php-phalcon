{{ partial('../layouts/top', ['title': '菜单管理']) }}
<!-- Page Body -->
<div class="page-body">
    <div class="well with-header with-footer">
        <div class="header">
            {{this.layers.open('/settings/menu/add', '添加菜单', [], 600, 500)}}
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
                {{menuTable}}
            </tbody>
        </table>
        <!--<div class="footer"></div>-->
    </div>
</div>
<!-- /Page Body -->
{% include '../layouts/bot.volt' %}