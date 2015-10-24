<?php namespace Model\Traits;

trait Act {
    
    public function scopeAct($query, $act = true)
    {
        return $query->where('act', $act);
    }
    
    public function act($f = null) {
        
        $this->act = is_null($f) ? !$this->act : (int)$f;
        $this->save();
        return $this->act;
        
    }
    
}
