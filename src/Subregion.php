<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Subregion extends DataAbstract
{
    use NamesTrait;

    /**
     * Get list of UN sub-region codes for a region
     *
     * @param null|string $regionCode UN region code
     * @return array list of UN sub-region codes
     */
    public static function codes($regionCode = null)
    {
        return array_keys($regionCode ? Region::CODES[$regionCode] : call_user_func_array('array_merge', Region::CODES));
    }

    /**
     * Get list of sub-region names for a region
     *
     * @param null|string $regionCode UN region code
     * @return array list of subregion names
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
     *
     * @param string $code UN region code, UN sub-region code, ISO 3166-1 alpha-2 country code
     * @return string region name, subregion name, country name
     */
    public static function name($code)
    {
        return Region::name($code);
    }

    /**
     * Get UN region code by a subregion
     *
     * @param string $subregionCode UN sub-region code
     * @return string UN region code
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
     * Get list of ISO 3166-1 alpha-2 country codes for a sub-region
     *
     * @param string $subregionCode UN sub-region code
     * @return array list of ISO 3166-1 alpha-2 country codes
     */
    public static function countryCodes($subregionCode)
    {
        $regionCode = static::regionCode($subregionCode);

        return Region::CODES[$regionCode][$subregionCode];
    }

    /**
     * Get UN sub-region code for a country
     *
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return string UN sub-region code
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