<!-- Page Body -->
<?php $action = $model->id > 0 ? $this->url->get('/settings/menu/edit', ['id' => $model->id]) : $this->url->get('/settings/menu/add');?>
<form class="form-horizontal" id="postForm" role="form" method="post" action="{{action}}">
<div class="layer-body">
        {% if model.id > 0 %}
        <input type="hidden" name="id" value="{{ model.id }}">
        {% endif %}
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">上级菜单</label>
            <div class="col-sm-5">
                <select class="form-control" name="pid" id="pid">
                    <option value="0">==顶级菜单==</option>
                    {{menuOption}}
                </select>
            </div>
            <div class="col-sm-3 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">菜单名称</label>
            <div class="col-sm-6">
                <?php echo $this->tag->textField([
                'title',
                'class' => 'form-control',
                'value' => $model->title,
                'placeholder' => '请输入菜单名称',
                'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-3 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">菜单url</label>
            <div class="col-sm-6">
                <?php echo $this->tag->textField([
                'url',
                'class' => 'form-control',
                'value' => $model->url,
                'placeholder' => '请输入菜单url',
                'required' => true,
                ]); ?>
                <span class="help-block m-b-none">如果是顶级菜单,URL可为#</span>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">菜单icon</label>
            <div class="col-sm-4">
                <?php echo $this->tag->textField([
                'icon',
                'class' => 'form-control',
                'value' => $model->icon,
                'placeholder' => '请输入菜单icon',
                ]);
                ?>
                <span class="help-block m-b-none">可以为空</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">排序</label>
            <div class="col-sm-3">
                <?php echo $this->tag->textField([
                'orderby',
                'class' => 'form-control',
                'value' => $model->orderby,
                'placeholder' => '请输入排序',
                'number' => true,
                'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">是否可用</label>
            <div class="col-sm-6">
                <div class="radio">
                    <label>
                        <?php echo $this->tag->radioField([
                        'status',
                        'value' => 1,
                        'required' => true,
                        'checked' => ($model->status == 1 ? true : null),
                        ]); ?>
                        <span>可用</span>
                    </label>
                    <label>
                        <?php echo $this->tag->radioField([
                        'status',
                        'value' => 0,
                        'required' => true,
                        'checked' => ($model->status == 0 ? true : null),
                        ]); ?>
                        <span>不可用</span>
                    </label>
                </div>
            </div>
        </div>
</div>
<div class="form-footer">
    <button type="button" id="close" class="btn btn-warning" data-dismiss="modal"> <i class="fa fa-times-circle"></i>关闭</button>
    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> 提交</button>
</div>
</form>
<!-- /Page Body -->
