<?=View::make('header', array('site' => $site))?>


        <!-- Marketing Icons Section -->
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
        <!-- /.row -->

        <hr>
        
<?=View::make('footer')?>