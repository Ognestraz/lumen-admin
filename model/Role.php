<?php namespace Model;

class Role extends Model
{
    use Traits\Act;
    
    protected $table = 'roles';
    protected $visible = array('id', 'name', 'content');

    protected $softDelete = true;

    static public $rules = array(
        'name' => 'required|min:2|max:32'
    );      
    
    static public $messages = array(
        'name' => 'Имя не может быть короче :min и длиннее :max символов!'
    );    
}
