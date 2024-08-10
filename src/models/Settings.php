<?php

namespace thomasvantuycom\crafthostedvideos\models;

use craft\base\Model;

class Settings extends Model
{
    public string $volumeHandle = 'videos';

    public bool $hideUploadButton = true;

    protected function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [['volumeHandle', 'hideUploadButton'], 'required'];
        $rules[] = [['hideUploadButton'], 'boolean'];

        return $rules;
    }
}
