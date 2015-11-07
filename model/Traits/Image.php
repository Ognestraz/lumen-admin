<?php namespace Model\Traits;

trait Image 
{
    public function images($part = null)
    {
        $model = $this->hasMany('Model\Image', 'model_id');
        
        if (empty($part)) {
            return $model;
        }

        $model->where(function($query) use ($part) {
            $partArray = explode('+', $part);
            foreach ($partArray as $key => $item) {
                $key ? $query->orWhere('part', $item) : $query->where('part', $item);
            }
        });

        return $model;
    }
    
    public function image()
    {
        return $this->images('main')->orderBy('sort', 'asc')->first();
    }
}
