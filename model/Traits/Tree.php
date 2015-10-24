<?php namespace Model\Traits;

use DB;
use URL;

trait Tree {
    
    protected $tree;
    protected $listTree = array();
    protected $parentTree = array();
    protected $pathParent;    
    
    protected $mainFieldsTree = array('act', 'name', 'parent', 'path', 'sort');
    protected $addFieldsTree = array('template');
    
    static public $rulesMove = array();      
    
    public function save(array $options = array()) {
        
        if (empty($this->id)) {
            
            $max_sort = DB::table($this->table)
                    ->where('parent', $this->parent)
                    ->where('deleted_at', null)
                    ->max('sort');
            $this->sort = is_numeric($max_sort) ? $max_sort + 1 : 0;
            
        }
        
        return parent::save($options);
        
    }
    
    public function delete() {
        
        $parent = $this->parent;  
        
        $this->sort = 0;
        $this->save();

        if (parent::delete()) {
            
            $this->_resortNode(0, $parent);
            
            return true;
            
        }
        
        return false;
        
    }
    
    public function breadcrumbs() {
        
        if (isset($this->pathParent)) {
            
            return $this->pathParent;
            
        } else { 
        
            $list = self::all();

            $parent_list = array();
            $path_list = array();

            foreach ($list as $item) {
                $parent_list[$item->id] = $item;
            }

            $parent = $this->parent;

            if ($parent) {
                do {
                    $item = $parent_list[$parent];
                    $path_list[] = array('id' => $item->id,
                        'name' => $item->name,
                        'title' => $item->title,
                        'path' => $item->path,
                        'link' => url('/').'/'.$item->path);
                    $parent = $item->parent;

                } while (isset($parent_list[$parent]));

                $path_list = array_reverse($path_list);
            }

            $this->pathParent = $path_list;

            return $this->pathParent;
            
        }
        
    }    
    
    public function rootNode() {
        
        $path = $this->breadcrumbs();

        return !empty($path[0]['id']) ? $path[0]['id'] : false;
        
    }
    
    protected function _resortNode($id, $parent, $type = 'inside') {
        
        if ($type == 'inside') {
             
            $childs = self::where('parent', $parent)
                    ->where('id', '!=', $id)
                    ->orderBy('sort', 'asc')
                    ->get();
            
            $k = !empty($id) ? 1 : 0;
            
            foreach ($childs as $child) {
                
                $child->sort = $k++;
                $child->save();                
                
            }
                
        } else {

            $nodeParent = self::find($parent);
            $nodeParentSort = $nodeParent->sort;
            
            $node = self::find($id);
            $nodeSort = $node->sort;

            if ($nodeSort >= $nodeParentSort) {
                $node->sort = $nodeParentSort + 1;
            } else {
                $node->sort = $nodeParentSort;
            }
            $node->save();
            
            $brothers = self::where('parent', '=', $nodeParent->parent)
                    ->where('id', '!=', $id);
            
            if ($nodeSort >= $nodeParentSort) {
                
                $brothers->where('sort', '>', $nodeParent->sort)
                    ->where('sort', '<', $nodeSort);
                
            } else {

                $brothers->where('sort', '<=', $nodeParent->sort)
                    ->where('sort', '>', $nodeSort);                
                
            }
            
            $brothers_list = $brothers->orderBy('sort','asc')
                    ->get();

            foreach ($brothers_list as $brother) {
                $brother->sort = ($nodeSort >= $nodeParentSort) ? $brother->sort + 1 : $brother->sort - 1;
                $brother->save();
            }
            
        }
            
    }        
    
    public function move($id, $parent, $type = 'inside') 
    {
        $node = self::find($id);
        $parentParent = self::find($parent)->parent;
        $newParent = $node->parent != $parentParent || $type == 'inside';
        $oldParent = $node->parent;
        $changeParent = $type == 'inside' ? $parent : $parentParent;
        
        $this->changePath($id, $newParent ? $changeParent : null);
        
        if ($type == 'inside') {

            $node->sort = 0;
            $node->parent = $parent;
            $node->save();

            $this->_resortNode($id, $node->parent, $type);
            $this->_resortNode(0, $oldParent, $type);
            
        } else {
            
            $node->parent = $parentParent;
            $node->save();
            
            $this->_resortNode($id, $parent, $type);
            $this->_resortNode(0, $oldParent);
            $this->_resortNode(0, $node->parent);
            
        }
        
        return true;
        
    }   

    protected function _branch($id, &$b, $model = false) {
        
        if ($id) {
            
            $b['id'] = $this->listTree[$id]->id;
            
            if (!$model) {
                
                $fieldsTree = array_merge($this->mainFieldsTree, $this->addFieldsTree);
                
                foreach ($fieldsTree as $val) {
                    
                    $b[$val] = $this->listTree[$id]->$val;
                    
                }
                
            } else {
                
                $b['model'] = $this->listTree[$id];
                
            }
            
        }         
        
        if (isset($this->parentTree[$id])) {

            foreach ($this->parentTree[$id] as $k => $child) {

                $this->_branch($child, $b['children'][$k], $model);

            }

        }
        
    }
    
    
    public function createTree($model = false, $act = false) {
        
        $this->tree = array();
        
        $query = $act ? self::where('act', 1) : self::newQuery();
        
        $list = $query->orderBy('parent','asc')
                ->orderBy('sort','asc')
                ->get();

        foreach ($list as $item) {
            
            $this->listTree[$item->id] = $item;
            $this->parentTree[$item->parent][] = $item->id;
            
        }
        
        if (!empty($this->parentTree[0]) && is_array($this->parentTree[0])) {
        
            foreach ($this->parentTree[0] as $k => $item) {

                $this->_branch($item, $this->tree[$k], $model);

            }
        
        }
        
        return $this->tree;
                
    }      
    
    public function getTree($id, $act = false) {
        
        $tree = $this->createTree(true, $act);
        
        return $this->_findChildrenTree($id, $tree);
        
    }
    
    protected function _findChildrenTree($id, $tree = array()) {
        
        foreach ($tree as $k => $v) {
            
            if (!empty($v['children'])) {
                
                if ($v['id'] == $id) {
                    
                    return $v['children'];
                    
                } else {
                    
                    $branch = $this->_findChildrenTree($id, $v['children']);
                    if ($branch) {

                        return $branch;

                    }                    
                    
                }
                
            }
            
        }
        
        return array();
        
    }
    
    protected function _getBranchList($id, &$list) {
        
        $childs = self::where('parent', $id)->get();
        
        foreach ($childs as $child) {
            
            $list[] = $child;
            $this->_getBranchList($child->id, $list);
            
        }
        
    }    
    
    public function getBranch($id) {
        
        $list = array();
        $this->_getBranchList($id, $list);
        
        return $list;
        
    }    
    
    public function changePath($id, $parent = null) {
        
        $listChilds = $this->getBranch($id);
        $node = self::find($id);
        $old_path = $node->path;
        
        $parent = $parent ? $parent : $node->parent;
        
        $nodeParent = self::find($parent);
        $n_path = $nodeParent->path;

        $new_path = ($n_path) ? $n_path.'/' : '';
        $level = $old_path ? sizeof(explode('/',$old_path)) - 1 : 0;

        $temp = array_slice(explode('/',$node->path), $level);
        $node->path = $new_path.implode('/', $temp);

        if ($node->autopath) {

            $node->save();
        
        }

        foreach ($listChilds as $child) {

            if ($child->autopath) {
                
                $temp = array_slice(explode('/', $child->path), $level);
                $child->path = $new_path.implode('/', $temp);
                $child->save();
                
            }

        }
        
    }    
    
}

?>
