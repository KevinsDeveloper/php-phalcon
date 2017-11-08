<form method="post" id="postForm" class="form-horizontal" action="/index/info">
    <div class="wrapper ibox-content">
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">账号</label>
            <div class="col-sm-6">
                <?php echo $this->tag->textField([
                'account', 'class' => 'form-control', 'value' => $model->account, 'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">密码</label>
            <div class="col-sm-6">
                <?php if (!empty($model->password)): ?>
                <?php echo $this->tag->passwordField(['password', 'class' => 'form-control', 'value' => ""]); ?>
                <?php else: ?>
                <?php echo $this->tag->passwordField(['password', 'class' => 'form-control', 'value' => "", 'required' => true,]); ?>
                <?php endif; ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">确认密码</label>
            <div class="col-sm-6">
                <?php if (!empty($model->password)): ?>
                <?php echo $this->tag->passwordField(['qpassword', 'class' => 'form-control', 'value' => ""]); ?>
                <?php else: ?>
                <?php echo $this->tag->passwordField(['qpassword', 'class' => 'form-control', 'value' => "", 'required' => true,]); ?>
                <?php endif; ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">姓名</label>
            <div class="col-sm-6">
                <?php echo $this->tag->textField([
                'realname', 'class' => 'form-control', 'value' => $model->realname, 'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label text-right">手机</label>
            <div class="col-sm-6">
                <?php echo $this->tag->textField([
                'phone', 'class' => 'form-control', 'value' => $model->phone, 'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right">职位</label>
            <div class="col-sm-6">
                <?php echo $this->tag->textField([
                'position', 'class' => 'form-control', 'value' => $model->position, 'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-2 validate_error m-t-xs"></div>
        </div>
    </div>
    <div class="footer-div"></div>
    <div class="form-footer">
        <button class="btn btn-danger" type="button" id="close"><i class="fa fa-times-circle"></i> 取消</button>
        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交</button>
    </div>
</form>