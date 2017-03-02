<?php

namespace tigrov\intldata;

class Locale implements DataInterface
{
    use NamesTrait;

    const IGNORE_CODES = ['en_US_POSIX', 'chr', 'chr_US', 'my', 'my_MM'];

    /**
     * Get all supported locales
     *
     * @return array locale codes
     */
    public static function codes()
    {
        return array_diff(\ResourceBundle::getLocales(''), static::IGNORE_CODES);
    }

    /**
     * Get name of a locale
     *
     * @param $code string locale code
     * @return string name of the locale
     */
    public static function name($code)
    {
        return \Locale::getDisplayName($code);
    }

    /**
     * Get name of a locale in the locale language
     *
     * @param $code string locale code
     * @return string name of the locale in the locale language
     */
    public static function localeName($code)
    {
        return \Locale::getDisplayName($code, $code);
    }

    /**
     * Tries to find out best available locale based on HTTP “Accept-Language” header
     *
     * @return string The corresponding locale identifier.
     */
    public static function acceptCode($header = null)
    {
        return \Locale::acceptFromHttp($header ?: $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }

    /**
     * Get language code for a locale
     *
     * @param $localeCode locale code
     * @return string language code
     */
    public static function languageCode($localeCode)
    {
        return \Locale::getPrimaryLanguage($localeCode);
    }

    /**
     * Get list of language locale codes
     *
     * @param string $languageCode language code
     * @return array list of language locale codes
     */
    public static function languageLocaleCodes($languageCode)
    {
        $languagesLocaleCodes = static::languagesLocaleCodes();

        return isset($languagesLocaleCodes[$languageCode]) ? $languagesLocaleCodes[$languageCode] : [];
    }

    /**
     * Get list of locale codes grouped by language codes
     *
     * @return array list of locale codes grouped by language codes
     */
    public static function languagesLocaleCodes()
    {
        static $list;

        if ($list === null) {
            $list = [];
            foreach (static::codes() as $localeCode) {
                if ($languageCode = static::languageCode($localeCode)) {
                    $list[$languageCode][] = $localeCode;
                }
            }
        }

        return $list;
    }

    /**
     * Get list of country locale codes
     *
     * @param string $countryCode country code
     * @return array list of country locale codes
     */
    public static function countryLocaleCodes($countryCode)
    {
        $countriesLocaleCodes = static::countriesLocaleCodes();

        return isset($countriesLocaleCodes[$countryCode]) ? $countriesLocaleCodes[$countryCode] : [];
    }

    /**
     * Get list of locale codes grouped by country codes
     *
     * @return array list of locale codes grouped by country codes
     */
    public static function countriesLocaleCodes()
    {
        static $list;

        if ($list === null) {
            $list = [];
            foreach (static::codes() as $localeCode) {
                if ($countryCode = \Locale::getRegion($localeCode)) {
                    $list[$countryCode][] = $localeCode;
                }
            }
        }

        return $list;
    }

    /**
     * Find main locale code in a list
     *
     * @param array $localeCodes list of locale codes
     * @return string|null main locale code or null
     */
    public static function findMainCode($localeCodes)
    {
        $languageLocaleCodes = [];
        foreach ($localeCodes as $localeCode) {
            $languageCode = static::languageCode($localeCode);
            if (!isset($languageLocaleCodes[$languageCode])) {
                $languageLocaleCodes[$languageCode] = $localeCode;
            }
        }

        if ($mainLanguageCode = Language::findMainCode(array_keys($languageLocaleCodes))) {
            return $languageLocaleCodes[$mainLanguageCode];
        }

        return null;
    }

    /**
     * Try to find locale code for a country
     *
     * @param string $countryCode country code
     * @return string|null locale code
     */
    public static function countryLocaleCode($countryCode)
    {
        $localeCodes = static::countryLocaleCodes($countryCode);
        if (!count($localeCodes)) {
            return null;
        } elseif (count($localeCodes) == 1) {
            return reset($localeCodes);
        }

        if ($localeCode = static::findMainCode($localeCodes)) {
            return $localeCode;
        }

        foreach ($localeCodes as $localeCode) {
            $languageCode = static::languageCode($localeCode);
            if (!strcasecmp($languageCode, $countryCode)) {
                return $localeCode;
            }
        }

        return reset($localeCodes);
    }
}
