<?php namespace Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes, Traits\Act, Traits\Path, Traits\File;   
    
    protected $table = 'files';
    protected $visible = array('id', 'act', 'path', 'name', 'description', 'filename');

    protected $softDelete = true;
    
    public $imageDir = 'public/files/image/';
    public $imageDirSrc = 'files/image/';
    
    static public $rules = array(
       // 'file' => 'renameimage'
    );      
    
    static public $messages = array(
      //  'file.renameimage' => 'Файл с таким именем уже существует!'
    );     
    
    public function getDirectoryPath() 
    {
        return base_path() . '/' . $this->imageDir;
    }
    
    public function delete()
    {
        parent::delete();
    }
}
