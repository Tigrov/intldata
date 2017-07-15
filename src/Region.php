<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

class Region extends DataAbstract
{
    /**
     * World region code
     */
    const WORLD_CODE = '001';

    /**
     * UN regional codes with subregion codes with ISO 3166-1 alpha-2 country codes
     */
    const CODES = [
        '019' => [
            '029' => ['AW','AI','AG','BS','BL','BB','CU','CW','KY','DM','DO','GP','GD','HT','JM','KN','LC','MF','MS',
                      'MQ','PR','SX','TC','TT','VC','VG','VI','BQ'],
            '005' => ['AR','BO','BR','CL','CO','EC','FK','GF','GS','GY','PE','PY','SR','UY','VE'],
            '013' => ['BZ','CR','GT','HN','MX','NI','PA','SV'],
            '021' => ['BM','CA','GL','PM','US','UM']],
        '142' => [
            '034' => ['AF','BD','BT','IN','IR','LK','MV','NP','PK'],
            '145' => ['AE','AM','AZ','BH','CY','GE','IQ','IL','JO','KW','LB','OM','PS','QA','SA','SY','TR','YE'],
            '035' => ['BN','ID','IO','KH','LA','MM','MY','PH','SG','TH','TL','VN'],
            '030' => ['CN','HK','JP','KR','MO','MN','KP','TW'],
            '143' => ['KZ','KG','TJ','TM','UZ']],
        '002' => [
            '017' => ['AO','CF','CM','CD','CG','GA','GQ','ST','TD'],
            '014' => ['BI','KM','DJ','ER','ET','KE','MG','MZ','MU','MW','YT','RE','RW','SO','SS','SC','TF','TZ','UG',
                      'ZM','ZW'],
            '011' => ['BJ','BF','CI','CV','GH','GN','GM','GW','LR','ML','MR','NE','NG','SN','SL','TG','SH'],
            '018' => ['BW','LS','NA','SZ','ZA'],
            '015' => ['DZ','EG','EH','LY','MA','SD','TN']],
        '150' => [
            '154' => ['AX','DK','EE','FI','FO','GB','GG','IM','IE','IS','JE','LT','LV','NO','SJ','SE'],
            '039' => ['AL','AD','BA','ES','GI','GR','HR','IT','MK','MT','ME','PT','SM','RS','SI','VA','XK'],
            '155' => ['AT','BE','CH','DE','FR','LI','LU','MC','NL'],
            '151' => ['BG','BY','CZ','HU','MD','PL','RO','RU','SK','UA']],
        '009' => [
            '061' => ['AS','CK','NU','PN','PF','TK','TO','TV','WF','WS'],
            '053' => ['AU','CC','CX','HM','NF','NZ'],
            '054' => ['FJ','NC','PG','SB','VU'],
            '057' => ['FM','GU','KI','MH','MP','NR','PW']],
    ];

    /**
     * ISO 3166-1 alpha-2 codes of countries without region
     */
    const COUNTRIES_WITHOUT_REGION = ['AQ','BV'];

    /**
     * ISO 3166-1 alpha-2 codes of countries of European Union
     */
    const EU_COUNTRY_CODES = ['AT','BE','BG','CY','CZ','DE','DK','ES','EE','FI','FR','GB','GR','HR','HU','IE','IT','LT',
                              'LU','LV','MT','NL','PL','PT','RO','SK','SI','SE'];

    /**
     * ISO 3166-1 alpha-2 codes of countries of NAFTA
     */
    const NAFTA_COUNTRY_CODES = ['CA','MX','US'];

    /**
     * ISO 3166-1 alpha-2 codes of countries of EAEU
     */
    const EAEU_COUNTRY_CODES = ['AM','BY','KG','KZ','RU'];

    /**
     * ISO 3166-1 alpha-2 codes of countries of CIS
     */
    const CIS_COUNTRY_CODES = ['AM','AZ','BY','KG','KZ','MD','RU','TJ','TM','UA','UZ'];

    /**
     * UN regional codes
     * @inheritdoc
     */
    public static function codes()
    {
        return array_keys(static::CODES);
    }

    /**
     * @inheritdoc
     *
     * @param string $code UN region code, UN sub-region code, ISO 3166-1 alpha-2 country code
     * @return string region name, subregion name, country name
     */
    public static function name($code)
    {
        static $data;

        if ($data === null) {
            $data = \ResourceBundle::create(\Locale::getDefault(), 'ICUDATA-region')->get('Countries');
        }

        return $data->get($code);
    }

    /**
     * Returns list of ISO 3166-1 alpha-2 country codes for a region
     * @param null|string $regionCode UN region code
     * @return array
     */
    public static function countryCodes($regionCode = null)
    {
        $list = [];
        foreach (static::CODES as $code => $subregions) {
            foreach ($subregions as $subregionCode => $countryCodes) {
                if (!$regionCode || $regionCode == $code || $regionCode == $subregionCode) {
                    $list = array_merge($list, $countryCodes);
                }
            }
        }

        if (!$regionCode) {
            $list = array_merge($list, static::COUNTRIES_WITHOUT_REGION);
        }

        return $list;
    }

    /**
     * Returns UN region code for a country
     * @param string $countryCode ISO 3166-1 alpha-2 country code
     * @return string
     */
    public static function countryRegionCode($countryCode)
    {
        $subregionCode = Subregion::countrySubregionCode($countryCode);

        return $subregionCode
            ? Subregion::regionCode($subregionCode)
            : null;
    }
}