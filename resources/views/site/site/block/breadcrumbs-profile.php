<?php 

    $listRole = array('Участник', 'Актер', 'Фотограф', 'СМИ');
    
?>

<header class="entry-header">
        <ol class="breadcrumb">
            <?php foreach ($site->breadCrumbs() as $item) { ?>
                <li><a href="<?=$item['link']?>"><?=$item['name']?></a></li>
            <?php } ?>
            <li class="active"><?=$site->name?></li>
            <li class="active"><?=$listRole[$user->role_id - 1]?></li>
            <li class="active"><?=$user->fio?> (<a href="/logout">Выход</a>)</li> 
        </ol>
</header>