<div class="row image-crop-holder">
    <div class="col-lg-12">
        <button class="original" data-src="<?=$image->srcNoCache('original')?>">Оригинал</button> 
        <button class="release">Убрать выделение</button> 
        <button class="crop">Обрезать</button>

        <select class="ar_lock">
            <option value="0"> нет </option>
            <option value="1/1"> (1:1) </option>
            <option value="1/2"> (1:2) </option>
            <option value="2/1"> (2:1) </option>
            <option value="2/3"> (2:3) </option>
            <option value="3/2"> (3:2) </option>
            <option value="3/4"> (3:4) </option>
            <option value="4/3"> (4:3) </option>
            <option value="4/5"> (4:5) </option>
            <option value="9/16"> (9:16) </option>
            <option value="16/9"> (16:9) </option>
            <option value="700/400"> (700:400) </option>
        </select>

        <input type="hidden" name="source" value="<?=$variant?>" />
        <input type="hidden" name="variant" value="<?=$variant?>" />

        <br />

        <label><input type="checkbox" name="settings" value="1" />Применить настройки</label>

        <?php if (!$variant) {?>
            <label><input type="checkbox" name="revariation" value="1" />Применить ко всем вариантам</label>
        <?php } ?>

        <div class="inline-labels" style="display: none;">
            <label>X1 <input type="text" size="4" name="x1" /></label>
            <label>Y1 <input type="text" size="4" name="y1" /></label>
            <label>X2 <input type="text" size="4" name="x2" /></label>
            <label>Y2 <input type="text" size="4" name="y2" /></label>
            <label>W <input type="text" size="4" name="w" /></label>
            <label>H <input type="text" size="4" name="h" /></label>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="image-crop">
            <img class="target-image-crop" data-id="<?=$image->id?>" src="<?=$image->srcNoCache($variant)?>" />
        </div>
    </div>
</div>
