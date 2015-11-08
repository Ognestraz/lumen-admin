<?php namespace Model;

use Img;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model 
{
    use SoftDeletes, Traits\Act, Traits\Sortable, Traits\Path, Traits\File;
    
    protected $table = 'images';
    protected $visible = array(
        'id',
        'name',
        'description',
        'filename',
        'path'
    );

    public $imageDir = 'public/image/';
    public $imageDirSrc = '/image/';
    
    static public $rules = array(
        'path' => 'unique:images,path,{id},id'
    );
    
    protected $defaultVariants = [
        'original' => [],        
        'icon' => [
            ['fit' => ['width' => 100, 'height' => 100]]
        ],
        'large' => [
            ['fit' => ['width' => 1280, 'height' => 720]]
        ],
        'preview' => [
            ['fit' => ['width' => 300, 'height' => 200]]
        ]        
    ];
    
    public function getVariants()
    {
        return array_merge($this->defaultVariants, config('app.image.variants', []));
    }    
    
    public function scopeDefault($query)
    {
        return $query->act()->sort();
    }    
    
    public function getDirectoryPath()
    {
        return base_path() . '/' . $this->imageDir;
    }
    
    public function imageable()
    {
        return $this->morphTo('Model\Image', 'model', 'model_id');
    }    
    
    public function delete()
    {
        $directoryPath = $this->getDirectoryPath();
        $iterator = new \DirectoryIterator($directoryPath);

        foreach ($iterator as $fileinfo) {
            
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                
                $file = $directoryPath.$fileinfo->getFilename().'/'.$this->filename;
                
                if (is_file($file)) {
                    
                    unlink($file);
                    
                }
                
            }
            
        }
        
        $main_file = $directoryPath.$this->filename;
        
        if (is_file($main_file)) {

            unlink($main_file);

        }

        parent::delete();
    }

    public function getSettings() 
    {
        if (is_object($this->imageable)) {

            $settings = $this->imageable->getSettings();
            if (empty($settings['image'])) {
                $mainPageSettings = Model\Site::find(1)->getSettings();
                $settings['image'] = $mainPageSettings['image'];
            }

            return $settings;
        }

        return array();
    }

    protected function _cropImage($img, $item) 
    {
        $width = $item['width'] > $img->width() ? $img->width() : $item['width'];
        $height = $item['height'] > $img->height() ? $img->height() : $item['height'];
        $top = is_numeric($item['top']) ? $item['top'] : null;
        $left = is_numeric($item['left']) ? $item['left'] : null;

        $img->crop($width, $height, $top, $left);
    }

    protected function _resizeImage($img, $item) 
    {
        $width = $item['width'] > $img->width() ? $img->width() : $item['width'];
        $height = $item['height'] > $img->height() ? $img->height() : $item['height'];

        $img->resize($width ? $width : null, $height ? $height : null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

    protected function _fitImage($img, $item) 
    {
        $img->fit($item['width'] ? $item['width'] : null, $item['height'] ? $item['height'] : null);       
    }

    protected function _cropWidthImage($img, $item) 
    {
        $width = $item['width'] > $img->width() ? $img->width() : $item['width'];
        $height = $item['height'] > $img->height() ? $img->height() : $item['height'];
        $top = is_numeric($item['top']) ? $item['top'] : null;
        $left = is_numeric($item['left']) ? $item['left'] : null;

        $img->crop($width, $width > $height ? $height : null, $top, $left);
    }    
    
    protected function _fitUpsizeImage($img, $item)
    {
        $width = $item['width'] > $img->width() ? $img->width() : $item['width'];
        $height = $item['height'] > $img->height() ? $img->height() : $item['height'];
        $k = $item['k'] ? $item['k'] : 0;
        $d = $img->width()/$img->height() - 1;

        if ($d && $d >= $k) {
            $img->fit($width, $height);
        } else {
            $img->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
    }

    protected function _makeList($img, $item)
    {
        $make = key($item);
        $options = $item[$make];

        switch ($make) {
            case 'resize' : 
                $this->_resizeImage($img, $options);
                break;

            case 'fit' : 
                $this->_fitImage($img, $options);
                break;

            case 'crop' : 
                $this->_cropImage($img, $options);
                break;

            case 'crop-width' :
                $this->_cropWidthImage($img, $options);
                break;

            case 'fit-upsize' :
                $this->_fitUpsizeImage($img, $options);
                break;
        }
    }

    public function saveVariant($img, $variant) 
    {
        $variants = $this->getVariants();
        $variantMake = $variants[$variant];
        foreach ($variantMake as $item) {
            $this->_makeList($img, $item);
        }
        
        $dir = app()->basePath('public') . '/image/' . $variant . '/';
        if (false === is_dir($dir)) {
            mkdir($dir, 0766, true);
            chmod($dir, 0766);
        }
        
        $img->save($dir . $this->path);
    }

    public function show($variant)
    {
        $variants = $this->getVariants();
        if (!isset($variants[$variant])) {
            throw new ModelNotFoundException();
        }

        $filename = storage_path().'/app/' . $this->filename;

        $img = \Intervention\Image\Facades\Image::make($filename);
        $this->saveVariant($img, $variant);

        return $img->response('jpg');
    }

    protected function _createVariant($file, $variant)
    {
        $img = Img::make($file);

        foreach ($variant['make'] as $k => $make) {

            $item = array('width' => (int)$variant['width'][$k],
                'height' => (int)$variant['height'][$k],
                'top' => (int)$variant['top'][$k],
                'left' => (int)$variant['left'][$k]);

            switch ($make) {

                case 'resize' : {

                    $width = $item['width'] > $img->width() ? $img->width() : $item['width'];
                    $height = $item['height'] > $img->height() ? $img->height() : $item['height'];

                    $img->resize($width ? $width : null, $height ? $height : null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    break;
                }

                case 'fit' : {

                    $img->fit($item['width'] ? $item['width'] : null, $item['height'] ? $item['height'] : null);
                    break;
                }

                case 'crop' : {

                    $width = $item['width'] > $img->width() ? $img->width() : $item['width'];
                    $height = $item['height'] > $img->height() ? $img->height() : $item['height'];
                    $top = is_numeric($item['top']) ? $item['top'] : null;
                    $left = is_numeric($item['left']) ? $item['left'] : null;

                    $img->crop($width, $height, $top, $left);
                    break;

                }

                case 'crop-width' : {

                    $width = $item['width'] > $img->width() ? $img->width() : $item['width'];
                    $height = $item['height'] > $img->height() ? $img->height() : $item['height'];
                    $top = is_numeric($item['top']) ? $item['top'] : null;
                    $left = is_numeric($item['left']) ? $item['left'] : null;

                    $img->crop($width, $width > $height ? $height : null, $top, $left);
                    break;

                }

            }
        }

        return $img;
    }

    public function setVariantImage($variant)
    {
        $settings = $this->getSettings();
        
        if (!empty($settings['image'][$variant])) {

            $fileName = $this->imageDir.$variant.'/'.$this->filename;
            $img = $this->_createVariant($fileName, $settings['image'][$variant]);
            $img->save($fileName);

        }
    }

    public function variantImage()
    {
        $settings = $this->getSettings();

        foreach ($settings['image'] as $key => $variant) {

            $img = $this->_createVariant($this->imageDir.$this->file, $variant);
         
            if (!is_dir($this->imageDir.$key)) {
                mkdir($this->imageDir.$key);
            }

            $img->save($this->imageDir.$key.'/'.$this->file);

        }
    }
 
    public function file($part = '', $default = '')
    {
        $part_path = $part ? $part.'/' : '';
        $filename = $this->getDirectoryPath().$part_path.$this->filename;
        
        return is_file($filename) ? $filename : $default;
    }
    
    public function src($part = 'original', $default = '')
    {
        $part_path = $part ? $part.'/' : '';
        $filename = $this->getDirectoryPath().$part_path.$this->filename;

        return url('/').$this->imageDirSrc.$part_path.$this->path;
    }

    public function srcNoCache($part = '', $default = '')
    {
        return $this->src($part, $default).'?r='.rand();
    }
}
