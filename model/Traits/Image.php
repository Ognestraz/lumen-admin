<?php namespace Model\Traits;

trait Image 
{

    public function images($part = null)
    {
        $model = $this->hasMany('Model\Image', 'model_id');
        
        if (!empty($part)) {
            
            $partArray = explode('+', $part);
            foreach ($partArray as $key => $item) {
                
                $key ? $model->orWhere('part', $item) : $model->where('part', $item);
                
            }
            
        }
        
        return $model;
    }
    
    public function image()
    {
        return $this->images('main')->orderBy('sort', 'asc')->first();
    }

}
