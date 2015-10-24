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
                        Role
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
                            Роли - <a href="<?=url('/')?>/admin/role/create"  class="ajax-modal" data-target="#myModal">добавить</a>
                    </div>
                    <div class="panel-body">
                        <ul class="sortable list-group" data-controller="role">
                        <? foreach ($role_list as $role) {?>
                        
                            <li data-id="<?=$role->id?>" class="list-group-item item">
                                <?=$role->name?>
                                <a href="<?=url('/')?>/admin/image/upload?module=role&module_id=<?=$role->id?>" class="ajax-modal" data-target="#myModal">Uploader</a>
                                <a href="<?=url('/')?>/admin/image/create?module=role&module_id=<?=$role->id?>" class="ajax-modal" data-target="#myModal">add Image</a>
                                <a href="<?=url('/')?>/admin/role/act/<?=$role->id?>" class="ajax act">act</a>
                                <a href="<?=url('/')?>/admin/role/<?=$role->id?>/edit"  class="ajax-modal" data-target="#myModal">edit</a>
                                <a href="<?=url('/')?>/admin/role/<?=$role->id?>"  class="ajax delete">del</a>
                            </li>
                        
                        <? } ?>
                        </ul>
                        
                    </div>
            </div>
            <!-- end: DRAGGABLE HANDLES 1 PANEL -->
    </div>

    
</div>