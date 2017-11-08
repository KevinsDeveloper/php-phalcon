<div class="page-body">
    <div class="well with-footer">
        <table class="table table-striped table-bordered table-hover dataTables-example">
            <thead>
            <tr>
                <th class="text-center">序号</th>
                <th>类型</th>
                <th>内容</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            {% if pages.items %}
            {% for val in pages.items %}
            <tr class="gradeX">
                <td width="8%" class="text-center">{{val.id}}</td>
                <td width="20%">{{val.actionname}}</td>
                <td width="60%">{{val.content}}</td>
                <td width="12%">{{date('Y-m-d H:i:s', val.created_at) }}</td>
            </tr>
            {% endfor %}
            {% endif %}
            </tbody>
        </table>
        {{ partial('../layouts/pages', ['pages': pages]) }}
    </div>
</div>