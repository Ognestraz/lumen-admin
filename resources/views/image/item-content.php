<li data-id="<?=$image->id?>" class="list-group-item item">
    <img src="<?=subdomainImage($image->src('icon'))?>" class="image" />
    <?=$image->name?>
    <a href="<?=url('/')?>/admin/image/act/<?=$image->id?>" class="act ajax">
        <img src="<?=url('/')?>/assets/images/checkbox_<?=($image->act ? 'full' : 'empty')?>.png">
    </a>
    <a href="<?=url('/')?>/admin/image/<?=$image->id?>/edit" class="edit ajax-modal" data-target="#subModal">
        <img src="<?=url('/')?>/assets/images/edit.png">
    </a>
    <a href="<?=url('/')?>/admin/image/<?=$image->id?>" class="ajax delete">
        <img src="<?=url('/')?>/assets/images/delete.png">
    </a>
    <a href="<?=subdomainImage($image->src())?>" class="zoom add-content" data-view="image" data-id="<?=$image->id?>" data-site="<?=$image->imageable->id?>">
        <img src="<?=url('/')?>/assets/images/zoom.png">
    </a>
</li>