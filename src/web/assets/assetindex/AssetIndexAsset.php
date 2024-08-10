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
                'Video created.',
            ]);
        }

        $volumeHandle = App::parseEnv(Plugin::getInstance()->getSettings()->volumeHandle);

        $js = <<<JS
            Craft.HostedVideos = {
              volumeHandle: "$volumeHandle"
            };
        JS;

        $view->registerJs($js, View::POS_HEAD);
    }
}
