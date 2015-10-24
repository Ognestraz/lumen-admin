<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?=url('/')."/admin/video"?>" class="js-ajax" data-target="#page-wrapper">Видео</a> / 
                <?=(($video->id) ? 'Редактирование: ' . $video->name : 'Добавление')?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="js-ajax" action="<?=url('/')."/admin/video".($video->id ? '/'.$video->id : '')?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?=csrf_token();?>">
                     <?php if ($video->id) { ?>
                       <input type="hidden" name="id" value="<?=$video->id?>" /> 
                       <input type="hidden" name="_method" value="PUT" />
                    <?php } ?>

                    <input type="hidden" name="model" value="<?=($video->model ? $video->model : Input::get('model'))?>" /> 
                    <input type="hidden" name="model_id" value="<?=($video->model_id ? $video->model_id : Input::get('model_id', 0))?>" /> 

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Название</label>
                                <input class="form-control" placeholder="Name video" name="name" value="<?=$video->name?>">
                            </div>
                            <div class="form-group">
                                <label>Ссылка на видео</label>
                                <input class="form-control" placeholder="Video url" name="url" value="<?=$video->url?>">
                            </div>
                            <div class="form-group">
                                <label>Описание видео</label>
                                <textarea name="description" class="form-control" rows="3"><?=$video->description?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Ссылка превью</label>
                                <input class="form-control" placeholder="Preview url" name="preview" value="<?=$video->preview?>">
                            </div>                    
                            <?php if ($video->preview) {?>
                                <div class="form-group">
                                    <img src="<?=$video->preview?>" class="img-responsive img-thumbnail" />
                                </div>
                            <?php } ?>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">                    
                            <button type="submit" class="btn btn-default">Сохранить</button>
                            <button type="submit" class="btn btn-default" data-make="to-add">Сохранить и добавить</button>
                            <button type="submit" class="btn btn-default" data-make="to-list">Сохранить и вернуться к списку</button>
                            <a href="<?=url('/admin')."/video"?>" class="js-ajax btn btn-danger" data-target="#page-wrapper">Отмена</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>