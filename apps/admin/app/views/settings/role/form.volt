<?php $action = $model->id > 0 ? $this->url->get("/settings/role/edit?id=" . $model->id) : $this->url->get('/settings/role/add'); ?>
<form method="post" id="postForm" class="form-horizontal" action="<?php echo $action; ?>">
    <div class="container ibox-content">
        {% if model.id > 0 %}
        <input type="hidden" name="id" value="{{ model.id }}">
        {% endif %}
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">上级角色</label>
            <div class="col-sm-4">
                <select class="form-control" name="pid" id="pid">
                    {% for id,val in parentRoles %}
                    <option value="{{id}}" {%if id == model.pid %}selected{%endif%}>{{val}}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="col-sm-3 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">角色名称</label>
            <div class="col-sm-6">
                <?php echo $this->tag->textField([
                'role_name',
                'class' => 'form-control',
                'value' => $model->role_name,
                'placeholder' => '请输入角色名称',
                'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
        {% if model.id != 1 %}
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">是否可用</label>
            <div class="col-sm-6">
                <div class="radio i-checks">
                    <label>
                        <?php echo $this->tag->radioField([
                        'status',
                        'value' => 1,
                        'required' => true,
                        'checked' => ($model->status == 1|| $model->status == '' ? true : null),
                        ]); ?>
                        <span>可用</span>
                    </label>
                    <label>
                        <?php echo $this->tag->radioField([
                        'status',
                        'value' => 0,
                        'required' => true,
                        'checked' => ($model->status === 0 ? true : null),
                        ]); ?>
                        <span>不可用</span>
                    </label>
                </div>
            </div>
        </div>
        {% endif %}
        <div class="footer-div"></div>
    </div>
    <div class="form-footer">
        <button class="btn btn-danger" type="button" id="close"><i class="fa fa-times-circle"></i> 取消</button>
        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交</button>
    </div>
</form>
