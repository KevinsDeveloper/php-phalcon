var index = parent.layer.getFrameIndex(window.name);
$(function () {
    $("#close").click(function () {
        parent.layer.close(index);
    });
    $('#postForm').validate({
        errorPlacement: function (error, element) {
            error.appendTo(element.parent().parent().find('.validate_error'));
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                dataType: "json",
                success: function (res) {
                    if (!res || res == '') {
                        return layer.msg('Post Request Exception', {icon: 5});
                    }
                    if (res.ret != 200) {
                        return layer.msg(res.msg, {icon: 5});
                    }
                    if (res.data && res.data.redirect) {
                        return location.href = res.data.redirect;
                    }
                    bootbox.alert(res.msg, function () {
                        if (res.data && res.data.url) {
                            return location.href = res.data.url;
                        }
                        parent.location.reload();
                        parent.layer.close(index);
                    });
                },
                error: function (res) {
                    return layer.msg(res.responseJSON.msg, {icon: 5});
                }
            });
        }
    });
})