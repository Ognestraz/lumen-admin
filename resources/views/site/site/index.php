<?=View::make('header', array('site' => $site))?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Интернет-витрина косплея и материалов</h1>
        </div>
    </div>
    <?=view('site.menu.show-index', array('menu' => (new Ognestraz\Admin\Models\Menu())->getTree(14, true)))?>
    <?=view('site.menu.show-subindex', array('menu' => (new Ognestraz\Admin\Models\Menu())->getTree(18, true)))?>

<?=View::make('footer')?>