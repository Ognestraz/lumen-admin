<?php namespace Admin\Http\Controllers;

use Model\User;

class UserController extends AdminController
{
    use Traits\Sortable, Traits\Act;
    
    protected $modelName = 'user';
    
    public function index()
    {
        $list = User::orderBy('id', 'asc')->get();
        
        return view($this->templatePath().'.index', array('user_list' => $list));
    } 
}
