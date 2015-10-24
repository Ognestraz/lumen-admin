<? $listPaginate = $list->paginate(2); ?>

<div class="row">
    <div class="col-sm-12">
        <ol class="childs site-list">
            <?=View::make('site.items.list', array('list' => $listPaginate));?>    
        </ol>
    </div>
</div>

<div class="pagination-ajax" data-target=".site-list">
    <?=\Site::pagination($list, $listPaginate);?>
</div>