$(function () {
    layer.open({
        type: 1,
        title: false,
        closeBtn: false,
        shade: 0.8,
        area: ['600px'],
        id: 'LAY_layuipro0',
        resize: false,
        btn: ['立即升级', '残忍拒绝'],
        btnAlign: 'c',
        moveType: 1,
        content: '<div class="ibox-content"><h1>是时候升级你的浏览器了 </h1><p>你正在使用 Internet Explorer 的过期版本（IE6、IE7、IE8 或使用该内核的浏览器）。这意味着在升级浏览器前，你将无法访问此网站。</p></div>',
        success: function (layero) {
            var btn = layero.find('.layui-layer-btn');
            btn.find('.layui-layer-btn0').attr({
                href: 'http://sdr.nuaa.edu.cn/web/upgrade-your-browser.html',
                target: '_blank'
            });
        }
    });
});