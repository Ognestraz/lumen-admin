<? foreach ($list as $item) { ?>
    <li>
            <i class="clip-home-3"></i>
            <a href="<?=url('/').'/'.$item->path?>">
                    <?=$item->name?>
            </a>
    </li>
<? } ?>    

