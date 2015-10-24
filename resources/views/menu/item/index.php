<div class="row">
    <div class="col-sm-12">
        <ol class="breadcrumb">
                <li>
                        <i class="clip-home-3"></i>
                        <a href="#">
                                Home
                        </a>
                </li>
                <li class="active">
                        Menu
                </li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
            <!-- start: DRAGGABLE HANDLES 1 PANEL -->
            <div class="panel panel-default">
                    <div class="panel-heading">
                            <i class="icon-reorder"></i>
                            Пункты меню <a href="<?=url('/')?>/admin/menu/create" class="ajax-modal" data-target="#myModal">add</a>
                    </div>
                    <div class="panel-body">
                        <ul class="sortable list-group" data-module="menu">
                        <? foreach ($menu_item_list as $item) {?>
                        
                            <li data-id="<?=$item->id?>" class="list-group-item item">
                                <?=$item->name?>
                                <a href="<?=url('admin/menu/'.$item->id.'/edit')?>" class="ajax-modal" data-target="#myModal">edit</a>
                                <a href="<?=url('admin/menu/'.$item->id)?>" class="ajax delete">del</a>
                            </li>
                        
                        <? } ?>
                        </ul>
                        
                    </div>
            </div>
            <!-- end: DRAGGABLE HANDLES 1 PANEL -->
    </div>

    
</div>