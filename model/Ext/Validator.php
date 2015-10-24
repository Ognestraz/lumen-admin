<?php

namespace Model\Ext;

class Validator extends \Illuminate\Validation\Validator {

    public function validateRenameImage($attribute, $value, $parameters)
    {
        
        if (is_string($value)) {
            
            $image = new Model\Image();
            
            if (is_file($image->imageDir.$value)) {

                return false;

            }
            
        }
        
        return true;

    }

}

?>
