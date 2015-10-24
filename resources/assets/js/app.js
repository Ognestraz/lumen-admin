$(document).ready(function() {
    
   var tm_list = {};
   
    transliterate = (

        function() {

            var
                rus = "щ   ш  ч  ц  ю  я  ё  ж  ъ  ы  э  а б в г д е з и й к л м н о п р с т у ф х ь".split(/ +/g),
                eng = "shh sh ch cz yu ya yo zh `` y' e` a b v g d e z i j k l m n o p r s t u f x `".split(/ +/g);

            return function(text, engToRus) {

                var x;

                for(x = 0; x < rus.length; x++) {

                    text = text.split(engToRus ? eng[x] : rus[x]).join(engToRus ? rus[x] : eng[x]);
                    text = text.split(engToRus ? eng[x].toUpperCase() : rus[x].toUpperCase()).join(engToRus ? rus[x].toUpperCase() : eng[x].toUpperCase());

                }

                return text;

            }

        }

    )();
   
   
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

    function tinymce_save() {
        
        for (key in tm_list) {
            
            if (tm_list[key]) {
                
                tm_list[key].save();
                
            }
            
        }
        
    }


    function tinymce_load(block) {
        
        block = block ? block : $(document);
        tinymce.editors = [];
        
//        block.find('textarea.tinymce').tinymce({
//       //     script_url : '//tinymce.cachefly.net/4.1/tinymce.min.js'
//        });        
        
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
           
           tm_list[$(this).attr('id')] = tinymce.get($(this).attr('id'));
            
        });
        
    }

    function showError(form, messages) {
        
        for (key in messages) {

            form.find('input[name=' + key + ']').addClass('error');
            form.find('input.name-' + key).addClass('error');
            
        }
        
    }


    function validateRules(item) {
        
        var rules = {
            'required': 'required',
            'min': 'minlength',
            'max': 'maxlength' 
        };
        
        return rules[item] ? rules[item] : item;
        
    }
    
    function validParse(rules) {
        
        var result = {};
        
        result['rules'] = {};
        result['messages'] = {};

        for (key in rules['rules']) { 
            
            var rule = rules['rules'][key].split('|');
            var rl = {};

            for (var k in rule) {
                
                f = rule[k].split(':');
                rl[validateRules(f[0])] = f.length > 1 ? f[1] : true;
                
            }
            
            result['rules'][key] = rl;
            
        }

        for (key in rules['messages']) { 
            
            f = key.split('.');
            
            if (f.length > 1) {
                
                result['messages'][f[0]] = {};
                result['messages'][f[0]][f[1]] = rules['messages'][key];
                
            } else {
                
                result['messages'][f[0]] = rules['messages'][key];
                
            }
            
        }
        
        return result;
        
    }
    
   /* function prettyphoto(block) {

        (block ? block : $(document)).find("a[rel^='prettyPhoto']").prettyPhoto({
            social_tools: ''
        });        
        
    }*/
    
   /* function dataTable() {
        $('.dataTable').each(function() {
            $(this).DataTable(controllerSettings[$(this).data('controller')].dataTable);
        });
    }*/
    
    function sortable() {
        
       $('.sortable').sortable({
            stop: function(event, ui) {

                var th = ui.item.parents('.sortable');

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
    
    function tabs() {
        
        $(".tabs-site").tabs({
            load: function( event, ui ) {
                
                load_uploader(ui.panel);
                sortable();
                prettyphoto();
                cropInit(ui.panel);
                subtabs();
                
            }
        });
        
    }    
    
    function subtabs() {
        
        $(".subtabs-site").tabs({
            load: function( event, ui ) {
                
                load_uploader(ui.panel);
                sortable();
                prettyphoto();
                cropInit(ui.panel);
                
            }
        });
        
    }    
    
    function load_uploader(block) {

        var uploader = block.find('.uploader-image');
        
        console.log('block');
        console.log($('.uploader-image'));
        console.log($('.uploader-image').first());
        console.log($('#uploader-image'));
        
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
            //progress: '#fileapi-progress',
            maxSize: FileAPI.MB*10, // max file size
            onFilePrepare: function (evt, uiEvt) {
                
                uiEvt.options.data.part = uploader.data('part');

            },
            onFileComplete: function (evt, uiEvt) {
                
                showResult(target, target_type, jQuery.parseJSON(uiEvt.xhr.response));

            },
            onComplete: function (err, xhr, file, options){
                  $('.progress').show();
                  alert(5);
            }
        });        
        
    }
    
    function reload_tree(tree) {
        
        if (tree.data('module')) {
        
            tree_url = BASE_HREF_ADMIN + '/' + tree.data('module') + '/tree';

            $.getJSON(tree_url, function(new_data) {

                tree.tree('loadData', new_data);

            });   
        
        }
                
    }
    
    function load_tree(tree) {
        
        if (tree) {

            var module = tree.data('module');
            
            if (module) {
            
                var tree_url = BASE_HREF_ADMIN + '/' + module + '/tree';

                $.getJSON(tree_url, function(data) {

                    tree.tree({
                        data: data,
                        saveState: 'tree-' + module,
                        dragAndDrop: true,
                        onCreateLi: function(node, $li) {
                            
                            if (node.act == 0) {
                                
                                $li.addClass('disabled');
                                $li.find('li').addClass('disabled');
                                
                            } else {
                                
                                $li.addClass('enabled');
                                
                            }
                            
                            $li.find('.jqtree-element').append(
                                '[' + node.id + '](' + node.sort + ') - ' + node.path + ' - ' + 
                                '[<a href="' + BASE_HREF_ADMIN + '/' + module + '/template/'+ node.id +'" class="ajax-modal" data-target="#myModal">' + (node.template ? node.template : '-') + '</a>] ' +
                                '<a href="' + BASE_HREF + '/'+ node.path +'" target="_blank" class="demo">show</a> ' +
                                '<a href="' + BASE_HREF_ADMIN + '/' + module + '/act/'+ node.id +'" class="ajax act">act</a> ' +
                                '<a href="' + BASE_HREF_ADMIN + '/' + module + '/create/'+ node.id +'" class="ajax-modal" data-target="#myModal">add</a> ' +
                                '<a href="' + BASE_HREF_ADMIN + '/' + module + '/'+ node.id +'/edit" class="ajax-modal" data-target="#myModal">edit</a> ' +
                                '<a href="' + BASE_HREF_ADMIN + '/' + module + '/'+ node.id +'" class="ajax delete">delete</a>'
                            );
                        }            
                    });

                    tree.bind(
                        'tree.move',
                        function(event) {

                            $.ajax({
                               type: "PUT",
                               url: BASE_HREF_ADMIN + '/' + module + '/' + event.move_info.moved_node.id,
                               dataType: 'json',
                               data: {
                                  _token: _token, 
                                  action: 'move',  
                                  parent:  event.move_info.target_node.id,
                                  position: event.move_info.position,
                                  pp: event.move_info.previous_parent.id
                               },
                               success: function(response){ 

                                    reload_tree(tree);

                               }

                           });

                        }
                    );        

                });   
            
            }
         
        }
        
    }
    
    function modal_mark(modal) {
        
        title = modal.find('input[name="name"]').val();
        modal.find('.modal-title').text(title ? title : 'Добавить');
        
    }
    
    $.prettyLoader();
    
    $(document).on("form-pre-serialize", "form", function(e) {
        
        tinymce_save();
        tinymce.triggerSave();
        
    });
    
    $(document).on("focus", "form.auto-validation", function(e) {
       
        var form = $(this);
       
        if (!form.data('validation')) {
       
            form.ajaxSubmit({ 
                dataType: 'json',
                data: {_token: _token, make: 'validation'},
                success: function (response) {
                    
                    form.data('validation', true);
                    form.validate(validParse(response));

                }       
             });       
         
        }
       
    });
    
    $(document).on("click", "a.uploader-part", function(e) {
        
        var part = $(this).data('part');
        $('#uploader-image').data('part', part);
        
    });
    
    $(document).on("click", ".modal button.save", function(e) {
        
        var modal = $(this).parents('.modal');
        var form = modal.find('form');
        
        if (form) {
        
            form.ajaxSubmit({ 
                dataType: 'json',
                success: function (response, status, xhr, form) {

                    if (response.error) {
                        
                        showError(form, response.messages);
                        
                    }

                    if (response.result) {

                        reload_tree($('#tree-' + response.module));
                        //modal.modal('hide');
                    
                    }

                }       
            });
        
        }
        
    });
    
    $(document).on("click", "a.ajax-modal", function(e) {

        link = $(this);
        target_modal = $(this).data('target');
        target = $(target_modal + ' .modal-body');

        option = {
           type: "GET",
           url: link.attr('href'),
           success: function(response){ 

               if (target) { 

                   if (response.list) {
                       
                       $(target).html(response.list);
                       
                   } else {
                       
                       $(target).html(response);
                       
                   }


                   $(target_modal).modal('show');
                   
                   modal_mark($(target_modal));
                   
                   load_uploader(target);
                   sortable();
                   tabs();
                   prettyphoto();
                   cropInit();
                   tinymce_load($(target));
                   //tinymce.init({selector: '.tinymce'});
                   
               }

           }

       };

        $.ajax(option);

        return false;

     });  
     
    $(document).on("click", "a.ajax", function(e) {

        link = $(this);
        type = 'GET';
        target = null;
        dataType = 'json';
        t = link.data('target');
        
        if (t) {
            
            target = $(t);
            dataType = 'html';
            
        }
        
        if (link.hasClass('delete-warning')) {
            
            if (!confirm('Вы действительно хотите удалить элементы?')) {
                
                return false;
                
            }
            
        }        
        
        if (link.hasClass('delete')) {
            
            type = 'DELETE';
            target = null;
            
        }
        
        if (link.hasClass('intab')) {
            
            target = link.parents('.ui-tabs-panel');
            
        }

        option = {
           type: type,
           dataType: dataType,
           url: link.attr('href'),
           data: {_token: _token},
           success: function(response){ 

               if (target) { 

                   target.html(response);
                   
                   load_tree(target.find('.tree-view'));
                   sortable();
                   load_uploader(target);
                   //dataTable();
                   prettyphoto();

               }
               
               if (response.module == 'site' || response.module == 'menu' && response.result) {
                   
                   reload_tree($('#tree-' + response.module));
                   
               }
               
               if (response.action == 'destroy' && response.result) {

                   link.parents('.item').fadeOut();
                   li = link.parent().parent();
                   
                   if (li.hasClass('jqtree_common')) {
                       
                       li.fadeOut();
                       
                   }
                   
               }           
               
               if (response.action == 'act' && response.result) {

                   if (link.hasClass('act')) {
                       
                       act_image = response.act ? 'full' : 'empty';
                       url_image = BASE_HREF + '/assets/images/checkbox_' + act_image + '.png';
                       link.find('img').attr('src', url_image);
                       
                   }


                   node = link.parent().parent();
                   node.toggleClass('disabled');
                   
                   if (node.hasClass('disabled')) {
                       
                       node.find('li').addClass('disabled');
                       
                   } else {
                       
                       node.addClass('enabled');
                       node.find('li.enabled').removeClass('disabled');
                       
                   }
                   
               }               

           }

        };

        $.ajax(option);

        return false;

     });  

    $(document).on("click", "a.add-make", function() {

        $(this).parent().after('<div class="' + $(this).parent().attr('class') + '">' + $(this).parent().html() + '</div>');

        return false;

    });

    $(document).on("click", "a.delete-make", function() {

        $(this).parent().remove();

        return false;

    });
    
    $(document).on("click", "a.delete-variant", function() {

        $(this).parents('li').remove();

        return false;

    });
    
    $(document).on("click", "a.add-content", function() {
        
        tm_content = 'tm_content' + $(this).data('site');
        img_src = $(this).parents('li').find('img.image').attr('src');
        img_id = $(this).data('id');
        view = $(this).data('view');
        
        option = {
            url: BASE_HREF_ADMIN + '/image/content/' + img_id + '/' + view,
            success: function(response) { 
                
                tm_list[tm_content].execCommand('mceInsertContent', false, response);
                                
            }

        };

        $.ajax(option);        

        return false;
        
    });

    $(document).on("click", "a.add-variation", function() {

        var item = $('#image-variation ul li:first').html();
        var new_variation = $('#new-variation-name').val();
        var start_variation = '';

        $('#image-variation ul li:first').find('select, input').each(function() {

           arr = $(this).attr('name').split('][');
           item = item.replace('[' + arr[1] + ']', '[' + new_variation + ']');

        });

        $('#image-variation ul').append('<li>'+ item + '</li>');
        $('#image-variation ul li:last .variant-title').text(new_variation);

        $('#image-variation ul li-last').find('input').each(function() {
            $(this).val(0);
        });

        return false;

    });
    
    $(document).on("change", 'input', function() {
        
        $(this).removeClass('error');
        
    });
    
    $(document).on("change", 'input[name="reload"]', function(e) {
        
        form = $(this).parents('form');
        
        if ($(this).prop('checked')) {
            
            form.find('input[name="file"]').attr('type', 'file');
            form.find('.rename').hide();
            
        } else {
            
            form.find('input[name="file"]').attr('type', 'text');
            form.find('.rename').show();
            
        }
        
    });
    
    $(document).on("change", ".uploader-video input", function(e) {

        th = $(this);

        var uploader = th.parents('.uploader-video');
        var target = uploader.data('target');
        var target_type = uploader.data('target-type') ? uploader.data('target-type') : 'load';
        
        var data = {};
        
        data['act'] = 1;
        data['name'] = 'name';
        data['text'] = 'text';
        data['url'] = th.val();
        
        data['model'] = uploader.data('model');
        data['model_id'] = uploader.data('model-id');
        data['part'] = uploader.data('part');
        
        data['_token'] = _token;

        if (target) {
            
            data['_target'] = 1;
            
        }

        option = {
            type: "POST",
            dataType: 'json',
            url: BASE_HREF_ADMIN + '/video',
            data: data,
            success: function(response) { 
                
                showResult(target, target_type, response);
                th.val('');
                
            }

        };

        $.ajax(option);

        return false;

     });    
     
    $(document).on('focusin', function(e) {
        
        if ($(e.target).closest(".mce-window").length) {
            
            e.stopImmediatePropagation();
            
        }
        
    });
    
    
    $(document).on("click", ".image-show-full", function(e) {
    
        block = $(this).parents('#image-list');
        
        if (block.hasClass('image-full')) {
            
            block.addClass('image-icon').removeClass('image-full');
            $(this).text('Расширенный');
            
        } else {
            
            block.addClass('image-full').removeClass('image-icon');
            $(this).text('Простой');
            
        }
        
        return false;
    
    });
    
    function translate2(name, b, type, target) {
        
        function setpath(input, path) {

            old = input.val().split('/');
            old[old.length - 1] = path;
            input.val(old.join('/').replace(/ /g, "-").toLowerCase());
            input.change();

        }
        
        function renamefile(input, name) {

            old = input.val().split('.');
            old[0] = name;
            input.val(old.join('.').replace(/ /g, "-").toLowerCase());
            input.change();

        }

        if (type == 'en') {

            var yandexTranslate = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
            var key = 'trnsl.1.1.20130803T122909Z.04ff8a64193562d2.8cdfbc7b059eb57577e50eef1ebcaea5ca11bf6b';

            $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: yandexTranslate + '?key=' + key + '&lang=ru-en&text=' + name,
                    success: function(response){

                       if (target == 'path') { 
                           
                            setpath(b, response.text);
                            
                       }
                       
                       if (target == 'file') { 
                           
                            renamefile(b, response.text);
                            
                       }

                    }
                });                 

        } else if (type == 'trans') {

            if (target == 'path') { 

                setpath(b, transliterate(name));
                
            }

            if (target == 'file') { 

                renamefile(b, transliterate(name));

            }

        } else {

            if (target == 'path') { 

                setpath(b, name);
            
            }
            
            if (target == 'file') { 

                renamefile(b, name);

            }            

        }        
        
    }
    
    $(document).on("click", ".autopath", function(e) {

        var name = '', b = '';
        var form = $(this).parents('form');
        var target = $(this).data('target');
        var type = $(this).data('type');
        
        if ($(this).hasClass('image-full')) {
            
            name = $(this).parents('.full').find('input[name="n[]"]').val();
            b = $(this).parents('.full').find('input[name="f[]"]');
            
        } else {
            
            name = form.find('input[name="name"]').val();
            
            if (target == 'path') { 

                b = form.find('input[name="path"]');

            }

            if (target == 'file') { 

                b = form.find('input[name="file"]');

            }
            
        }

        translate(name, b, type, target);

    });       
    

});