<?php

namespace tigrov\intldata;

class Subregion implements DataInterface
{
    use NamesTrait;

    /**
     * Get list of subregion codes for a region
     *
     * @param null|string $regionCode region code
     * @return array list of subregion codes
     */
    public static function codes($regionCode = null)
    {
        return array_keys($regionCode ? Region::CODES[$regionCode] : call_user_func_array('array_merge', Region::CODES));
    }

    /**
     * Get list of subregion names for a region
     *
     * @param null|string $regionCode region code
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
     * @param string $code region code, subregion code, country code
     * @return string region name, subregion name, country name
     */
    public static function name($code)
    {
        return Region::name($code);
    }

    /**
     * Get region code by a subregion
     *
     * @param string $subregionCode subregion code
     * @return string region code
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
     * Get list of country codes for a subregion
     *
     * @param string $subregionCode subregion code
     * @return array list of country codes
     */
    public static function countryCodes($subregionCode)
    {
        $regionCode = static::regionCode($subregionCode);

        return Region::CODES[$regionCode][$subregionCode];
    }

    /**
     * Get subregion code for a country
     *
     * @param $countryCode country code
     * @return string subregion code
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