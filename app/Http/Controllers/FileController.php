<?php namespace Admin\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Model\File;

class FileController extends AdminController 
{
    use Traits\Sortable, Traits\Items, Traits\Act;
    
    protected $modelName = 'file';
    protected $requestParam = array('model', 'model_id', 'part');
    
    protected $groupActionList = ['sort'];
    
    static protected $input_file = 'imagefile';
    static public $image_dir = 'files/image/';
    
    public function index()
    {
        $list = File::orderBy('sort', 'asc')->get();
        return view($this->templatePath().'.index', array('list' => $list));
    }
    
    public function data()
    {
        $list = File::orderBy('sort', 'asc')->get();
        return response()->json(['data' => $list]);
    }
    
    public function upload()
    {
         $view = Input::get('view', 'uploader');
     
        if ($view === 'list' || $view === 'list-content') { //need fix
            
            $part = Input::get('part');
            $list = File::get(Input::get('model'), Input::get('model_id', 0))->files($part)->orderBy('sort', 'asc')->get();           
            
        } else {
            
            $list = File::orderBy('sort', 'asc')->get();
            
        }

        return view($this->templatePath().'.'.$view, array('list' => $list));
    }
    
}
