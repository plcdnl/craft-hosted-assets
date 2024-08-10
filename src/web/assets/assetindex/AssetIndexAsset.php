<?php

namespace thomasvantuycom\crafthostedvideos\web\assets\assetindex;

use craft\helpers\App;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\web\View;
use thomasvantuycom\crafthostedvideos\Plugin;

class AssetIndexAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/dist';

    public $depends = [
        CpAsset::class,
    ];

    public $js = [
        'AssetIndex.js',
    ];

    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        if ($view instanceof View) {
            $view->registerTranslations('_hosted-videos', [
                'New video',
            ]);
            
            $settings = Plugin::getInstance()->getSettings();
            $volumeHandle = App::parseEnv($settings->volumeHandle);
            $hideUploadButton = $settings->hideUploadButton;
    
            $view->registerJsWithVars(fn($volumeHandle, $hideUploadButton) => <<<JS
                Craft.HostedVideos = {
                  volumeHandle: $volumeHandle,
                  hideUploadButton: $hideUploadButton,
                };
            JS, [$volumeHandle, $hideUploadButton], View::POS_HEAD);
        }
    }
}
