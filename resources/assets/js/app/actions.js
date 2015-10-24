function translate(name, b, type, target) {
        
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


$(document).ready(function() {
    
    function reloadTree(tree) {
        
        if (tree.data('module')) {
        
            tree_url = BASE_HREF_ADMIN + '/' + tree.data('module') + '/tree';

            $.getJSON(tree_url, function(new_data) {

                tree.tree('loadData', new_data);

            });   
        
        }
                
    }
    
    function loadTree(tree) {
        
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
                                ' - ' + node.path + ' - ' + 
                                '[<a href="' + BASE_HREF_ADMIN + '/' + module + '/template/'+ node.id +'" class="ajax-modal" data-target="#myModal">' + (node.template ? node.template : '-') + '</a>] ' +
                                '<a href="' + BASE_HREF + '/'+ node.path +'" target="_blank" class="demo">show</a> ' +
                                '<a href="' + BASE_HREF_ADMIN + '/' + module + '/act/'+ node.id +'" class="ajax act">act</a> ' +
                                '<a href="' + BASE_HREF_ADMIN + '/' + module + '/create/'+ node.id +'" class="js-ajax btn btn-xs btn-default" data-target="#page-wrapper">add</a> ' +
                                '<a href="' + BASE_HREF_ADMIN + '/' + module + '/'+ node.id +'/edit" class="js-ajax btn btn-xs btn-default" data-target="#page-wrapper">edit</a>' +
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
                                  make: 'move',  
                                  parent:  event.move_info.target_node.id,
                                  position: event.move_info.position,
                                  pp: event.move_info.previous_parent.id
                               },
                               success: function(response){ 

                                    reloadTree(tree);

                               }

                           });

                        }
                    );        

                });   
            
            }
         
        }
        
    }    
   
    var ajaxCallback = function(response) { 

        if (target) { 

           target.html(response);
           initDataTable(controllerSettings);
           loadTree(target.find('.tree-view'));
           initTinymce(target);

           initTabs();
           cropInit(target);
           
           inBlock($('#tab-site-load'), $('#tab-site'));

        }

        if (response.module === 'site' || response.module === 'menu' && response.result) {
            reloadTree($('#tree-' + response.module));
        }

        if (response.action === 'destroy' && response.result) {
            if ($('.dataTable').has(link).length) {
                table = link.parents('.dataTable').DataTable();
                table.row(link.parents('.js-item')).remove().draw(false);
            } else {
                link.parents('.js-item').fadeOut().remove();
            }
        }           

        if (response.action === 'act' && response.result) {
            if (link.hasClass('act')) {
                if (response.data.act) {
                    link.parents('.js-item').removeClass('disabled');
                    link.removeClass('disabled').addClass('enabled');
                } else {
                    link.parents('.js-item').addClass('disabled');
                    link.removeClass('enabled').addClass('disabled');
                }
            }
        }               
    };
    
    function ajaxRedirect(url, target) {
        
        target = $(target);
        
        option = {
           type: 'GET',
           url: url,
           /*data: {_token: _token},*/
           success: ajaxCallback
        };

        $.ajax(option);        
        
    }
    
    
    $(document).on("click", "a.js-ajax", function(e) {

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
           success: ajaxCallback
        };

        $.ajax(option);

        return false;

     });  

    $(document).on("click", 'form.js-ajax button[type="submit"]', function(e) {
        if ($(this).data('make')) {
            $(this).parents('form.js-ajax').data('make', $(this).data('make'));
        }
    });

    $(document).on("submit", "form.js-ajax", function(e) {

        //var modal = $(this).parents('.modal');
        var form = $(this);
        var make = form.data('make');
        
        console.log(make);
        
        form.ajaxSubmit({ 
            dataType: 'json',
            success: function (response, status, xhr, form) {

                if (response.error) {

                    //showError(form, response.messages);

                }

                if (response.result) {

                    if ('to-add' === make) {
                        ajaxRedirect('/' + response.controller + '/create', '#page-wrapper');
                    }
                    
                    if ('to-list' === make) {
                        ajaxRedirect('/' + response.controller, '#page-wrapper');
                    }

                }

            }       
        });

        return false;
        
    });
    
    $(document).on("click", ".js-show", function(e) {
    
        block = $('.js-icon-list');
        group = $(this).parents('.btn-group');
        show = $(this).data('show');
        
        if ('icon' === show) {
            block.addClass('image-icon').removeClass('image-full');
        } else {
            block.addClass('image-full').removeClass('image-icon');
        }
        
        group.find('.js-show').removeClass('active');
        $(this).addClass('active');            
        
        return false;
    
    });    
    
    $(document).on("click", ".js-show-list", function(e) {
    
        block = $('#image-list');
        block.addClass('image-full').removeClass('image-icon');
        $(this).addClass('active');

        return false;
    
    });    
    
    $(document).on("click", ".js-autopath", function(e) {

        var name = '', b = '';
        var form = $(this).parents('form');
        var target = $(this).data('target');
        var type = $(this).data('type');
        
        if ($(this).hasClass('js-image-full')) {
            
            name = $(this).parents('.full').find('input[data-name="name"]').val();
            b = $(this).parents('.full').find('input[data-name="path"]');
            
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
    
    $(document).on("change", ".image-full .js-list-group-item input, .image-full .js-list-group-item textarea", function(e) {
        var block = $(this).parents('li');
        block.addClass('form-block-warning');
    });
    
    
    $(document).on("click", "button.js-save-image", function(e) {
    
        var block = $(this).parents('li');
        var id = block.data('id');
        var file = block.find('input[data-name="path"]').val();
        var name = block.find('input[data-name="name"]').val();
        var desc = block.find('textarea[data-name="description"]').val();
        
        option = {
            type: "PUT",
            dataType: 'json',
            url: BASE_HREF_ADMIN + '/image/' + id,
            data: {
                path: file,
                name: name,
                description: desc,
                _token: _token
            },
            success: function(response) { 

                block.removeClass('form-block-warning');

                if (response.errors) {

                    block.addClass('form-block-error');
                    block.removeClass('form-block-success');
                    showError(block, response.messages);

                } else {
                    
                    block.removeClass('form-block-error');                    
                    block.addClass('form-block-success');                    
                    
                }

            }

        };

        $.ajax(option);        
        
        return false;
    
    });    
    
    $(document).on("change", ".js-uploader-video input", function(e) {

        th = $(this);

        var uploader = th.parents('.js-uploader-video');
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

     })    
    
});