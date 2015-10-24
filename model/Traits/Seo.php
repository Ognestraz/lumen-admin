<?php namespace Model\Traits;

trait Seo {
    
    public function metaRobotsContent() {
        
        $seoSettings = $this->getSettings('site.seo');
        
        if (empty($seoSettings['index'])) {
            return empty($seoSettings['follow']) ? 'noindex nofollow' : 'noindex';
        }
        
        if (empty($seoSettings['follow'])) {
            return 'nofollow';
        }
        
        return '';
        
    }
     
    
}

?>
