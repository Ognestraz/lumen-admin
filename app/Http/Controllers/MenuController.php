<?php namespace Admin\Http\Controllers;

class MenuController extends AdminController 
{
    use Traits\Tree, Traits\Act;
    
    protected $modelName = 'menu';
    protected $model = null;
    
    protected $makeList = ['move'];
}
