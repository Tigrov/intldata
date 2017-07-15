<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Locale extends DataAbstract
{
    /*
     * Ignored locale codes (using RFC 4646 language tags)
     */
    const IGNORE_CODES = ['en_US_POSIX'];

    /**
     * Returns all supported locales (using RFC 4646 language tags)
     * @return string[]
     */
    public static function codes()
    {
        return array_diff(\ResourceBundle::getLocales(''), static::IGNORE_CODES);
    }

    /**
     * Returns name of a locale
     * @param string $code the locale code
     * @return string
     */
    public static function name($code)
    {
        return \Locale::getDisplayName($code);
    }

    /**
     * Returns name of a locale in the locale language
     * @param string $code the locale code (using RFC 4646 language tags)
     * @return string
     */
    public static function localeName($code)
    {
        return \Locale::getDisplayName($code, $code);
    }

    /**
     * Tries to find out best available locale based on HTTP “Accept-Language” header
     * @return string The corresponding locale identifier (using RFC 4646 language tags)
     */
    public static function acceptCode($header = null)
    {
        return \Locale::acceptFromHttp($header ?: $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }

    /**
     * Returns ISO 639-1 or ISO 639-2 language code for a locale
     * @param string $localeCode the locale code (using RFC 4646 language tags)
     * @return string
     */
    public static function languageCode($localeCode)
    {
        return \Locale::getPrimaryLanguage($localeCode);
    }

    /**
     * Returns list of language locale codes
     * @param string $languageCode the ISO 639-1, ISO 639-2 or ISO 639-3 language code
     * @return string[]
     */
    public static function languageLocaleCodes($languageCode)
    {
        $languagesLocaleCodes = static::languagesLocaleCodes();

        return isset($languagesLocaleCodes[$languageCode]) ? $languagesLocaleCodes[$languageCode] : [];
    }

    /**
     * Returns list of locale codes grouped by ISO 639-1, ISO 639-2 or ISO 639-3 language codes
     * @return array
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
     * Returns list of country locale codes (using RFC 4646 language tags)
     * @param string $countryCode the ISO 3166-1 alpha-2 country code
     * @return string[]
     */
    public static function countryLocaleCodes($countryCode)
    {
        $countriesLocaleCodes = static::countriesLocaleCodes();

        return isset($countriesLocaleCodes[$countryCode]) ? $countriesLocaleCodes[$countryCode] : [];
    }

    /**
     * Returns list of locale codes (using RFC 4646 language tags) grouped by ISO 3166-1 alpha-2 country codes
     * @return array
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
     * @param string[] $localeCodes the list of locale codes
     * @return string|null main locale code (using RFC 4646 language tags) or null
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
     * Tries to find locale code for a country
     * @param string $countryCode the ISO 3166-1 alpha-2 country code
     * @return string|null locale code (using RFC 4646 language tags)
     */
    public static function countryLocaleCode($countryCode)
    {
        $countryLocaleCodes = static::countryLocaleCodes($countryCode);
        if ($languageCode = Language::countryLanguageCode($countryCode)) {
            $languageLocaleCodes = static::languageLocaleCodes($languageCode);
            if ($localeCodes = array_intersect($languageLocaleCodes, $countryLocaleCodes)) {
                return reset($localeCodes);
            } elseif ($countryLocaleCodes) {
                return reset($countryLocaleCodes);
            } elseif ($languageLocaleCodes) {
                return reset($languageLocaleCodes);
            }

            return \Locale::composeLocale([
                'language' => $languageCode,
                'region' => $countryCode,
            ]);
        }

        if (!count($countryLocaleCodes)) {
            return null;
        } elseif (count($countryLocaleCodes) == 1) {
            return reset($countryLocaleCodes);
        }

        if ($localeCode = static::findMainCode($countryLocaleCodes)) {
            return $localeCode;
        }

        foreach ($countryLocaleCodes as $localeCode) {
            $languageCode = static::languageCode($localeCode);
            if (!strcasecmp($languageCode, $countryCode)) {
                return $localeCode;
            }
        }

        return reset($countryLocaleCodes);
    }

    /**
     * Returns locale code (using RFC 4646 language tags) for a language and a country
     * @param string $languageCode the ISO 639-1, ISO 639-2 or ISO 639-3 language code
     * @param string $countryCode the ISO 3166-1 alpha-2 country code
     * @return string
     */
    public static function languageCountryLocaleCode($languageCode, $countryCode)
    {
        $countryLocaleCodes = static::countryLocaleCodes($countryCode);
        $languageLocaleCodes = static::languageLocaleCodes($languageCode);
        if ($localeCodes = array_intersect($languageLocaleCodes, $countryLocaleCodes)) {
            return reset($localeCodes);
        }

        return \Locale::composeLocale([
            'language' => $languageCode,
            'region' => $countryCode,
        ]);
    }
}
