<div class="panel panel-default mt10">
    <div class="panel-heading">
        Загрузка видео
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
                        <a class="js-ajax js-delete-warning" href="<?=url('admin').'/video/items/delete?model='.Input::get('model').'&model_id='.Input::get('model_id').'&part='.Input::get('part')?>">Удалить все</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-body js-uploader-video" id="video-area"
        data-target="#video-list .list-group"
        data-target-type="prepend"
        data-model="<?=Input::get('model')?>" data-model-id="<?=Input::get('model_id', 0)?>"
        data-part="<?=Input::get('part', 'main')?>">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="text" name="url" class="form-control" placeholder="Ссылка на видео" />
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div id="video-list">
                    <ul class="js-icon-list icon-list sortable list-group" data-controller="video">
                        <?php foreach ($list as $video) {   

                            echo view('admin::video.item', array('video' => $video));

                        } ?>
                    </ul>
                </div>
            </div> 
        </div>        
    </div>
</div>
