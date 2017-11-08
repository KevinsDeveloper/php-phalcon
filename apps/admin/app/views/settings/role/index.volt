{{ partial('../layouts/top', ['title': '角色管理']) }}
<!-- Page Body -->
<div class="page-body">
    <div class="well with-header with-footer">
    	<div class="header">
        	{{this.layers.open('/settings/role/add', '添加角色', [], 500, 400)}}
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead class="bordered-berry">
            <tr>
                <th class="text-center">角色ID</th>
                <th>角色名称</th>
                <th>可用?</th>
                <th>添加时间</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            {% if pages.items %}
            {% for val in pages.items %}
                <tr class="gradeX">
                    <td class="text-center">{{val['id']}}</td>
                    <td>{{val['role_name']}}</td>
                    <td class="center"><span class="badge badge-{{this.config.params['colors'][val['status']]}} badge-square">{{statusData[val['status']]}}</span></td>
                    <td class="center">{{date('Y-m-d H:i:s', val['created_at'])}}</td>
                    <td class="center">{% if val['updated_at'] > 0 %}{{date('Y-m-d H:i:s', val['updated_at'])}}{% else %}--{% endif %}</td>
                    <td class="center">
                        {% if val['id'] == 1%}
                            <button type="button" class="btn btn-xs btn-default">禁止操作</button>
                        {% else %}
                            <?php echo $this->layers->open("/settings/role/power", '权限', ["id" => $val['id']], 800, 700, "btn btn-success btn-xs", '<i class="fa fa-wrench"></i>'); ?>
                            <?php echo $this->layers->open("/settings/role/edit", '编辑', ["id" => $val['id']], 500, 400, "btn btn-primary btn-xs", '<i class="fa fa-pencil"></i>'); ?>
                            <?php echo $this->layers->cancel("/settings/role/delete", $val['id']); ?>
                        {% endif %}
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