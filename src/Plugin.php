<?php

namespace thomasvantuycom\crafthostedvideos;

use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use craft\events\TemplateEvent;
use craft\web\View;
use thomasvantuycom\crafthostedvideos\models\Settings;
use thomasvantuycom\crafthostedvideos\web\assets\assetindex\AssetIndexAsset;
use yii\base\Event;

/**
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    
    public bool $hasCpSettings = true;

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('_hosted-videos/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        Event::on(View::class, View::EVENT_BEFORE_RENDER_TEMPLATE, function(TemplateEvent $event) {
            if ($event->template === 'assets/_index' || $event->template === '_components/fieldtypes/Assets/input.twig') {
                $event->sender->registerAssetBundle(AssetIndexAsset::class);
            }
        });
    }
}
