<?php

namespace application\modules\rest\models\Defines;

class Language
{
    /**
     * English language code
     *
     * @var string
     */
    const ENGLISH = 'EN';

    /**
     * Returns list of all languages
     *
     * @return array
     */
    public static function getList(): array
    {
        return [
            Language::ENGLISH,
        ];
    }

    /**
     * Returns whether if language exists
     *
     * @param string $lang Language to check
     *
     * @return bool
     */
    public static function exists($lang)
    {
        return in_array($lang, Language::getList());
    }
}
