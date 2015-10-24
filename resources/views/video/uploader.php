<?php

    $part = Input::get('part') ? Input::get('part') : 'main';
    
    $list_part = array('main' => 'Главная',
        'album' => 'Альбом',
        'content' => 'Контент');

?>

<div class="subtabs-site">
    <ul>
        <?php foreach ($list_part as $key => $item) { ?>
            <li>
                <a class="ajax uploader-part" data-part="<?=$key?>" data-target="#video-list" href="<?=url('/admin').'/video/upload?model='.Input::get('model').'&model_id='.Input::get('model_id', 0).'&part='.$key.'&view=list'?>"><?=$item?></a>
            </li>
        <?php } ?>    
    </ul>
</div>

<div style="clear:both;"></div>

  