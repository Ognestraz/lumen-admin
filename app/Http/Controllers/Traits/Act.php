<?php namespace Admin\Http\Controllers\Traits;

trait Act 
{
    public function act($id)
    {
        $act = (int) $this->model($id)->methodAct();
        return $this->result(['act' => $act]);
    }
}
