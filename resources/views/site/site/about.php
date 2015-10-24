<?=View::make('header', array('site' => $site))?>

<?php 
    $image = $site->image();  
?>

<div id="container">	

    <div id="content" class="site-content">
        
        <div class="container_12 site-cover">
            
            <div id="primary" class="content-area grid_12">
                <?=View::make('site.block.breadcrumbs', array('site' => $site)); ?>
                <main id="main" class="site-main" role="main">
                    <div class="row">
                        <div class="col-sm-8">
                            <article class="page type-page status-publish">
                                <div class="entry-content"><?=$site->content?></div>
                            </article>
                            <div class="row participant">
                                <?php foreach ($site->childs()->getDefault() as $child) { ?>
                                    <div class="col-md-3 col-sm-6 col-xs-6 participant-type">
                                        <div class="well">
                                            <h4><a href="<?=$child->link()?>"><?=$child->name?></a></h4>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <?php if ($image) { ?>
                                <a href="<?=$image->src('large')?>" class="photoswipe afisha">
                                    <img src="<?=$image->src('medium')?>" alt="<?=$image->text?>" title="<?=$image->title?>" class="img-responsive" />
                                </a>
                            <?php } ?>
                            <div class="row partner">
                                <div class="col-xs-8">
                                    <div class="well">
                                        <h4><a href="<?=Model\Site::find(182)->link()?>">Партнерам</a></h4>
                                    </div>
                                </div>
                                <div class="col-xs-4 icon-vk">                                
                                    <a href="http://vk.com/fairydreams2015" target="_blank">
                                        <img class="icon" src="/assets/img/vk_icon_64.png" alt="">
                                    </a>
                                </div>
                            </div>    
                        </div>
                </main>
            </div>

        </div>

    </div>
</div>	
<?=View::make('footer')?>