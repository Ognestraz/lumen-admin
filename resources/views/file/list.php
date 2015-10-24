<div class="uploader-file" data-target="#file-list .list-group" data-target-type="prepend"
     data-model="<?=Input::get('model')?>" data-model-id="<?=Input::get('model_id', 0)?>" data-part="<?=Input::get('part', 'main')?>">
     <input type="text" name="url" placeholder="Ссылка на видео" style="width: 400px;" />
</div>

<div id="file-list">
    <a class="ajax delete-warning" href="<?=url('admin').'/file/items/delete?model='.Input::get('model').'&model_id='.Input::get('model_id').'&part='.Input::get('part')?>">Удалить все</a>
    <ul class="sortable list-group" data-controller="file">
        <?php foreach ($list as $file) {   

            echo view('admin::file.item', array('file' => $file));

        } ?>
    </ul>
</div>

<div style="clear:both;"></div>

