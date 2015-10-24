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
                        User
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
                            Пользователи - <a href="<?=url('/')?>/admin/user/create"  class="ajax-modal" data-target="#myModal">добавить</a>
                    </div>
                    <div class="panel-body">
                        <ul class="sortable list-group" data-controller="user">
                        <?php foreach ($user_list as $user) {?>
                        
                            <li data-id="<?=$user->id?>" class="list-group-item item">
                                <?=$user->name?>
                                <a href="<?=url('/')?>/admin/image/upload?module=user&module_id=<?=$user->id?>" class="ajax-modal" data-target="#myModal">Uploader</a>
                                <a href="<?=url('/')?>/admin/image/create?module=user&module_id=<?=$user->id?>" class="ajax-modal" data-target="#myModal">add Image</a>
                                <a href="<?=url('/')?>/admin/user/act/<?=$user->id?>" class="ajax act">act</a>
                                <a href="<?=url('/')?>/admin/user/<?=$user->id?>/edit"  class="ajax-modal" data-target="#myModal">edit</a>
                                <a href="<?=url('/')?>/admin/user/<?=$user->id?>"  class="ajax delete">del</a>
                            </li>
                        
                        <?php } ?>
                        </ul>
                        
                    </div>
            </div>
            <!-- end: DRAGGABLE HANDLES 1 PANEL -->
    </div>

    
</div>