<?php namespace Model;

class Video extends Model
{
    use Traits\Act;   
    
    protected $table = 'videos';
    protected $visible = array('id', 'act', 'name', 'preview', 'description', 'url');

    public function videoable() 
    {
        return $this->morphTo('Model\Video', 'model', 'model_id');
    }    
    
    public function getUrl($url) 
    {
        if (substr($url, 0, 1) === '<') {
            $doc = new \DOMDocument();
            $doc->loadHTML(str_replace('&', '&amp;', $url));
            $url = str_replace('&amp;', '&', $doc->getElementsByTagName('iframe')->item(0)->getAttribute('src'));
        }

        if (substr($url, 0, 2) === '//') {
            $url = 'http:' . $url;
        } else {
            $parseUrl = explode(':', $url);
            if ($parseUrl[0] !== 'http' && $parseUrl[0] !== 'https') {
                $url = 'http://' . $url;
            }
        }

        return $url;
    }
    
    public function getServiceName($url) 
    {
        $domainAlias = [
            'youtube' => ['youtube.com'],
            'vimeo' => ['vimeo.com'],
            'vk' => ['vk.com']
        ];
        
        foreach ($domainAlias as $key => $val) {
            foreach ($val as $v) {
                if (strripos($url, $v . '/') !== false) {
                    return $key;
                }
            }
        }
        
        return false;
    }
    
    public function getPreviewFromYotube($url) 
    {
        $id = explode("v=", $url, 2);
        return !empty($id[1]) ? 'http://i2.ytimg.com/vi/'.substr($id[1], 0, 11).'/0.jpg' : false;
    }
    
    public function getPreviewFromVimeo($url) 
    {
        $parseUrl = explode("/", $url);
        $id = array_pop($parseUrl);
        if (is_numeric($id)) {
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$id}.php"));
            return !empty($hash[0]['thumbnail_large']) ? $hash[0]['thumbnail_large'] : '';
        }
        
        return '';
    }
    
    public function getPreviewFromVK($url) 
    {
        $doc = new \DOMDocument();
        @$doc->loadHTMLFile($url);
        return @$doc->getElementById('player_thumb')->getAttribute('src');
    }
    
    public function genPreview($url)
    {
        $preview = '';
        $url = $this->getUrl($url);
        
        switch ($this->getServiceName($url)) {
            case 'youtube': 
                $preview = $this->getPreviewFromYotube($url);
                break;
            case 'vimeo': 
                $preview = $this->getPreviewFromVimeo($url);
                break;            
            case 'vk': 
                $preview = $this->getPreviewFromVK($url);
                break;            
        }
        
        return $preview;
    }    
    
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $this->getUrl($value);
        
        if (empty($this->attributes['preview'])) {
            $this->attributes['preview'] = $this->genPreview($this->attributes['url']);
        }
    }
    
    public function setPreviewAttribute($value)
    {
        $this->attributes['preview'] = $value ? $value : $this->genPreview($this->attributes['url']);
    }    
    
    public function getSettings() 
    {
        return is_object($this->videoable) ? $this->videoable->getSettings() : array();
    }    
}
