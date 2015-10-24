<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?=url('/admin')."/menu"?>" class="js-ajax" data-target="#page-wrapper">Меню</a> / 
                <?=(($menu->id) ? 'Редактирование: ' . $menu->name : 'Добавление')?>                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="js-ajax" action="<?=url('/')."/admin/menu".($menu->id ? '/'.$menu->id : '')?>" method="POST">
                    <input type="hidden" name="_token" value="<?=csrf_token();?>">
                    <?php if ($menu->id) { ?>
                       <input type="hidden" name="id" value="<?=$menu->id?>" /> 
                       <input type="hidden" name="_method" value="PUT" />
                    <?php } else { ?>
                       <input type="hidden" name="parent" value="<?=(!empty($parent) ? $parent->id : 0)?>" /> 
                    <?php } ?>
                       <input type="hidden" name="module" value="site" /> 

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Название</label>
                                <input class="form-control" placeholder="Название пункта меню" name="name" value="<?=$menu->name?>">
                            </div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#site" data-toggle="tab">Страница</a>
                                </li>
                                <li>
                                    <a href="#url" data-toggle="tab">Внешняя ссылка</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="site">
                                    <div class="form-group">
                                        <select name="element_id" class="form-control">
                                            <option value="0">---</option>
                                            <?php foreach (Model\Site::all() as $site) { ?>
                                                <option value="<?=$site->id?>"><?=$site->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="autopath" value="0" />
                                        <input type="checkbox" name="autopath" value="1"<?=$menu->autopath ? ' checked' : ''?> />
                                        <label>Автоматическая смена пути</label>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="url">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="http://" name="path" value="<?=$menu->path?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Описание</label>
                                <textarea name="preview" class="form-control" rows="3"><?=$menu->preview?></textarea>
                            </div>
                        </div>
                    </div>                        
                       
                    <div class="row">
                        <div class="col-lg-12">                    
                            <button type="submit" class="btn btn-default">Сохранить</button>
                            <button type="submit" class="btn btn-default" data-make="to-add">Сохранить и добавить</button>
                            <button type="submit" class="btn btn-default" data-make="to-list">Сохранить и вернуться к списку</button>
                            <a href="<?=url('/admin')."/menu"?>" class="js-ajax btn btn-danger" data-target="#page-wrapper">Отмена</a>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>                