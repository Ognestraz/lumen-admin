<form class="ajax auto-validation" action="<?=url('/')."/admin/role".($role->id ? '/'.$role->id : '')?>" method="POST"> 
     <? if ($role->id) { ?>
       <input type="hidden" name="id" value="<?=$role->id?>" /> 
       <input type="hidden" name="_method" value="PUT" />
    <? } ?>

    <div id="tabs-site">
      <ul>
        <li><a href="#tabs-1">Основное</a></li>
      </ul>
      <div id="tabs-1">

        <div>
            <label>Название:</label> <br />
            <input type="text" class="medium" id="name" name="name" value="<?=$role->name?>" /><br />
        </div>

      </div>
        
    </div>
       
   <input type="submit" class="btn" value="Принять" />    
   </form>