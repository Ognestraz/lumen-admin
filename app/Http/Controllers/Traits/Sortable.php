<?php namespace Admin\Http\Controllers\Traits;

use DB;
use Input;

trait Sortable
{
    public function sort()
    {
        foreach (Input::get('ids') as $k => $id) {
            DB::table($this->model()->table())
                ->where('id', $id)
                ->update(array('sort' => $k));

        }
        
        return $this->result();
    }    
}
