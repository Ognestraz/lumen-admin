<?

    $settings_part = array('site', 'image');
    $list_variation = array('resize', 'crop', 'crop-width', 'fit');
    $default_variant = array('make' => array('resize'),
        'width' => array(0),
        'height' => array(0),
        'top' => array(0),
        'left' => array(0));
    
    $list = $site->getSettings();
    
    if (empty($list['image'])) {
        
        $list['image'] = array('medium' => $default_variant, 'large' => $default_variant);
                
    }
    
    $subItems = array('site' => 'Страницы', 'image' => 'Изображения', 'video' => 'Видео');
    $subItemsPref = array('site' => '', 'image' => 'image:', 'video' => 'video:');
    
?>

    <div class="subtabs-site">
        <ul>
            <li><a href="#subtabs-settings-1">Основное</a></li>
            <li><a href="#subtabs-settings-2">Изображения</a></li>
        </ul>
        <div id="subtabs-settings-1">
            
        <? foreach ($subItems as $key => $item) {   

            $subitem = array('name' => $key, 'label' => $item, 'pref' => $subItemsPref[$key]);
            echo view('admin::site.settings.subitem', array('item' => $subitem, 'list' => $list));

        } ?>            
            
        </div>
        <div id="subtabs-settings-2">
            Варианты изображений <a href="<?=url('admin').'/site/reimage/'.$site->id?>" class="ajax"> Применить к ранее загруженным</button>
            <div id="image-variation">
                <ul>
                <? foreach ($list['image'] as $key => $settings) { ?>
                    <li class="admin-list"><span class="variant-title"><?=$key?></span> <a href="#" class="delete-variant">x</a>
                        <? foreach ($settings['make'] as $k => $make) { ?>

                            <div class="edit-panel">
                                <select name="settings[image][<?=$key?>][make][]">
                                    <? foreach ($list_variation as $variant) { ?>
                                        <option value="<?=$variant?>"<?=($variant == $make ? ' selected' : '')?>><?=$variant?></option>
                                    <? } ?>
                                </select>
                                <input type="text" name="settings[image][<?=$key?>][width][]" value="<?=$settings['width'][$k]?>" placeholder="Ширина">
                                <input type="text" name="settings[image][<?=$key?>][height][]" value="<?=$settings['height'][$k]?>" placeholder="Высота">
                                <input type="text" name="settings[image][<?=$key?>][top][]" value="<?=$settings['top'][$k]?>" placeholder="Top">
                                <input type="text" name="settings[image][<?=$key?>][left][]" value="<?=$settings['left'][$k]?>" placeholder="Left">
                                <a href="#" class="add-make">+</a>
                                <a href="#" class="delete-make">x</a>
                            </div>

                        <? } ?>
                    </li>    

                <? } ?>
                 </ul>
                <input id="new-variation-name" type="text" placeholder="name">
                <a href="#" class="add-variation">Add</a>

            </div>
        </div>
    </div>