<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?=url('/admin')."/file"?>" class="js-ajax" data-target="#page-wrapper">Документы и файлы</a> / 
                <?=(($file->id) ? 'Редактирование: ' . $file->name : 'Добавление')?>                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="js-ajax" action="<?=url('/')."/admin/file".($file->id ? '/'.$file->id : '')?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?=csrf_token();?>">
                     <?php if ($file->id) { ?>
                       <input type="hidden" name="id" value="<?=$file->id?>" /> 
                       <input type="hidden" name="_method" value="PUT" />
                    <?php } ?>

                    <input type="hidden" name="model" value="<?=($file->model ? $file->model : Input::get('model'))?>" /> 
                    <input type="hidden" name="model_id" value="<?=($file->model_id ? $file->model_id : Input::get('model_id', 0))?>" /> 

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Загрузка файла</label>
                                <input type="file" name="filename" />
                            </div>
                            <div class="form-group">
                                <label>Название</label>
                                <input class="form-control" placeholder="File name" name="name" value="<?=$file->name?>">
                            </div>
                            <div class="form-group">
                                <label>Путь</label>
                                <input class="form-control" placeholder="File path" name="path" value="<?=$file->path?>">
                            </div>
                            <div class="form-group">
                                <label>Описание файла</label>
                                <textarea name="description" class="form-control" rows="3"><?=$file->description?></textarea>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="row">
                        <div class="col-lg-12">                    
                            <button type="submit" class="btn btn-default">Сохранить</button>
                            <button type="submit" class="btn btn-default" data-make="to-add">Сохранить и добавить</button>
                            <button type="submit" class="btn btn-default" data-make="to-list">Сохранить и вернуться к списку</button>
                            <a href="<?=url('/admin')."/file"?>" class="js-ajax btn btn-danger" data-target="#page-wrapper">Отмена</a>
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