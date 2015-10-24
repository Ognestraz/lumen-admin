<div class="well2">
    <div class="fotorama" data-nav="thumbs" data-width="100%" data-ratio="16/9">

        <?php 
            $image_part[] = $site->images('main')->getDefault();
            $image_part[] = $site->images('album')->getDefault();
            
            foreach ($image_part as $image_list) {
                
                foreach ($image_list as $image) {

                    echo '<a href="'.$image->src('large').'" data-caption="'.$image->name.'">
                            <img src="'.$image->src('medium').'" alt="'.$image->name.'" title="'.$image->name.'" class="img-responsive" />
                        </a>';                                

                }
                
            }
        ?>   
    </div>
</div>

            