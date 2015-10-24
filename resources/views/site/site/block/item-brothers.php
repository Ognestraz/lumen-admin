<div class="well traditions-list">

    <div class="row">
        <? foreach ($site->brothers()->orderBy(DB::raw('RAND()'))->limit(4)->get() as $brother) { ?> 

            <div class="col-sm-3 col-xs-6 image-item">

                    <a href="<?=$brother->link()?>">
                        <? 
                            $image = $brother->image();

                            if ($image) {
                                echo '<img src="'.$image->src('medium', 'http://placehold.it/500x300').'" alt="'.$image->name.'" title="'.$image->name.'" class="img-responsive" />';
                            }                                            

                        ?>
                    </a>
                    <h4><a href="<?=$brother->link()?>"><?=$brother->name?></a></h4>

            </div>

        <? } ?>
    </div>

</div>

                
