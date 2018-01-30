<?php
namespace common\components;


class Translator
{
    protected  $translator;

    /**
     * Translator constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param $text
     * @param $lang
     * @return mixed
     */
    public function translate($text, $lang)
    {
        return $this->translator->simpleTranslate($text, $lang);
    }

    /**
     * @param $text
     * @param $lang
     * @return mixed
     */
    public function dictTranslate($text, $lang)
    {
        return $this->translator->dictTranslate($text, $lang);
    }
}