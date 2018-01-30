<?php
namespace common\components;

interface TranslatorInterface
{
    /**
     * @param $text
     * @param $lang
     * @return mixed
     */
    public function simpleTranslate($text, $lang);

    /**
     * @param $text
     * @param $lang
     * @return mixed
     */
    public function dictTranslate($text, $lang);
}