<?php


namespace modules\usecase;


use modules\usecase\ImageGD as GD;
use yii\helpers\FileHelper;
use yiidreamteam\upload\ImageUploadBehavior;

class ImageUploadBehaviorYiiPhp extends ImageUploadBehavior
{

    /**
     * Creates image thumbnails
     */
    public function createThumbs()
    {
        $path = $this->getUploadedFilePath($this->attribute);
        foreach ($this->thumbs as $profile => $config) {
            $thumbPath = static::getThumbFilePath($this->attribute, $profile);
            if (is_file($path) && !is_file($thumbPath)) {

                // setup image processor function
                if (isset($config['processor']) && is_callable($config['processor'])) {
                    $processor = $config['processor'];
                    unset($config['processor']);
                } else {
                    $processor = function (GD $thumb) use ($config) {
                        $thumb->adaptiveResize($config['width'], $config['height']);
                    };
                }

                $thumb = new GD($path, $config);
                call_user_func($processor, $thumb, $this->attribute);
                FileHelper::createDirectory(pathinfo($thumbPath, PATHINFO_DIRNAME), 0775, true);
                $thumb->save($thumbPath);
            }
        }
    }

}