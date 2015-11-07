<?php namespace Model;

use URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes, Traits\Menu, Traits\Tree, Traits\Seo, Traits\Path;
    use Traits\Image, Traits\Video;
    use Traits\Act, Traits\Sortable;
    
    static public $site = null;
    
    protected $table = 'site';
    protected $visible = array(
        'id',
        'name',
        'parent',
        'path',
        'content'
    );
 
    public function setSettingsAttribute($settings)
    {
        
//        if (empty($this->attributes['settings'])) {
//            $this->attributes['settings'] = self::find(1)->settings;
//        }
//        
//        $oldSettings = is_string($this->attributes['settings']) ? unserialize($this->attributes['settings']) : $this->attributes['settings'];
//        
//        if (is_array($oldSettings) && is_array($settings)) {
//            $this->attributes['settings'] = serialize(array_replace_recursive($oldSettings, $settings));
//        }
        
    }  
//    
    public function getSettingsAttribute($value)
    {
        return is_string($value) ? unserialize($value) : [];
        
    }    

    public function getSettings($param = null)
    {
        $return = empty($this->settings) ? self::find(1)->settings : $this->settings;
        // costl
       /* if (empty($return['image']) && $this->id != 1) {
            $mainPageSettings = self::find(1)->getSettings();
            $return['image'] = $mainPageSettings['image'];
        }        
        
        if (!empty($param)) {
            
            $tmp = explode('.', $param);
            $subSettings = $return;
            foreach ($tmp as $val) {
                
                if (isset($subSettings[$val])) {
                    $subSettings = $subSettings[$val];
                } else {
                    return null;
                }
                
            }
            
            return $subSettings;
            
        }*/
        
        return $return;
    }
    
    public function title()
    {
        return !empty($this->title) ? $this->title : $this->name;
    }

    public function getKeywords()
    {
        if (!empty($this->keywords)) {
            return $this->keywords;
        }

        return self::find(1)->keywords;
    }

    public function getDescription()
    {
        if (!empty($this->description)) {
            return $this->description;
        }

        return self::find(1)->description;
    }

    public function link() 
    {
        return url('/').'/'.$this->path;
    }
    
    public function template($template, $childsTemplate = null)
    {
        $this->template = $template;

        if (!empty($childsTemplate)) {

            foreach ($this->childs()->get() as $item) {

                $item->template = $childsTemplate;
                $item->save();

            }
            
        }

        $this->save();
        
        return $this->template;
    }
    
    public function view() 
    {
        return $this->template ? 'site.' . $this->template : 'site.show';
    }
}
