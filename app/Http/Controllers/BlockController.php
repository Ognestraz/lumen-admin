<?php namespace Admin\Http\Controllers;

class BlockController extends AdminController 
{
    use Traits\Tree, Traits\Act;
    
    protected $modelName = 'block';
    protected $model = null;
}
