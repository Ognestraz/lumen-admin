<?

    $sort_fields = array('sort' => 'По порядку', 'id' => 'ID', 'name' => 'Название');
    $sort_type = array('ASC', 'DESC', 'RAND()');

?>

<h4><?=$item['label']?></h4>
Количество элементов:
<input type="text" name="settings[site][<?=$item['pref']?>count]" value="<?=(!empty($list['site'][$item['pref'].'count']) ? $list['site'][$item['pref'].'count'] : 10)?>">
<input type="checkbox" name="settings[site][<?=$item['pref']?>pagination]" value="1"<?=(!empty($list['site'][$item['pref'].'pagination']) ? ' checked' : '')?>>
Пагинация            
<br />
Сортировка:
<select name="settings[site][<?=$item['pref']?>sort_fields]">
    <? 
        $sort_fields_now = !empty($list['site'][$item['pref'].'sort_fields']) ? $list['site'][$item['pref'].'sort_fields'] : 'sort';

        foreach ($sort_fields as $key => $value) { 

           echo '<option value="'.$key.'"'.($key == $sort_fields_now ? ' selected' : '').'>'.$value;

        } 
    ?>
</select>
<select name="settings[site][<?=$item['pref']?>sort_type]">
    <? 
        $sort_type_now = !empty($list['site'][$item['pref'].'sort_type']) ? $list['site'][$item['pref'].'sort_type'] : 'sort';

        foreach ($sort_type as $value) { 

           echo '<option value="'.$value.'"'.($value == $sort_type_now ? ' selected' : '').'>'.$value;

        } 
    ?>
</select>