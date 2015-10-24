<?php namespace Admin\Http\Controllers\Traits;

use Input;
use Response;

trait Items 
{
    public function itemsDelete()
    {
        $items = null;
        $list = array();
        
        $class = 'Model\\'.ucfirst($this->modelName);

        $param = array_intersect_key(Input::all(), array_flip($this->requestParam));
        
        if ($param) {

            foreach ($param as $key => $value) {

                if (empty($items)) {

                    $items = $class::where($key, $value);

                } else {

                    $items->where($key, $value);

                }

            }

            $list = $items->get();

        }

        foreach ($list as $item) {
            
            $item->forceDelete();
            
        }
        
        $result = array('result' => true);

        return Response::json($result);

    }    
   
    public function items($view = null)
    {
        $view = $view ? $view : 'list';
        $items = null;
        $list = array();
        
        $class = '\\'.ucfirst($this->model);

        $param = array_intersect_key(Input::all(), array_flip($this->requestParam));
        
        if ($param) {

            foreach ($param as $key => $value) {

                if (empty($items)) {

                    $items = $class::where($key, $value);

                } else {

                    $items->where($key, $value);

                }

            }

            if ($param['module'] === 'site') {
            
                $site = App\Models\Site::find($param['module_id']);
                $list = $items->getDefault($site);
                
            } else {

                $list = Input::get('limit') ? $items->paginate(Input::get('limit')) : $items->get();
                
            }

        }

        $listShow = (string)view($this->model.'.items.'.$view, array('list' => $list));

        $paginationShow = '';

        if (Input::get('limit') && $list->getLastPage() > 1) {

            $paramPagination = $param; 
            $paramPagination['limit'] = Input::get('limit');

            $paginationShow = (string)$list->appends($paramPagination)->links('pagination.default');            

        }


        $result = array('list' => $listShow, 'pagination' => $paginationShow);

        return $result;

    }  
    
    public function masonry($view = null)
    {
        $view = $view ? $view : 'list-masonry';
        $items = null;
        $list = array();
        
        $class = '\\'.ucfirst($this->model);

        $param = array_intersect_key(Input::all(), array_flip($this->requestParam));
        
        if ($param) {

            foreach ($param as $key => $value) {

                if (empty($items)) {

                    $items = $class::where($key, $value);

                } else {

                    $items->where($key, $value);

                }

            }
            
            if ($param['module'] === 'site') {
            
                $site = App\Models\Site::find($param['module_id']);
                $list = $items->getDefault($site);
                
            } else {

                $list = Input::get('limit') ? $items->paginate(Input::get('limit')) : $items->get();
                
            }

        }

        $listShow = (string)view($this->model.'.items.'.$view, array('list' => $list));

        return $listShow;

    }           
}
