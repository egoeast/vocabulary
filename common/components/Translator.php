<?php
namespace common\components;


class Translator
{
    protected  $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function translate($text, $lang)
    {
        return $this->translator->simpleTranslate($text, $lang);
    }

    public function dictTranslate($text, $lang)
    {
        return $this->translator->dictTranslate($text, $lang);
    }
}