<?php

namespace thomasvantuycom\crafthostedvideos\models;

use craft\base\Model;
use craft\validators\ArrayValidator;

class Settings extends Model
{
    public array $volumeHandles = [];

    public bool $hideUploadButton = true;

    protected function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [['volumeHandles'], ArrayValidator::class];
        $rules[] = [['hideUploadButton'], 'boolean'];

        return $rules;
    }
}
