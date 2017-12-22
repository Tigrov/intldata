<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Timezone extends DataAbstract
{
    /**
     * Returns time zone names from IANA tame zone database
     * @inheritdoc
     *
     * @param null|string $countryCode the country code
     * @return string[] list of timezone codes
     */
    public static function codes($countryCode = null)
    {
        return $countryCode
            ? \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode)
            : \DateTimeZone::listIdentifiers();
    }

    /**
     * Returns list of timezone names
     * @inheritdoc
     * @param bool $sort a boolean indicating to sort the result according to the GMT offset.
     * @return array
     */
    public static function names($codes = null, $sort = true)
    {
        $list = [];
        $sortList = [];
        $codes = $codes ?: static::codes();
        foreach ($codes as $code) {
            $intlTimeZone = \IntlTimeZone::createTimeZone($code);
            $name = static::intlName($intlTimeZone);
            if ('(GMT) GMT' != $name) {
                $list[$code] = $name;
                $sortList[$code] = abs($intlTimeZone->getRawOffset());
            }
        }

        if ($sort) {
            array_multisort($sortList, $list);
        }

        return $list;
    }

    /**
     * @inheritdoc
     */
    public static function name($code)
    {
        return static::intlName(\IntlTimeZone::createTimeZone($code));
    }

    /**
     * Returns default timezone code for each country
     * @return array
     */
    public static function countriesTimezoneCode()
    {
        static $list;

        if ($list === null) {
            $list = require(dirname(__DIR__) . '/data/country_timezone_code.php');
        }

        return $list;
    }

    /**
     * Returns default timezone code of a country
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return string
     */
    public static function countryTimezoneCode($countryCode)
    {
        return static::countriesTimezoneCode()[$countryCode];
    }

    /**
     * Generate timezone name from Intl data.
     * @param \IntlTimeZone $intlTimeZone
     * @return string
     */
    protected static function intlName(\IntlTimeZone $intlTimeZone)
    {
        $short = $intlTimeZone->getDisplayName(false, \IntlTimeZone::DISPLAY_SHORT);
        $long = $intlTimeZone->getDisplayName(false, \IntlTimeZone::DISPLAY_GENERIC_LOCATION);

        return '(' . $short . ') ' . $long;
    }
}
