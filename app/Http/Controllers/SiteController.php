<?php namespace Admin\Http\Controllers;

use Illuminate\Support\Facades\Input;

class SiteController extends AdminController
{
    use Traits\Tree, Traits\Act, Traits\Menu, Traits\SoftDeletes;
    
    protected $modelName = 'site';
    protected $makeList = ['move'];

    public function template($id)
    {
        
        $model = $this->model($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            
            return view($this->templatePath().'.template', array($this->model => $model)); 
            
        } else {
            
            $template = $model->template(Input::get('template'), Input::get('template_childs'));
            
            return json_encode(array('action' => 'template', 'template' => $template, 'result' => true));
            
        }

    }   
    
    public function settings($id)
    {
        $model = $this->model($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            
            return view($this->templatePath().'.settings', array($this->model => $model)); 
            
            
        }
    }    
    
    public function reimage($id)
    {
        $model = $this->model($id);
        
        $images = $model->images()->get();
        
        foreach ($images as $image) {
            
            $image->variantImage();
            
        }
    }     
}
