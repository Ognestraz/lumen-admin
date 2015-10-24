<?=View::make('header', array('site' => $site))?>

<?php 
    $image = $site->image();  
?>

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?=$site->name?></h1>
                <?=view('site.block.breadcrumbs', array('site' => $site))?>
            </div>
        </div>
        <!-- /.row -->

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-6">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="img-responsive" src="http://placehold.it/750x500" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="http://placehold.it/750x500" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="http://placehold.it/750x500" alt="">
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <h3>Описание</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>
                
                <h3>Где купить</h3>
                
                <div class="row">
                    <div class="col-sm-4 col-xs-6">
                        <a href="#">
                            <img class="img-responsive img-hover img-related" src="http://placehold.it/500x300" alt="">
                        </a>
                        <h4><a href="#">Eva-barug</a></h4>
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <a href="#">
                            <img class="img-responsive img-hover img-related" src="http://placehold.it/500x300" alt="">
                        </a>
                        <h4><a href="#">Eva-barug</a></h4>
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <a href="#">
                            <img class="img-responsive img-hover img-related" src="http://placehold.it/500x300" alt="">
                        </a>
                        <h4><a href="#">Eva-barug</a></h4>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <!-- Related Projects Row -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Другие материалы</h3>
            </div>
            <?php foreach ($site->brothers()->get() as $child) { ?>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <a href="<?=$child->link()?>">
                        <img class="img-responsive img-hover img-related" src="http://placehold.it/750x450" alt="">
                    </a>
                    <h4><a href="<?=$child->link()?>"><?=$child->name?></a></h4>
                </div>
            <?php } ?>
        </div>
        <!-- /.row -->

        <hr>

<?=View::make('footer')?>