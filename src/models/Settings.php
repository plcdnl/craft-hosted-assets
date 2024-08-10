<?php

namespace thomasvantuycom\crafthostedvideos\models;

use craft\base\Model;

class Settings extends Model
{
    public string $volumeHandle = 'videos';

    protected function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [['volumeHandle'], 'required'];

        return $rules;
    }
}
