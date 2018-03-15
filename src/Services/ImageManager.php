<?php
// src/Service/ImageManager.php
namespace Geekco\CmsBundle\Services;

use Geekco\CmsBundle\Entity\ImageResource;
use Geekco\CmsBundle\Services\FileUploader;
use \Gumlet\ImageResize;

class ImageManager
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    const SCALE_XXS = [
        'prefix' => 'scale_xxs',
        'width' => 100
    ];
    const SCALE_XS = [
        'prefix' => 'scale_xs',
        'width' => 200
    ];
    const SCALE_SM = [
        'prefix' => 'scale_sm',
        'width' => 500
    ];
    const SCALE_MD = [
        'prefix' => 'scale_md',
        'width' => 1000
    ];
    const SCALE_LG = [
        'prefix' => 'scale_lg',
        'width' => 1500
    ];
    const SCALE_XL = [
        'prefix' => 'scale_xl',
        'width' => 2000
    ];
    const SCALE_XXL = [
        'prefix' => 'scale_xxl',
        'width' => 2000
    ];

    public function getScaleFilters()
    {
        return [
            self::SCALE_XXS,
            self::SCALE_XS,
            self::SCALE_SM,
            self::SCALE_MD,
            self::SCALE_LG,
            self::SCALE_XL,
            self::SCALE_XXL
        ];
    }

    public function applyFilters(ImageResource $entity)
    {
        if (file_exists($this->uploader->getTargetDir()."/".$entity->getImage())) {
            try {
                if (getimagesize($this->uploader->getTargetDir()."/".$entity->getImage())) {
                    $image = new ImageResize($this->uploader->getTargetDir()."/".$entity->getImage());
                    foreach ($this->getScaleFilters() as $f) {
                        $image->resizeToWidth($f['width']);
                        $image->save($this->uploader->getTargetDir()."/".$f['prefix'].$entity->getImage());
                    }
                }
            } catch (\Throwable $e) {
            }
        }
    }
}
