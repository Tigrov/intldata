<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class MeasurementSystem extends DataAbstract
{
    const METRIC_CODE = 'SI';
    const US_CODE = 'US';
    const US_COUNTRY_CODES = ['US'];

    /**
     * List of names
     */
    const NAMES = [
        self::METRIC_CODE => 'International System (metre, kilogram)',
        self::US_CODE => 'United States (inch, pound)',
    ];

    /**
     * @inheritdoc
     */
    public static function codes() {
        return array_keys(static::NAMES);
    }

    /**
     * @inheritdoc
     */
    public static function name($code) {
        return static::NAMES[$code];
    }

    /**
     * Returns measurement system code for a country
     * @param string $countryCode the country code
     * @return string
     */
    public static function countryMeasurementSystemCode($countryCode)
    {
        return in_array($countryCode, static::US_COUNTRY_CODES)
            ? static::US_CODE
            : static::METRIC_CODE;
    }
}