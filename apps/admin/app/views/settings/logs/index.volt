{{ partial('../layouts/top', ['title': '日志管理']) }}
<!-- Page Body -->
<div class="page-body">
    <div class="well with-footer">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="widget padbot-10">
                    <form class="form-inline" role="form" method="get">
                        <div class="form-group">
                            <label>类型</label>
                            <select name="search[type]" class="form-control" id="type">
                                <option value="">-请选择-</option>
                                <option value="account" {% if search[
                                'type']|default('') == 'account' %} selected {% endif %}>账号</option>
                                <option value="realname" {% if search[
                                'type']|default('') == 'realname' %} selected {% endif %}>姓名</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>关键词</label>
                            <input class="form-control" placeholder="请输入关键词" name="search[values]" value="{{search['values']|default('')}}">
                        </div>
                        <div class="form-group">
                            <label>时间</label>
                            <input class="form-control date-picker" id="stime" placeholder="开始时间" name="search[stime]" value="{{search['stime']|default('')}}" size="18"> - 
                            <input class="form-control date-picker" id="etime" placeholder="结束时间" name="search[etime]" value="{{search['etime']|default('')}}" size="18">
                        </div>
                        <button type="submit" class="btn btn-primary">搜索</button>
                        <a class="btn btn-default" href="{{this.url.get('/settings/logs/index')}}">清空</a>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead class="bordered-berry">
            <tr>
                <th class="text-center" width="5%">序号</th>
                <th width="8%">账号</th>
                <th width="10%">姓名</th>
                <th width="10%">角色</th>
                <th width="10%">类型</th>
                <th width="45%">内容</th>
                <th width="12%">时间</th>
            </tr>
            </thead>
            <tbody>
            {% if pages.items %}
            {% for val in pages.items %}
            <tr class="gradeX">
                <td class="text-center">{{val.id}}</td>
                <td>{{val.account}}</td>
                <td>{{val.realname}}</td>
                <td>{% if roles[val.role_id] %}{{roles[val.role_id]}}{%else%}--{%endif%}</td>
                <td>{{val.actionname}}</td>
                <td>{{val.content}}</td>
                <td>{{date('Y-m-d H:i:s', val.created_at) }}</td>
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