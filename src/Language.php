<?php

namespace tigrov\intldata;

class Language implements DataInterface
{
    use NamesTrait;

    const MAIN_CODES = ['zh','en','es','ar','pt','ru','de','fr','it','tr'];

    /**
     * @inheritdoc
     */
    public static function codes()
    {
        return array_keys(Locale::languagesLocaleCodes());
    }

    /**
     * @inheritdoc
     */
    public static function name($code)
    {
        return \Locale::getDisplayLanguage($code);
    }

    /**
     * Get name of a language in the language
     *
     * @param $code string language code
     * @return string name of the language in the language
     */
    public static function languageName($code)
    {
        return \Locale::getDisplayLanguage($code, $code);
    }

    /**
     * Get list of language names in the each language.
     *
     * @return array list of names
     */
    public static function languageNames()
    {
        static $list;

        if ($list === null) {
            $list = [];
            foreach (static::codes() as $code) {
                $list[$code] = static::languageName($code);
            }

            asort($list);
        }

        return $list;
    }

    /**
     * Find main language code in a list
     *
     * @param array $codes list of language codes
     * @return string|null main language code or null
     */
    public static function findMainCode($codes)
    {
        foreach (static::MAIN_CODES as $code) {
            if (in_array($code, $codes)) {
                return $code;
            }
        }

        return null;
    }
}
