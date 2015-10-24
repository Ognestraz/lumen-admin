<?=View::make('header', array('site' => $site))?>


        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    <?=view('site.block.breadcrumbs', array('site' => $site))?>
                </h2>
            </div>
            <div class="col-lg-12">
                <?=$site->content?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <?php foreach ($site->childs()->sort()->get() as $child) { ?>
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="well">
                            <a href="<?=$child->link()?>">
                                <img class="img-responsive" src="http://placehold.it/750x450" alt="">
                            </a>
                            <h4><a href="<?=$child->link()?>"><?=$child->name?></a></h4>
                        </div>
                    </div>
                <?php } ?>                
            </div>
        </div>        
        
        
        <hr>
        
<?=View::make('footer')?>