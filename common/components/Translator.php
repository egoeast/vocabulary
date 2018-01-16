<?php
namespace common\components;


class Translator
{
    protected  $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function translate($text, $langPair)
    {
        return $this->translator->simpleTranslate($text, $langPair);
    }
}