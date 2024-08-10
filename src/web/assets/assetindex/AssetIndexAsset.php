<?php

namespace thomasvantuycom\crafthostedvideos\web\assets\assetindex;

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
            
            $view->registerJsWithVars(fn($volumeHandles, $hideUploadButton) => <<<JS
                Craft.HostedVideos = {
                  volumeHandles: $volumeHandles,
                  hideUploadButton: $hideUploadButton,
                };
            JS, [$settings->volumeHandles, $settings->hideUploadButton], View::POS_HEAD);
        }
    }
}
