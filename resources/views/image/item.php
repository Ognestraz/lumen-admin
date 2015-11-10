<li data-id="<?=$image->id?>" class="js-list-group-item js-item<?=($image->act ? '' : ' disabled')?>">
    <img src="<?=subdomainImage($image->src('icon'))?>" class="image" />
    <a href="<?=url('/')?>/admin/image/act/<?=$image->id?>" class="act img-checkbox <?=($image->act ? 'enabled' : 'disabled')?> js-ajax"></a>
    <a href="<?=url('/')?>/admin/image/<?=$image->id?>/edit" class="edit js-ajax" data-target="#image-area">
        <img src="<?=url('/')?>/assets/images/edit.png">
    </a>
    <a href="<?=url('/')?>/admin/image/<?=$image->id?>" class="js-ajax delete">
        <img src="<?=url('/')?>/assets/images/delete.png">
    </a>
    <a href="<?=subdomainImage($image->src())?>" rel="prettyPhoto[image]" class="zoom">
        <img src="<?=url('/')?>/assets/images/zoom.png">
    </a>
    <div class="full">
        <div class="row">
            <div class="col-lg-5 pr0">
                <div class="form-group-sm">
                    <label class="sm-label">Название</label>
                    <input type="text" data-name="name" value="<?=$image->name?>" placeholder="Название" class="form-control sm-form-controller" />
                </div>                
                <div class="form-group-sm mb5">
                    <label class="sm-label">Имя файла</label>
                    <div class="input-group">
                        <input type="text" data-name="path" value="<?=$image->path?>" placeholder="Имя файла" class="form-control sm-form-controller" />
                        <span class="input-group-btn">
                            <button class="btn btn-default js-image-full js-autopath" data-target="file" data-type="ru" type="button">R</button>
                            <button class="btn btn-default js-image-full js-autopath" data-target="file" data-type="en" type="button">E</button>
                            <button class="btn btn-default js-image-full js-autopath" data-target="file" data-type="trans" type="button">T</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 pr0">
                <label class="sm-label">Описание</label>
                <textarea data-name="description" class="form-control" rows="3"><?=$image->description?></textarea>
            </div>            
            <div class="col-lg-2 pr0">
                <br />
                <br />
                <br />
                <button class="js-save-image btn btn-default">Сохранить</button>  
            </div>
        </div>
    </div>
</li>