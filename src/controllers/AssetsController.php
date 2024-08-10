<?php

namespace thomasvantuycom\crafthostedvideos\controllers;

use Craft;
use craft\elements\Asset;
use craft\helpers\Assets;
use craft\helpers\FileHelper;
use craft\helpers\StringHelper;
use craft\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AssetsController extends Controller
{
    public function actionCreateHostedVideo(): Response
    {
        $this->requireAcceptsJson();

        $folderId = $this->request->getRequiredBodyParam('folderId');

        $folder = Craft::$app->getAssets()->findFolder(['id' => $folderId]);

        if (!$folder) {
            throw new BadRequestHttpException('The target folder provided for uploading is not valid');
        }

        $tempFilePath = Assets::tempFilePath();

        $fileContents = '';
        $fileContents .= pack('N', 16) . 'ftypisom' . pack('N', 1) . pack('N', 1) . pack('N', 0) . pack('N', 0);
        $fileContents .= pack('N', 36) . 'moov' . pack('N', 20) . 'mvhd' . pack('N', 0x01000000) . pack('N', 0) . pack('N', 0) . pack('N', 0x00010000) . pack('N', 0x00010000) . pack('N', 0x00010000) . pack('N', 0x00010000);
        $fileContents .= pack('N', 44) . 'trak' . pack('N', 36) . 'tkhd' . pack('N', 0x00000007) . pack('N', 0) . pack('N', 0) . pack('N', 0) . pack('N', 0x00010000) . pack('N', 0x00010000) . pack('N', 0x00010000) . pack('N', 0x00010000);
        $fileContents .= pack('N', 24) . 'mdia' . pack('N', 20) . 'mdhd' . pack('N', 0x00000000) . pack('N', 0x00000000) . pack('N', 0x00010000) . pack('N', 0) . pack('N', 0x00000000) . pack('N', 0x00000000);
        $fileContents .= pack('N', 29) . 'hdlr' . pack('N', 0x00000000) . pack('N', 0x00000000) . 'vide' . pack('N', 0) . pack('N', 0) . pack('N', 0x00000000) . pack('N', 0x00000000);
        $fileContents .= pack('N', 32) . 'minf' . pack('N', 24) . 'stbl' . pack('N', 12) . 'stsd' . pack('N', 8) . 'avc1' . pack('N', 0) . pack('N', 0) . pack('N', 0) . pack('N', 0) . pack('N', 0) . pack('N', 0) . pack('N', 0);
        $fileContents .= pack('N', 12) . 'stts' . pack('N', 0);
        $fileContents .= pack('N', 12) . 'stsc' . pack('N', 0);
        $fileContents .= pack('N', 12) . 'stsz' . pack('N', 0) . pack('N', 0);
        $fileContents .= pack('N', 12) . 'stco' . pack('N', 0);

        FileHelper::writeToFile($tempFilePath, $fileContents);

        $uid = StringHelper::UUID();

        $asset = new Asset();
        $asset->uid = $uid;
        $asset->tempFilePath = $tempFilePath;
        $asset->setFilename($uid . '.mp4');
        $asset->newFolderId = $folder->id;
        $asset->setVolumeId($folder->volumeId);
        $asset->uploaderId = Craft::$app->getUser()->getId();

        $asset->setScenario(Asset::SCENARIO_CREATE);
        $result = Craft::$app->getElements()->saveElement($asset);

        if (!$result) {
            return $this->asModelFailure($asset);
        }

        $asset->title = (string)$asset->id;
        $asset->newFilename = (string)$asset->id . '.mp4';

        $asset->setScenario(Asset::SCENARIO_FILEOPS);
        $result = Craft::$app->getElements()->saveElement($asset);

        if (!$result) {
            return $this->asModelFailure($asset);
        }

        return $this->asSuccess();
    }
}
