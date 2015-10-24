<form class="js-ajax" action="<?=url('/')."/admin/image".($image->id ? '/'.$image->id : '')?>" method="POST" enctype="multipart/form-data"> 
    <input type="hidden" name="_token" value="<?=csrf_token();?>">
     <?php if ($image->id) { ?>
       <input type="hidden" name="id" value="<?=$image->id?>" /> 
       <input type="hidden" name="_method" value="PUT" />
    <?php } ?>

    <input type="hidden" name="model" value="<?=($image->model ? $image->model : Input::get('model'))?>" /> 
    <input type="hidden" name="model_id" value="<?=($image->model_id ? $image->model_id : Input::get('model_id', 0))?>" /> 

    <div class="row">
        <div class="col-lg-5">
            <div class="form-group">
                <label>Название</label>
                <input class="form-control" placeholder="Name image" name="name" value="<?=$image->name?>">
            </div>
            <div class="form-group">
                <label>Путь</label>
                <input class="form-control" placeholder="Image path" name="url" value="<?=$image->path?>">
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control" rows="3"><?=$image->description?></textarea>
            </div>
            <div class="form-group">                  
                <button type="submit" class="btn btn-default">Сохранить</button>
            </div>            
        </div>
        <div class="col-lg-7">
            <div id="tabs" class="js-tabs">
                <ul class="nav nav-tabs js-tabs">
                    <li class="active"><a href="#sub-tabs-5" data-url="<?=url('/admin').'/image/'.$image->id.'/edit?variant=original'?>" data-toggle="tab">Оригинал</a></li>
                    <li><a href="#sub-tabs-5" data-url="<?=url('/admin').'/image/'.$image->id.'/edit?variant=icon'?>" data-toggle="tab">Icon</a></li>
                    <li><a href="#sub-tabs-5" data-url="<?=url('/admin').'/image/'.$image->id.'/edit?variant=preview'?>" data-toggle="tab">Preview</a></li>
                    <li><a href="#sub-tabs-5" data-url="<?=url('/admin').'/image/'.$image->id.'/edit?variant=large'?>" data-toggle="tab">Large</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="sub-tabs-5">
                        <?= view('admin::image.variant', array('image' => $image, 'variant' => 'original')); ?>
                    </div>
                </div>
            </div>
        </div>                        
    </div>    
</form>