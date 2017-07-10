<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Locale extends DataAbstract
{
    use NamesTrait;

    /*
     * Ignored locale codes (using RFC 4646 language tags)
     */
    const IGNORE_CODES = ['en_US_POSIX'];

    /**
     * Get all supported locales (using RFC 4646 language tags)
     *
     * @return array locale codes (using RFC 4646 language tags)
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
     * @param $code string locale code (using RFC 4646 language tags)
     * @return string name of the locale in the locale language
     */
    public static function localeName($code)
    {
        return \Locale::getDisplayName($code, $code);
    }

    /**
     * Tries to find out best available locale based on HTTP “Accept-Language” header
     *
     * @return string The corresponding locale identifier (using RFC 4646 language tags)
     */
    public static function acceptCode($header = null)
    {
        return \Locale::acceptFromHttp($header ?: $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }

    /**
     * Get language code for a locale
     *
     * @param $localeCode locale code (using RFC 4646 language tags)
     * @return string ISO 639-1 or ISO 639-2 language code
     */
    public static function languageCode($localeCode)
    {
        return \Locale::getPrimaryLanguage($localeCode);
    }

    /**
     * Get list of language locale codes
     *
     * @param string $languageCode ISO 639-1, ISO 639-2 or ISO 639-3 language code
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
     * @return array list of locale codes grouped by ISO 639-1, ISO 639-2 or ISO 639-3 language codes
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
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return array list of country locale codes (using RFC 4646 language tags)
     */
    public static function countryLocaleCodes($countryCode)
    {
        $countriesLocaleCodes = static::countriesLocaleCodes();

        return isset($countriesLocaleCodes[$countryCode]) ? $countriesLocaleCodes[$countryCode] : [];
    }

    /**
     * Get list of locale codes grouped by ISO 3166-1 alpha-2 country codes
     *
     * @return array list of locale codes (using RFC 4646 language tags) grouped by ISO 3166-1 alpha-2 country codes
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
     * Try to find locale code for a country
     *
     * @param string $countryCode ISO 3166-1 alpha-2 country code
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
     * Get locale code for a language and a country
     *
     * @param string $languageCode ISO 639-1, ISO 639-2 or ISO 639-3 language code
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return string locale code (using RFC 4646 language tags)
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
