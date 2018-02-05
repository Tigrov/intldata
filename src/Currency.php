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
     * Returns actual ISO 4217 currency codes
     * @inheritdoc
     */
    public static function codes()
    {
        return static::CODES;
    }

    /**
     * Main ISO 4217 currency codes
     * @return string[]
     */
    public static function mainCodes()
    {
        return static::MAIN_CODES;
    }

    /**
     * Returns all supported currency names include old and not used
     * @return array
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
     * Find main ISO 4217 currency code in a list
     * @param string[] $codes list of currency codes
     * @return string|null
     */
    public static function findMainCode($codes)
    {
        foreach (static::mainCodes() as $code) {
            if (in_array($code, $codes)) {
                return $code;
            }
        }

        return null;
    }

    /**
     * Returns ISO 4217 currency code for a country
     * @param string $countryCode the ISO 3166-1 alpha-2 country code
     * @return string
     */
    public static function countryCurrencyCode($countryCode)
    {
        return static::countryCurrencyFormatter($countryCode)->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
    }

    /**
     * Returns currency symbol for a country
     * @param string $countryCode the ISO 3166-1 alpha-2 country code
     * @return string
     */
    public static function countryCurrencySymbol($countryCode)
    {
        return static::countryCurrencyFormatter($countryCode)->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }

    /**
     * Returns currency symbol for a ISO 4217 currency code
     * @param string $code the currency code
     * @return string
     */
    public static function currencySymbol($code)
    {
        $localeCode = \Locale::getDefault() . '@currency=' . $code;
        $formatter = new \NumberFormatter($localeCode, \NumberFormatter::CURRENCY);
        $symbol = $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
        return $symbol != $code
            ? $symbol
            : (static::countryCurrencySymbol(substr($code, 0, 2))
                ?: $symbol);
    }

    /**
     * Returns an \NumberFormatter object for a country
     * @param string $countryCode the ISO 3166-1 alpha-2 country code
     * @return \NumberFormatter
     */
    protected static function countryCurrencyFormatter($countryCode)
    {
        $localeCode = Locale::countryLocaleCode($countryCode);

        return new \NumberFormatter($localeCode, \NumberFormatter::CURRENCY);
    }
}
