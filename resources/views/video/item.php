<li data-id="<?=$video->id?>" class="list-group-item item">
    <img src="<?=$video->preview?>" class="video" />
    <?=$video->name?>
    <a href="<?=url('/')?>/admin/video/act/<?=$video->id?>" class="act ajax">
        <img src="<?=url('/')?>/assets/images/checkbox_<?=($video->act ? 'full' : 'empty')?>.png">
    </a>
    <a href="<?=url('/')?>/admin/video/<?=$video->id?>/edit" class="edit ajax-modal" data-target="#subModal">
        <img src="<?=url('/')?>/assets/images/edit.png">
    </a>
    <a href="<?=url('/')?>/admin/video/<?=$video->id?>" class="ajax delete">
        <img src="<?=url('/')?>/assets/images/delete.png">
    </a>
    <a href="<?=$video->url . (stripos($video->url, 'vk.com') !== false ? '&iframe=true' : '')?>" rel="prettyPhoto" class="zoom">
        <img src="<?=url('/')?>/assets/images/zoom.png">
    </a>
    <div class="full">
        <div class="row">
            <div class="col-lg-5 pr0">
                <div class="form-group-sm">
                    <label class="sm-label">Название</label>
                    <input type="text" data-name="name" value="<?=$video->name?>" placeholder="Название" class="form-control sm-form-controller" />
                </div>                
                <div class="form-group-sm mb5">
                    <label class="sm-label">Имя файла</label>
                    <div class="input-group">
                        <input type="text" data-name="path" value="<?=$video->path?>" placeholder="Имя файла" class="form-control sm-form-controller" />
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
                <textarea data-name="description" class="form-control" rows="3"><?=$video->description?></textarea>
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