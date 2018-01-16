<?php
namespace common\components;

interface TranslatorInterface
{
    public function simpleTranslate($text, $langPair);
}