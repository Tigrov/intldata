<?php

namespace tigrov\intldata;

class Timezone implements DataInterface
{
    /**
     * Time zone names from IANA tame zone database
     * @inheritdoc
     *
     * @param null|string $countryCode country code
     * @return array list of timezone codes
     */
    public static function codes($countryCode = null)
    {
        return $countryCode
            ? \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode)
            : \DateTimeZone::listIdentifiers();
    }

    /**
     * @inheritdoc
     *
     * @param null|string $countryCode ISO 3166-1 alpha-2 country code
     * @return array list of timezone names
     */
    public static function names($countryCode = null)
    {
        $list = [];
        $sort = [];
        foreach (static::codes($countryCode) as $code) {
            $intlTimeZone = \IntlTimeZone::createTimeZone($code);
            $name = static::intlName($intlTimeZone);
            if ('(GMT) GMT' != $name) {
                $list[$code] = $name;
                $sort[$code] = abs($intlTimeZone->getRawOffset());
            }
        }

        array_multisort($sort, $list);

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
     * Generate timezone name from Intl data.
     *
     * @param \IntlTimeZone $intlTimeZone
     * @return string timezone name
     */
    public static function intlName(\IntlTimeZone $intlTimeZone)
    {
        $short = $intlTimeZone->getDisplayName(false, \IntlTimeZone::DISPLAY_SHORT);
        $long = $intlTimeZone->getDisplayName(false, \IntlTimeZone::DISPLAY_GENERIC_LOCATION);

        return '(' . $short . ') ' . $long;
    }

    /**
     * Get default timezone code for each country
     *
     * @return array timezone code for each country
     */
    public static function countryTimezoneCodes()
    {
        static $list;

        if ($list === null) {
            $list = require(dirname(__DIR__) . '/data/country_timezone_code.php');
        }

        return $list;
    }

    /**
     * Get default timezone code of a country
     *
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return string timezone code
     */
    public static function countryTimezoneCode($countryCode)
    {
        return static::countryTimezoneCodes()[$countryCode];
    }
}
