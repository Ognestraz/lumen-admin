<?php

$role_list = array();
/*
foreach (Model\Role::all() as $role) {
    
    $role_list[$role->id] = $role->name;
    
}*/

?>


<form class="ajax auto-validation" action="<?=url('/')."/admin/user".($user->id ? '/'.$user->id : '')?>" method="POST">
    <input type="hidden" name="_token" value="<?=csrf_token();?>">
     <?php if ($user->id) { ?>
       <input type="hidden" name="id" value="<?=$user->id?>" /> 
       <input type="hidden" name="_method" value="PUT" />
    <?php } ?>

    <div id="tabs-site">
      <ul>
        <li><a href="#tabs-1">Основное</a></li>
      </ul>
      <div id="tabs-1">

        <div>
            <label>Название:</label> <br />
            <input type="text" class="medium" id="name" name="name" value="<?=$user->name?>" /><br />
        </div>
          
        <div>
            <label>E-mail:</label> <br />
            <input type="text" class="medium" id="email" name="email" value="<?=$user->email?>" /><br />
        </div>
          
        <div>
            <label>Роль:</label> <br />
            <?=Form::select('size', $role_list, $user->role_id)?>
        </div>
          
        <div>
            <label>Пароль:</label> <br />
            <input type="password" class="medium" id="password" name="password" value="" /><br />
        </div>

      </div>
        
    </div>
       
   <input type="submit" class="btn" value="Принять" />    
   </form>