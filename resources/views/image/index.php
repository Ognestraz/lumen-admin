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
                        Image
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
                            Изображения - <a href="<?=url('/')?>/admin/image/create"  class="ajax-modal" data-target="#myModal">добавить</a>
                    </div>
                    <div class="panel-body">
                        <ul class="sortable list-group" data-controller="image">
                        <?php foreach ($list as $image) {?>
                        
                            <li data-id="<?=$image->id?>" class="list-group-item item">
                                <img src="<?=$image->src('icon')?>" />
                                <?=$image->name?>
                                <a href="<?=url('/')?>/admin/image/<?=$image->id?>/edit"  class="ajax-modal" data-target="#myModal">edit</a>
                                <a href="<?=url('/')?>/admin/image/<?=$image->id?>"  class="ajax delete">del</a>
                            </li>
                        
                        <?php } ?>
                        </ul>
                        
                    </div>
            </div>
            <!-- end: DRAGGABLE HANDLES 1 PANEL -->
    </div>

    
</div>