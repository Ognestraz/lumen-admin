<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?=url('/admin')."/site"?>" class="js-ajax" data-target="#page-wrapper">Страница</a> / 
                <?=(($site->id) ? 'Редактирование: ' . $site->name : 'Добавление')?>                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="js-ajax" action="<?=url('/')."/admin/site".($site->id ? '/'.$site->id : '')?>" method="POST">
                    <input type="hidden" name="_token" value="<?=csrf_token();?>">
                     <?php if ($site->id) { ?>
                       <input type="hidden" name="id" value="<?=$site->id?>" /> 
                       <input type="hidden" name="_method" value="PUT" />
                    <?php } else { ?>
                       <input type="hidden" name="parent" value="<?=($parent && $parent->id ? $parent->id : 0)?>" /> 
                    <?php } ?>
                       
                    <!-- Nav tabs -->
                    <div id="tabs" class="js-tabs">
                        <ul class="nav nav-tabs js-tabs">
                            <li class="active"><a href="#tab-site-main" data-toggle="tab">Основное</a></li>
                            <li><a href="#tab-site-content" data-toggle="tab">Контент</a></li>
                            <li><a href="#tab-site-seo" data-toggle="tab">SEO</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Изображения<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#tab-site" data-url="<?=url('/').'/admin/image/upload?model=site&model_id=' . $site->id . '&part=main&view=list'?>" data-toggle="tab">Главная</a></li>
                                    <li><a href="#tab-site" data-url="<?=url('/').'/admin/image/upload?model=site&model_id=' . $site->id . '&part=album&view=list'?>" data-toggle="tab">Альбом</a></li>
                                    <li><a href="#tab-site" data-url="<?=url('/').'/admin/image/upload?model=site&model_id=' . $site->id . '&part=content&view=list'?>" data-toggle="tab">Контент</a></li> 
                                </ul>             
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Видео<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#tab-site" data-url="<?=url('/').'/admin/video/upload?model=site&model_id=' . $site->id . '&part=main&view=list'?>" data-toggle="tab">Главная</a></li>
                                    <li><a href="#tab-site" data-url="<?=url('/').'/admin/video/upload?model=site&model_id=' . $site->id . '&part=album&view=list'?>" data-toggle="tab">Альбом</a></li>
                                    <li><a href="#tab-site" data-url="<?=url('/').'/admin/video/upload?model=site&model_id=' . $site->id . '&part=content&view=list'?>" data-toggle="tab">Контент</a></li> 
                                </ul>             
                            </li>
                            <li><a href="<?=url('/').'/admin/site/settings/'.$site->id?>" data-toggle="tab">Настройки</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-site-main">
                                <br />
                                <input type="hidden" class="medium" name="part" value="<?=$site->part?>" />
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Название</label>
                                            <input class="form-control" placeholder="Название страницы" name="name" value="<?=$site->name?>">
                                        </div>
                                        <div class="form-group">                    
                                            <label>Путь</label>
                                            <div class="input-group">
                                                <input type="text" name="path" data-name="path" value="<?=isset($parent) ? $parent->path.'/' : $site->path?>" placeholder="Ссылка на страницу" class="form-control sm-form-controller">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default js-autopath" data-target="path" data-type="ru" type="button">Ru</button>
                                                    <button class="btn btn-default js-autopath" data-target="path" data-type="en" type="button">En</button>
                                                    <button class="btn btn-default js-autopath" data-target="path" data-type="trans" type="button">Tr</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="hidden" name="autopath" value="0" />
                                                <input type="checkbox" name="autopath" value="1"<?=$site->autopath ? ' checked' : ''?> /> Autopath
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Шаблон:</label> <br />
                                            <?=Form::template(isset($parent) ? $parent->template_childs : ($site->id ? $site->template : ''));?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Меню</label>
                                            <input type="hidden" name="inmenu" value="1" />
                                            <?php
                                                $menu = $site->inMenu();
                                                foreach ($menu as $m) {
                                                    echo '<div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="menu[]" value="'.$m['menu']->id.'"'.(!empty($m['checked']) ? ' checked' : '').'/>' . $m['menu']->name . '
                                                            </label>
                                                        </div>';
                                                }
                                            ?>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-lg-9">                            
                                        <div class="form-group">
                                            <label>Превью</label>
                                            <textarea name="preview" id="tm_preview<?=$site->id?>" class="form-control tinymce" style="height: 100px"><?=$site->preview?></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tabs-2">
                                <div class="row">
                                    <div class="col-lg-6">                            
                                        <div class="form-group">
                                            <input type="hidden" name="inmenu" value="1" />
                                            <?php
                                                $menu = $site->inMenu();
                                                foreach ($menu as $m) {
                                                    echo '<div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="menu[]" value="'.$m['menu']->id.'"'.(!empty($m['checked']) ? ' checked' : '').'/>' . $m['menu']->name . '
                                                            </label>
                                                        </div>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-site-content">
                                <div class="row">
                                    <div class="col-lg-12">                            
                                        <div class="form-group">
                                            <a href="<?=url('/')?>/admin/image/upload?module=site&module_id=<?=$site->id?>&part=content&view=list-content" class="ajax-modal" data-target="#subModal">
                                                <img src="<?=url('/')?>/assets/images/edit.png">
                                            </a>          
                                            <textarea name="content" id="tm_content<?=$site->id?>" class="form-control tinymce" style="height: 200px"><?=$site->content?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-site-seo">
                                <?php  
                                    $seoIndex = false;//$site->getSettings('site.seo.index');
                                    $seoFollow =  false;//$site->getSettings('site.seo.follow');
                                    $seoRobots = false;//$site->getSettings('site.seo.robots');
                                    $seoSitemap = false;//$site->getSettings('site.seo.sitemap');
                                ?>
                                <div class="row">
                                    <div class="col-lg-6">                            
                                        <div class="form-group">
                                            <label>Заголовок:</label><br />
                                            <input type="text" class="form-control" name="title" value="<?=$site->title()?>" />                                        
                                        </div>
                                        <div class="form-group">
                                            <label>Ключевые слова:</label><br />
                                            <textarea name="keywords" cols="50" rows="3" class="form-control"><?=$site->keywords?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Описание:</label><br />
                                            <textarea name="description" cols="50" rows="3" class="form-control"><?=$site->description?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="settings[site][seo][index]" value="0" />
                                                <input type="checkbox" name="settings[site][seo][index]" value="1"<?=$seoIndex ? ' checked' : ''?> />
                                                Индексирование
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="settings[site][seo][follow]" value="0" />
                                                <input type="checkbox" name="settings[site][seo][follow]" value="1"<?=$seoFollow ? ' checked' : ''?> />
                                                Follow
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="settings[site][seo][robots]" value="0" />
                                                <input type="checkbox" name="settings[site][seo][robots]" value="1"<?=$seoRobots ? ' checked' : ''?> />
                                                Robots
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="settings[site][seo][sitemap]" value="0" />
                                                <input type="checkbox" name="settings[site][seo][sitemap]" value="1"<?=$seoSitemap ? ' checked' : ''?> />
                                                Sitemap
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-site">
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">                    
                            <button type="submit" class="btn btn-default">Сохранить</button>
                            <button type="submit" class="btn btn-default" data-make="to-add">Сохранить и добавить</button>
                            <button type="submit" class="btn btn-default" data-make="to-list">Сохранить и вернуться к списку</button>
                            <a href="<?=url('/admin')."/site"?>" class="js-ajax btn btn-danger" data-target="#page-wrapper">Отмена</a>
                        </div>
                    </div>                       
                       
                </form>
                
                <div id="tab-site-load">

                </div>
                
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>                                