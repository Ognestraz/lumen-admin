<div class="panel panel-default mt10">
    <div class="panel-heading">
        Загрузка фотографий
        <div class="pull-right">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-xs js-show active" data-show="icon">
                    Иконки
                </button>                
                <button type="button" class="btn btn-default btn-xs js-show" data-show="list">
                    Список
                </button>                
                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    Действия
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>
                        <a class="js-ajax js-delete-warning" href="<?=url('admin').'/image/items/delete?model='.Input::get('model').'&model_id='.Input::get('model_id').'&part='.Input::get('part')?>">Удалить все</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-body uploader-image" id="image-area" 
        data-target=".js-list-group" data-target-type="prepend"
        data-model="<?=Input::get('model')?>" data-model-id="<?=Input::get('model_id', 0)?>"
        data-part="<?=Input::get('part', 'main')?>">
        <div class="row">
            <div class="col-lg-4">
                <div>
                    <div class="form-control js-fileapi-wrapper">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="file" name="filename" />
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="progress progress-bar-file-api">
                    <div id="fileapi-progress" data-fileapi="progress" class="progress__bar"></div>
                </div>
            </div>    
        </div>
        <div class="row">
            <div class="col-lg-12">
                <hr class="mb10" />
                <div class="js-icon-list image-icon-list image-icon fixed-image-panel">
                    <ul class="js-sortable js-list-group" data-controller="image">
                        <?php foreach ($list as $image) {   
                            echo view('admin::image.item', array('image' => $image));
                        } ?>
                    </ul>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>        
    </div>
</div>