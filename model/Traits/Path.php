<?php namespace Model\Traits;

trait Path {
    
    static public function findPath($path, $act = true, $fail = false)
    {
        $model = self::where('path', '=', $path == '/' ? '' : $path);
        if (isset($act)) {
            $model->where('act', $act);
        }
        return $fail ? $model->firstOrFail() : $model->first();
    }

}

?>
