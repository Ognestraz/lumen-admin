<?php namespace Admin\Http\Controllers;

use Model\Role;

class RoleController extends AdminController
{
    use Traits\Sortable; 
    
    protected $modelName = 'role';
    
    public function index()
    {
        $list = Role::orderBy('sort', 'asc')->get();
     
        return view($this->templatePath().'.index', array('role_list' => $list));
    }
}
