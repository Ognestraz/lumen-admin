<?php

namespace Model\Ext;

use App;
use DB;

class Builder extends \Illuminate\Database\Eloquent\Builder {
    
    public function byDefault($site = null) {
        
        $model = $this->getModel();
        $modelName = strtolower(class_basename($model));
        $pref = $modelName != 'site' ? $modelName.':' : '';
        
        
        if (empty($site)) {
            
            $settings = !empty($model->id) ? $model->getSettings() : Model\Site::$site->getSettings();
            
        } else {
            
            $settings = $site->getSettings();
            
        }
        
        if (!empty($settings)) {
            
            $count = !empty($settings['site'][$pref.'count']) ? $settings['site'][$pref.'count'] : 0;
            $pagination = !empty($settings['site'][$pref.'pagination']) ? $settings['site'][$pref.'pagination'] : 0;
            
            $sort_fields = !empty($settings['site'][$pref.'sort_fields']) ? $settings['site'][$pref.'sort_fields'] : '';
            $sort_type = !empty($settings['site'][$pref.'sort_type']) ? $settings['site'][$pref.'sort_type'] : '';
            
            if ($sort_type == 'RAND()') {
                
                $this->orderBy(DB::raw('RAND()'));
                
            } else {
            
                if ($sort_fields) {

                    $sort_type ? $this->orderBy($sort_fields, $sort_type) : $this->orderBy($sort_fields);

                }
                
            }
            
            if ($count) {
                
                $pagination ? $this->paginate($count) : $this->take($count);
                
            }
            
        }
        
        return $this;
        
    }
    
    public function getDefault($site = null) {
        
        $result = $this->byDefault($site);
        
        return $result instanceof Builder ? $result->get() : $result;
        
    }
    
}

?>
