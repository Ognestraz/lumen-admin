<?php namespace Admin\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Model\Video;

class VideoController extends AdminController
{
    use Traits\Sortable, Traits\Items, Traits\Act;
    
    protected $modelName = 'video';
    protected $requestParam = array('model', 'model_id', 'part');
    protected $groupActionList = ['sort'];
    
    
    public function index()
    {
        $list = Video::orderBy('sort', 'asc')->get();
     
        return view($this->templatePath().'.index', array('list' => $list));
    }
    
    public function data()
    {
        $list = Video::orderBy('sort', 'asc')->get();
        
        return response()->json(['data' => $list]);
    }
    
    public function edit($id)
    {
        $variant = Input::get('variant', '');
        $view = !empty($variant) ? 'variant' : 'create';
        
        if ($variant === 'main') {
            
            $variant = '';
            
        }
        
        $model = $this->model($id);
        
        if ($model->id) {

            return view($this->templatePath().'.'.$view, array($this->modelName => $model, 'variant' => $variant)); 

        }

        return false;
    }    
    
    public function upload()
    {
         $view = Input::get('view', 'uploader');
     
        if ($view === 'list') {
            
            $part = Input::get('part');
            $list = Video::get(Input::get('model'), Input::get('model_id', 0))->videos($part)->orderBy('sort', 'asc')->get();            
            
        } else {
            
            $list = Video::orderBy('sort', 'asc')->get();
            
        }
        
        return view($this->templatePath().'.'.$view, array('list' => $list));
    }    
}
