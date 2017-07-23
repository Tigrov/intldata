<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Language extends DataAbstract
{
    // Main ISO 639-1 language codes
    const MAIN_CODES = ['zh','en','es','ar','pt','ru','de','fr','it','tr'];

    /**
     * Returns ISO 639-1 and ISO 639-2 language codes
     * @inheritdoc
     */
    public static function codes()
    {
        return array_unique(array_values(static::countriesLanguageCode()));
    }

    /**
     * @inheritdoc
     */
    public static function name($code)
    {
        return \Locale::getDisplayLanguage($code);
    }

    /**
     * Returns name of a language in the language
     * @param string $code language code
     * @return string
     */
    public static function languageName($code)
    {
        return \Locale::getDisplayLanguage($code, $code);
    }

    /**
     * Returns list of language names in the each language.
     * @return array
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
     * Find main ISO 639-1 language code in a list
     * @param string[] $codes list of language codes
     * @return string|null
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

    /**
     * Returns list of country ISO 639-1 language codes
     * @param string $countryCode the ISO 3166-1 alpha-2 country code
     * @return string[]
     */
    public function countryLanguageCodes($countryCode)
    {
        $localeCodes = Locale::countryLocaleCodes($countryCode);

        $list = [];
        foreach ($localeCodes as $localeCode) {
            $list[] = Locale::languageCode($localeCode);
        }

        return $list;
    }

    /**
     * Returns default language code for each country
     * @return array
     */
    public static function countriesLanguageCode()
    {
        static $list;

        if ($list === null) {
            $list = require(dirname(__DIR__) . '/data/country_language_code.php');
        }

        return $list;
    }

    /**
     * Returns default ISO 639-1 language code of a country
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return string
     */
    public static function countryLanguageCode($countryCode)
    {
        return static::countriesLanguageCode()[$countryCode];
    }
}
