<?php namespace Model;

class Message extends Model
{
    protected $table = 'message';
    protected $visible = array('id', 'user', 'recipient', 'title', 'text');

    protected $softDelete = true;

    public function user()
    {
        return $this->belongsTo('Model\User', 'user_id');
    }    
}
