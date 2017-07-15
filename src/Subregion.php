<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Subregion extends DataAbstract
{
    /**
     * Returns list of UN sub-region codes for a region
     * @param null|string $regionCode UN region code
     * @return string[]
     */
    public static function codes($regionCode = null)
    {
        return array_keys($regionCode ? Region::CODES[$regionCode] : call_user_func_array('array_merge', Region::CODES));
    }

    /**
     * String list of sub-region names for a region
     * @param null|string $regionCode UN region code
     * @return array
     */
    public static function names($regionCode = null)
    {
        $list = [];
        foreach (static::codes($regionCode) as $code) {
            $list[$code] = static::name($code);
        }

        asort($list);

        return $list;
    }

    /**
     * @inheritdoc
     * @param string $code UN region code, UN sub-region code, ISO 3166-1 alpha-2 country code
     * @return string region name, subregion name, country name
     */
    public static function name($code)
    {
        return Region::name($code);
    }

    /**
     * Returns UN region code by a subregion
     * @param string $subregionCode UN sub-region code
     * @return string
     */
    public static function regionCode($subregionCode)
    {
        foreach (Region::CODES as $regionCode => $subregions) {
            if (isset($subregions[$subregionCode])) {
                return $regionCode;
            }
        }

        return null;
    }

    /**
     * Returns list of ISO 3166-1 alpha-2 country codes for a sub-region
     * @param string $subregionCode UN sub-region code
     * @return array
     */
    public static function countryCodes($subregionCode)
    {
        $regionCode = static::regionCode($subregionCode);

        return Region::CODES[$regionCode][$subregionCode];
    }

    /**
     * Returns UN sub-region code for a country
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return string
     */
    public static function countrySubregionCode($countryCode)
    {
        if (in_array($countryCode, Region::COUNTRIES_WITHOUT_REGION)) {
            return null;
        }

        foreach (Region::CODES as $regionCode => $subregions) {
            foreach ($subregions as $subregionCode => $countryCodes) {
                if (in_array($countryCode, $countryCodes)) {
                    return $subregionCode;
                }
            }
        }

        return null;
    }
}