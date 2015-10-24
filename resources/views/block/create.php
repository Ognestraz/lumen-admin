<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?=url('/admin')."/block"?>" class="js-ajax" data-target="#page-wrapper">Блоки</a> / 
                <?=(($block->id) ? 'Редактирование: ' . $block->name : 'Добавление')?>                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="js-ajax auto-validation2" action="<?=url('/')."/admin/block".($block->id ? '/'.$block->id : '')?>" method="POST">
                    <input type="hidden" name="_token" value="<?=csrf_token();?>">
                     <?php if ($block->id) { ?>
                       <input type="hidden" name="id" value="<?=$block->id?>" /> 
                       <input type="hidden" name="_method" value="PUT" />
                    <?php } else { ?>
                       <input type="hidden" name="parent" value="<?=(!empty($parent) ? $parent->id : 0)?>" /> 
                    <?php } ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Заголовок</label>
                                <input class="form-control" placeholder="Введите заголовок" name="name" value="<?=$block->name?>">
                            </div>
                            <div class="form-group">
                                <label>Контент</label>
                                <textarea name="content" class="form-control" rows="3"><?=$block->content?></textarea>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="row">
                        <div class="col-lg-12">                    
                            <button type="submit" class="btn btn-default">Сохранить</button>
                            <button type="submit" class="btn btn-default" data-make="to-add">Сохранить и добавить</button>
                            <button type="submit" class="btn btn-default" data-make="to-list">Сохранить и вернуться к списку</button>
                            <a href="<?=url('/admin')."/block"?>" class="js-ajax btn btn-danger" data-target="#page-wrapper">Отмена</a>
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