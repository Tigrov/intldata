<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Currency extends DataAbstract
{
    /**
     * Actual ISO 4217 currency codes
     */
    const CODES = ['AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BDT','BGN','BHD','BIF',
                   'BMD','BND','BOB','BRL','BSD','BTN','BWP','BYR','BZD','CAD','CDF','CHF','CLP','CNY','COP','CRC',
                   'CUC','CUP','CVE','CZK','DJF','DKK','DOP','DZD','EGP','ERN','ETB','EUR','FJD','FKP','GBP','GEL',
                   'GHS','GIP','GMD','GNF','GTQ','GYD','HKD','HNL','HRK','HTG','HUF','IDR','ILS','INR','IQD','IRR',
                   'ISK','JMD','JOD','JPY','KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD','KZT','LAK','LBP','LKR',
                   'LRD','LSL','LYD','MAD','MDL','MGA','MKD','MMK','MNT','MOP','MRO','MUR','MVR','MWK','MXN','MYR',
                   'MZN','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR',
                   'RON','RSD','RUB','RWF','SAR','SBD','SCR','SDG','SEK','SGD','SHP','SLL','SOS','SRD','SSP','STD',
                   'SVC','SYP','SZL','THB','TJS','TMT','TND','TOP','TRY','TTD','TWD','TZS','UAH','UGX','USD','UYU',
                   'UZS','VEF','VND','VUV','WST','XAF','XCD','XOF','XPF','YER','ZAR','ZMW'];

    /**
     * Main ISO 4217 currency codes
     */
    const MAIN_CODES = ['USD', 'EUR', 'GBP', 'CNY', 'AUD', 'RUB', 'INR', 'ZAR'];

    /**
     * Get actual ISO 4217 currency codes
     * @inheritdoc
     */
    public static function codes()
    {
        return static::CODES;
    }

    /**
     * Get all supported currency names
     *
     * @return array all currency names include old and not used.
     */
    public static function allNames()
    {
        static $list;

        if ($list === null) {
            $list = [];
            $data = \ResourceBundle::create(\Locale::getDefault(), 'ICUDATA-curr')->get('Currencies');
            foreach ($data as $code => $values) {
                $list[$code] = $values[1];
            }
        }

        return $list;
    }

    /**
     * @inheritdoc
     */
    public static function name($code)
    {
        return static::allNames()[$code];
    }

    /**
     * Find main currency code in a list
     *
     * @param array $codes list of currency codes
     * @return string|null main currency code or null
     */
    public static function findMainCode($codes)
    {
        foreach (static::MAIN_CODES as $code) {
            if (in_array($code, $codes)) {
                return $code;
            }
        }

        return null;
    }

    public static function countryCurrencyFormatter($countryCode)
    {
        $localeCode = Locale::countryLocaleCode($countryCode);

        return new \NumberFormatter($localeCode, \NumberFormatter::CURRENCY);
    }

    public static function countryCurrencyCode($countryCode)
    {
        return static::countryCurrencyFormatter($countryCode)->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
    }

    public static function countryCurrencySymbol($countryCode)
    {
        return static::countryCurrencyFormatter($countryCode)->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }
}
