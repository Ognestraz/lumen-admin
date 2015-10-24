<header class="entry-header">
    <ol class="breadcrumb">
        <?php foreach ($site->breadCrumbs() as $item) { ?>
            <li><a href="<?=$item['link']?>"><?=$item['name']?></a></li>
        <?php } ?>
        <li class="active"><?=$site->name?></li> 
    </ol>
</header>