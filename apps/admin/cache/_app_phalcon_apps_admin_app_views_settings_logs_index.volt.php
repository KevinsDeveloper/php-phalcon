<?= $this->partial('../layouts/top', ['title' => '日志管理']) ?>
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
                                <option value="account" <?php if ((empty($search['type']) ? ('') : ($search['type'])) == 'account') { ?> selected <?php } ?>>账号</option>
                                <option value="realname" <?php if ((empty($search['type']) ? ('') : ($search['type'])) == 'realname') { ?> selected <?php } ?>>姓名</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>关键词</label>
                            <input class="form-control" placeholder="请输入关键词" name="search[values]" value="<?= (empty($search['values']) ? ('') : ($search['values'])) ?>">
                        </div>
                        <div class="form-group">
                            <label>时间</label>
                            <input class="form-control date-picker" id="stime" placeholder="开始时间" name="search[stime]" value="<?= (empty($search['stime']) ? ('') : ($search['stime'])) ?>" size="18"> - 
                            <input class="form-control date-picker" id="etime" placeholder="结束时间" name="search[etime]" value="<?= (empty($search['etime']) ? ('') : ($search['etime'])) ?>" size="18">
                        </div>
                        <button type="submit" class="btn btn-primary">搜索</button>
                        <a class="btn btn-default" href="<?= $this->url->get('/settings/logs/index') ?>">清空</a>
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
            <?php if ($pages->items) { ?>
            <?php foreach ($pages->items as $val) { ?>
            <tr class="gradeX">
                <td class="text-center"><?= $val->id ?></td>
                <td><?= $val->account ?></td>
                <td><?= $val->realname ?></td>
                <td><?php if ($roles[$val->role_id]) { ?><?= $roles[$val->role_id] ?><?php } else { ?>--<?php } ?></td>
                <td><?= $val->actionname ?></td>
                <td><?= $val->content ?></td>
                <td><?= date('Y-m-d H:i:s', $val->created_at) ?></td>
            </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <?= $this->partial('../layouts/pages', ['pages' => $pages]) ?>
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
