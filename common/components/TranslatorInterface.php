<?php
namespace common\components;

interface TranslatorInterface
{
    public function simpleTranslate($text, $lang);

    public function dictTranslate($text, $lang);
}