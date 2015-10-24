<form class="ajax" action="<?=url('/')."/admin/site/template/".$site->id?>" method="POST"> 
    <input type="hidden" name="id" value="<?=$site->id?>" /> 
    <input type="hidden" name="_method" value="PUT" />
    <input type="hidden" class="medium" name="part" value="<?=$site->part?>" />

    <div>
        <label>Шаблон:</label> <br />
        <?=Form::template($site->template);?>
    </div>

    <div>
        <label>Шаблон потомков:</label> <br />
        <?=Form::template('', true, 'template_childs');?>
    </div>

</form>