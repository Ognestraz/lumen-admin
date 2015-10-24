var tmListLoad = {};

function showResult(target, target_type, response) {
    if (target) {
        if (response.content) {
            switch (target_type) {
                case 'prepend' : $(target).prepend(response.content); break;
                case 'append' : $(target).append(response.content); break;
                case 'load' : $(target).html(response.content); break;
                default : break;
            }
        }
    }        
}

function showError(form, messages) {

    for (key in messages) {

        form.find('input[name=' + key + ']').addClass('error');
        form.find('input[data-name=' + key + ']').addClass('error');

    }

}

function initPrettyPhoto(block) {
    (block ? block : $(document)).find("a[rel^='prettyPhoto']").prettyPhoto({
        social_tools: ''
    });        
}

function initDataTable(settings) {
    $('.dataTable').each(function() {
        $(this).DataTable(settings[$(this).data('controller')].dataTable);
    });
}

function saveTinymce() {
    for (key in tmList) {
        if (tmList[key]) {
            tmList[key].save();
        }
    }
}

function inBlock(block, placeholder) {
    
    block.css({
        left: 30 + 'px',
        top: 100 + 'px',
        position: 'absolute',
        width: placeholder.parent().width(),
        display: 'block',
        zIndex: 2
    });

    placeholder.css({
        height: block.height()
    });

    $(window).resize(function() {
        block.css({
            width: placeholder.width()
        });
        placeholder.css({
            height: block.height(),
        });        
    });

}

function initTabs() {
    
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        
        if (target !== '#tab-site') {
            $('#tab-site-load').hide();
        } else {
            target = '#tab-site-load';
        }

        var url = $(e.target).data('url');
        if (undefined !== url) {
            $.ajax({
                type: "GET",
                url: url,
                error: function(data){
                    alert("There was a problem");
                },
                success: function(data){
                    $(target).html(data);
                    initUploader($(target));
                    initPrettyPhoto($(target));
                    initSortable();
                    cropInit($(target));
                    inBlock($('#tab-site-load'), $('#tab-site'));
                }
            });
        }
    });    
    
}

function initTinymce(block) {//return false;

    block = block ? block : $(document);
    tinymce.editors = [];

    block.find('.tinymce').each(function () {

       tinymce.init({
           selector: '#' + $(this).attr('id'),
           convert_urls: false,
           remove_script_host: false,
           plugins: [
               "advlist autolink lists link image charmap print preview anchor",
               "searchreplace visualblocks code fullscreen",
               "insertdatetime media table contextmenu paste"
           ],
           toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"               
       });

       tmListLoad[$(this).attr('id')] = tinymce.get($(this).attr('id'));

    });

}

function initUploader(block) {

    var uploader = block.find('.uploader-image');
    var form_data = uploader.parents('.frm').serializeArray();
    var target = uploader.data('target');
    var target_type = uploader.data('target-type') ? uploader.data('target-type') : 'load';

    var data = {};

    data['act'] = 1;
    data['name'] = 'name';
    data['description'] = 'description';

    data['model'] = uploader.data('model');
    data['model_id'] = uploader.data('model-id');

    if (target) {

        data['_target'] = 1;

    }

    uploader.fileapi({
        url: BASE_HREF_ADMIN + '/image',
        data: data,
        autoUpload: true,
        accept: 'image/*',
        multiple: true,
        maxSize: FileAPI.MB*10, // max file size
        onFilePrepare: function (evt, uiEvt) {

            uiEvt.options.data.part = uploader.data('part');

        },
        onFileComplete: function (evt, uiEvt) {

            showResult(target, target_type, jQuery.parseJSON(uiEvt.xhr.response));

        },
        onComplete: function (err, xhr, file, options){
          
        }
    });        

}

function initSortable() {

   $('.js-sortable').sortable({
        stop: function(event, ui) {

            var th = ui.item.parents('.js-sortable');
            var sort = th.sortable("toArray", {attribute: 'data-id'});
            var controller = th.data('controller');

            $.ajax({
                type: "POST",
                url: BASE_HREF_ADMIN + '/' + controller + '/group',
                dataType: 'json',
                data: {
                    action: 'sort',
                    _token: _token,
                    ids: sort
                },
                success: function(response){ 

                    //$(".sortable").sortable("cancel");

                }
           });
       }
    });        

}