<?php namespace Model;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class Model extends \Illuminate\Database\Eloquent\Model 
{
    protected $validationMessages = null;
    static public $side = null;

    static public $rules = array();    
    static public $messages = array();   
    
    protected $error = array();
    
    public function getError() 
    {
        return $this->error;
    }
    
    public function getRules() 
    {
        $rules = empty(static::$rules) ? self::$rules : array_merge(self::$rules, static::$rules);
        foreach ($rules as &$value) {
            $value = strtr($value, ['{id}' => $this->id]);
        }
        
        return $rules;
    }
    
    public function getMessages() 
    {
        return empty(static::$messages) ? self::$messages : array_merge(self::$messages, static::$messages);
    }
    
    static public function get($model, $id = null) 
    {
        if (!empty($model)) {
            $model_class = 'Model\\' . ucfirst($model);
            return !empty($id) || is_numeric($id) ? $model_class::find($id) : new $model_class();
        }
        
        return null;
    }

    public function validate($input = null, $rules = null, $messages = null) 
    {
        if (is_null($input)) {
            
            $input = Input::all();
            
        }
        
        if (is_null($rules)) {
            
            $rules = $this->getRules();
            
        }
        
        if (is_null($messages)) {
            
            $messages = $this->getMessages();
            
        }

        $v = Validator::make($input, $rules, $messages);

        if ($v->passes()) {
            
            return true;
            
        } else {
            
            Input::flash();
            
            foreach ($input as $key => $value) {
                
                $error = $v->messages()->get($key);
                
                if ($error) {
                
                    $this->validationMessages[$key] = $error;

                }
                
            }
            
            $this->error = $v->errors();
            
            return false;
            
        }
    }    
    
    public function save(array $options = array()) 
    {
        if ($this->validate() && !$this->validationMessages) {
            
            return parent::save($options);
        
        }
        
        return false;
    }
    
    public function getValidationMessages() 
    {
        return $this->validationMessages;
    }
    
    public function parent()
    {
        return !empty($this->parent) ? self::find($this->parent) : false;
    }   
    
    public function childs()
    {
        return self::where('parent', $this->id);
    }   
    
    public function brothers()
    {
        return self::where('parent', $this->parent)->where('id', '!=', $this->id);
    }    
    
    public function table() 
    {
        return $this->table;
    }
    
    static public function pagination($list, $pagination, $view = null) 
    {
        $view = $view ? $view : 'pagination.default';
        
        $param = array('limit' => $pagination->count());
        
        if ($list instanceof Illuminate\Database\Eloquent\Relations\Relation) {
            
            $param['module'] = strtolower(class_basename($list->getParent()));
            $where = $list->getQuery()->getQuery()->wheres;
            
        } else {
            
            $where = $list->getQuery()->wheres;
            
        }
        
        foreach($where as $item) {
            
            if (!empty($item['operator']) && $item['operator'] === '=' && isset($item['value'])) {
            
                $part = explode('.', $item['column']);
                $column = sizeof($part) > 1 ? $part[1] : $part[0];
                
                $param[$column] = $item['value'];
            
            }
            
        }
        
        $pagination->setBaseUrl(url('/').'/'.strtolower(class_basename($list->getModel())).'/items');
        
        return $pagination->appends($param)->links($view);
    }
}
