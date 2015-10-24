<?php namespace Model\Traits;

trait Menu {
    
    public function menu()
    {
        
        return $this->hasMany("Model\Menu", 'element_id');
        
    }
    
    public function inMenu()
    {
        
        $inMenu = array();
        
        if ($this->id) {
        
            $menuSite = \Model\Menu::where('element_id', $this->id)
                    ->where('module', 'site')
                    ->get();


            foreach ($menuSite as $m) {

                $node = $m->rootNode();
                if (!empty($node)) {
                    $inMenu[$node] = true;
                }

            }
        
        }

        $menu = \Model\Menu::where('parent', 0)
                ->get();

        $return = array();
        foreach ($menu as $m) {
            $return[] = array('menu' => $m, 'checked' => isset($inMenu[$m->id]));
        }        
        
        return $return;
        
    }      
    
}