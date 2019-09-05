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
        return array_keys(Locale::languagesLocaleCodes());
    }

    /**
     * Returns list of main ISO 639-1 language codes
     * @return string[]
     */
    public static function mainCodes()
    {
        return static::MAIN_CODES;
    }

    /**
     * Returns default ISO 639-1 language code
     * @return string
     */
    public static function defaultCode()
    {
        return Locale::languageCode(\Locale::getDefault());
    }

    /**
     * Returns name of default language
     * @return string
     */
    public static function defaultName()
    {
        return static::name(static::defaultCode());
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
     * Returns list of language names in the each language
     * @param string[]|null $codes the list of codes to get names, the empty value means all codes
     * @return array
     */
    public static function languageNames($codes = null)
    {
        $list = [];
        $codes = $codes ?: static::codes();
        foreach ($codes as $code) {
            $list[$code] = static::languageName($code);
        }

        return $list;
    }

    /**
     * Returns name of a locale language in a locale
     * e.g. the result for 'en_US' is 'American English', for 'en_GB' is 'British English'
     * @param string $code locale language code
     * @param string|null $in_code optional format locale code
     * @return string
     */
    public static function localeName($code, $in_code = null)
    {
        $code = str_replace('-', '_', $code);
        $in_code = str_replace('-', '_', $in_code ?: \Locale::getDefault());

        static $languages;
        if (!isset($languages[$in_code])) {
            $languages[$in_code] = [];
            $resource = \ResourceBundle::create($in_code, 'ICUDATA-lang')->get('Languages');
            foreach($resource as $name => $value) {
                $languages[$in_code][$name] = $value;
            }
        }

        return isset($languages[$in_code][$code])
            ? $languages[$in_code][$code]
            : \Locale::getDisplayName($code, $in_code);
    }

    /**
     * Returns list of locale language names in a locale
     * @param string[]|null $codes the list of codes to get names, the empty value means all codes
     * @param string|null $in_code optional format locale code
     * @return array
     */
    public static function localeNames($codes, $in_code = null)
    {
        $list = [];
        $codes = $codes ?: static::codes();
        foreach ($codes as $code) {
            $list[$code] = static::localeName($code, $in_code);
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
        foreach (static::mainCodes() as $code) {
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
    public static function countryLanguageCodes($countryCode)
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
