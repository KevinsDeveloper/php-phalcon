var C = {
    ajax : function(url, data, back) {
        $.ajax({
            url : url,
            type : 'post',
            dataType : 'json',
            data : data,
            success:function(e){
                if(e.status != "0")
                {
                    alert(e.msg);
                }
                else
                {
                    back(e.data);
                }
            }
        })
   },
}

var Upload = function(option)
{
	var config = {
		auto : true,
        swf : '/js/Uploader.swf',
        server : '/common/upload/',
        pick : '#' + option.id + '_box',
        duplicate : true,
        accept: {
          title: 'Images',
          extensions: 'jpg,jpeg,png',
          mimeTypes: 'image/jpg,image/jpeg,image/png'   //修改这行
        }
	}
	// 初始化Web Uploader
    var uploader = WebUploader.create(config);
    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
                '<div class="thumb_list">' +
                    '<input type="hidden" id="' + file.id + '" name="thumb['+ option.id+'][]" value="">' +
                    '<img id="' + file.id + '_img" width="100px" height="100px">' +
                    '<span class="btn btn-danger btn-xs remove"> <i class="fa fa-trash-o"></i> 删除</span>' +
                '</div>'
                ),
        $img = $li.find('img');
        $('.' + option.id + '_list').append( $li );
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, 100, 100 );
    });
    uploader.on( 'uploadSuccess', function( file, response) {
        $( '#'+file.id ).val(response.url);
        $( '#' + file.id + '_img' ).attr('src', response.showurl);
    });
    // 删除商品相册图片
    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
    })
}

// 
$(function(){
	$('.date-picker').datetimepicker({lang: 'ch',timepicker:true, formatDate:'Y-m-d H:i:s', format:'Y-m-d H:i:s'});
})
