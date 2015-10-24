<div class="uploader-image" data-target="#image-list .list-group" data-target-type="prepend"
     data-model="<?=Input::get('model')?>" data-model-id="<?=Input::get('model_id', 0)?>" data-part="<?=Input::get('part', 'main')?>">
    <div class="js-fileapi-wrapper">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="file" name="file" />
    </div>
    <div data-fileapi="active.show" class="progress">
        <div data-fileapi="progress" class="progress__bar"></div>
    </div>
</div>

<div id="image-list">

    <a class="ajax delete-warning" href="<?=url('admin').'/image/items/delete?model='.Input::get('model').'&model_id='.Input::get('model_id').'&part='.Input::get('part')?>">Удалить все</a>
    <ul class="sortable list-group" data-controller="image">
        <?php foreach ($list as $image) {   

            echo view('admin::image.item-content', array('image' => $image));

        } ?>
    </ul>

</div>

<div style="clear:both;"></div>