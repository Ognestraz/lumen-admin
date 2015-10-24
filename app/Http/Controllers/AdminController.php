<?php namespace Admin\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;

class AdminController extends \Laravel\Lumen\Routing\Controller {
    
    protected $errors = [];
    protected $result = [];
    protected $validationMessages = null;
    protected $frontEndRules = null;
    
    static public $rules = array();
    static public $messages = array();
    
    protected $writableFields = array();
    protected $forbiddenFields = array();
    
    protected $makeList = [];
    protected $groupActionList = [];
    
    public function getRules($action = null)
    {
        self::$rules = array_merge($this->model()->getRules(), self::$rules);
        $rules = empty(static::$rules) ? self::$rules : array_merge(self::$rules, static::$rules);
        
        if (!empty($action)) {
            
            $rulesVar = 'rules'.ucfirst($action);
            
            if (!empty(static::$$rulesVar)) { 
            
                return array_merge($rules, static::$$rulesVar);
            
            }
            
        }
        
        return $rules;
    }
    
    public function getMessages($action = null)
    {
        self::$messages = array_merge($this->model()->getMessages(), self::$messages);
        $messages = empty(static::$messages) ? self::$messages : array_merge(self::$messages, static::$messages);
        
        if (!empty($action)) {
            
            $messagesVar = 'messages'.ucfirst($action);
            
            if (!empty(static::$$messagesVar)) { 
            
                return array_merge($messages, static::$$messagesVar);
            
            }
            
        }
        
        return $messages;        
    }    
    
    public function setFrontEndRules($action)
    {
        $rules = $this->getRules($action);
        $messages = $this->getMessages($action);
        
        $this->frontEndRules = array('rules' => $rules, 'messages' => $messages, 'action' => $action);   
    }   
    
    public function getFrontEndRules()
    {
        return $this->frontEndRules;   
    }      
    
    public function validation()
    {
        return Response::json($this->getFrontEndRules());
    }
    
    public function name($full = false)
    {
        $c = get_class($this);
        return $full ? $c : class_basename($c);
    }    
    
    public function templatePath()
    {
        return 'admin::' . str_replace('controller', '', strtolower($this->name())); 
    }      

    public function getModelClass()
    {
        return 'Model\\'.ucfirst($this->modelName);
    }
    
    protected function model($id = null, $key = null)
    {
        $modelClass = $this->getModelClass();
        $this->model = $key ? ($id ? $modelClass::where($key, $id)->firstOrFail() : false) 
            : ($id ? $modelClass::findOrFail($id) : new $modelClass());
        return $this->model;
    }     
    
    protected function _make($id = null)
    {
        $make = Input::get('make', '');

        if ($make && in_array($make, $this->makeList)) {
            $makeMethod = 'make' . ucfirst($make);
            return $this->$makeMethod($id);
        }
        
        return false;
    }      
    
    protected function _record($model, $action) 
    {
        foreach (Input::all() as $key => $value) {
            if ((empty($this->writableFields) || in_array($key, $this->writableFields)) 
                    && (empty($this->forbiddenFields) || !in_array($key, $this->forbiddenFields))
                    && Schema::hasColumn($model->getTable(), $key)) {
                       $model->$key = $value;
            }
        }
        
        if ($model->save()) {
            $this->result['action'] = $action;
            
            if (Input::get('_target')) {
                $this->result['content'] = (string) view($this->templatePath().'.item', [$this->modelName => $model]);
            }
        } else {
            $this->result['errors'] = $model->getError();
            $this->result['messages'] = $model->getValidationMessages();
        }

        return $this->result();                    
    }    
    
    public function index()
    {
        return view($this->templatePath().'.index');
    }     
    
    public function show($id)
    {
        $model = $this->model($id);
        
        return view($this->templatePath().'.show', array($this->modelName => $model));
    }     
    
    public function update($id)
    {
        $resultMake = $this->_make($id);
        if (!$resultMake) {
            $model = $this->model($id);
            return $model->id ? $this->_record($model, 'update') : false;
        }

        return $resultMake;
    }
    
    public function group()
    {
        $groupAction = Input::get('action', '');

        if ($groupAction && in_array($groupAction, $this->groupActionList)) {
            return $this->$groupAction();
        } else {
            $this->errors[] = 'Not make!';
        }
        
        return $this->result();
    }    
    
    public function store()
    { 
        $model = $this->model();

        return $model ? $this->_record($model, 'store') : false;
    }      
    
    public function create($id = null)
    {

        $model = $this->model();
        $parent = $id ? $this->model($id) : null;

        if ($model) {
            return view($this->templatePath().'.create', [$this->modelName => $model, 'parent' => $parent]); 
        }

        return false;

    }    
    
    public function edit($id)
    {
        $model = $this->model($id);

        if ($model->id) {

            return view($this->templatePath().'.create', array($this->modelName => $model)); 

        }

        return false;
    }         

    public function destroy($id)
    {

        $model = $this->model($id);

        if ($model->id) {
            $model->forceDelete();
        } else {
            $this->errors[] = 'Not Model';
        }
        
        return $this->result();

    }       
    
    protected function _getControllerName()
    {
        return strtolower(substr(get_class($this), strlen(__NAMESPACE__) + 1));
    }


    public function result($data = [], $errors = [], $params = [])
    {
        $adminUrl = config('app.admin_url');
        $adminUrlPath = ('/' === $adminUrl) ? $adminUrl : $adminUrl . '/';
        
        $controller = $adminUrlPath . str_replace('controller', '', $this->_getControllerName());
        $result = $this->result + ['controller' => $controller];
        
        $backtrace = debug_backtrace(0, 2);

        $action = array_pop($backtrace);
        if (empty($this->result['action']) && !empty($action['function']) && !empty($action['class']) && method_exists($this, $action['function'])) {
            $result['action'] = $action['function'];
        }
        
        if (!empty($this->model) && !empty($this->model->id)) {
            $result['model'] = $this->model->toArray();
        }
        
        $result['data'] = !empty($result['data']) ? array_merge($result['data'], $data) : $data;
        $resultErrors = !empty($errors) ? $errors : $this->errors;
        
        if (empty($resultErrors)) {
            $result['result'] = 1;
        } else {
            $result['errors'] = $resultErrors;
        }
        
        $this->result = $result;
        
        return json_encode($result + $params);
    }
    
}
