{{ partial('../layouts/top', ['title': '添加管理员']) }}
<!-- Page Body -->
<div class="page-body">
    <div class="well with-header with-footer">
        <div class="header">
            {{this.layers.open('/settings/admin/add', '添加管理员', [], 600, 500)}}
        </div>
        <table class="table table-striped table-bordered table-hover dataTables-example">
            <thead>
            <tr>
                <th class="text-center">序号</th>
                <th>账号</th>
                <th>昵称</th>
                <th>角色</th>
                <th>电话</th>
                <th>职位</th>
                <th>可用?</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            {% if pages.items %}
            {% for val in pages.items %}
            <tr class="gradeX">
                <td class="text-center">{{val.id}}</td>
                <td>{{val.account}}</td>
                <td>{{val.realname}}</td>
                <td>{{val.role.role_name}}</td>
                <td>{{val.phone}}</td>
                <td>{{val.position}}</td>
                <td><span class="badge badge-{{this.config.params['colors'][val.status]}} badge-square">{{statuaData[val.status]}}</span></td>
                <td>{{date('Y-m-d H:i:s', val.created_at) }}</td>
                <td class="center">
                    <?php echo $this->layers->open("/settings/admin/logs", '日志', ["id" => $val->id], 800, 700, "btn btn-default btn-xs") ?>

                    <?php echo $val->id != 1 ? $this->layers->open("/settings/admin/edit", '编辑', ["id" => $val->id], 600, 500, "btn btn-primary btn-xs", '<i class="fa fa-pencil"></i>') : ''; ?>
                    <?php echo $val->id != 1 ? $this->layers->cancel("/settings/admin/delete", $val->id) : ''; ?>

                </td>
            </tr>
            {% endfor %}
            {% endif %}
            </tbody>
        </table>
        {{ partial('../layouts/pages', ['pages': pages]) }}
    </div>
</div>
<!-- /Page Body -->
{% include '../layouts/bot.volt' %}