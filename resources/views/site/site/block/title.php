<?php

    if ($site->id == 1) {
        
        echo $site->title();
        
    } else {
        
        $root = Model\Site::find(1)->name;
//        $items = array();
//        
//        foreach ($site->breadCrumbs() as $k => $item) {
//
//            if (!$k) continue;
//            
//            $items[] = $item['title'] ? $item['title'] : $item['name'];
//            
//        }
        
        $title = $site->title();
        
//        $title .= $items ? ' - '.implode(' - ', array_reverse($items)) : '';
        $title .= $root ? ' - '.$root : '';
        
        echo $title;
        
    }

?>