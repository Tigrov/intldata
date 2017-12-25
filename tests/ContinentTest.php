<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Continent;

class ContinentTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEquals(['AF', 'AN', 'AS', 'EU', 'NA', 'OC', 'SA'], Continent::codes());
    }

    public function testHas()
    {
        $this->assertTrue(Continent::has('EU'));
        $this->assertTrue(Continent::has('NA'));
        $this->assertTrue(Continent::has('AS'));
        $this->assertFalse(Continent::has('EE'));
    }

    public function testNames()
    {
        $this->assertSame(['AF' => 'Africa', 'AN' => 'Antarctica', 'AS' => 'Asia', 'EU' => 'Europe', 'NA' => 'North america', 'OC' => 'Oceania', 'SA' => 'South america'], Continent::names());
        $this->assertSame(['AS' => 'Asia', 'EU' => 'Europe', 'NA' => 'North america'], Continent::names(['EU', 'NA', 'AS']));
        $this->assertSame(['EU' => 'Europe', 'NA' => 'North america', 'AS' => 'Asia'], Continent::names(['EU', 'NA', 'AS'], false));
    }

    /**
     * @dataProvider namesProvider
     */
    public function testName($code, $name)
    {
        $this->assertSame($name, Continent::name($code));
    }

    /**
     * @dataProvider countryCodesProvider
     */
    public function testCountryCodes($code, $countryCodes)
    {
        $this->assertEquals($countryCodes, Continent::countryCodes($code));
    }

    public function testCountryContinentCode()
    {
        $this->assertSame('EU', Continent::countryContinentCode('RU'));
        $this->assertSame('NA', Continent::countryContinentCode('US'));
        $this->assertSame('AS', Continent::countryContinentCode('CN'));
        // Wrong country code
        $this->assertNull(Continent::countryContinentCode('XX'));
    }

    public function namesProvider()
    {
        return [
            ['AF', 'Africa'],
            ['AN', 'Antarctica'],
            ['AS', 'Asia'],
            ['EU', 'Europe'],
            ['NA', 'North america'],
            ['OC', 'Oceania'],
            ['SA', 'South america'],
        ];
    }

    public function countryCodesProvider()
    {
        return [
            ['AF', ['BW','CF','BJ','AO','BI','BF','GM','CG','CV','DJ','DZ','ER','EH','GA','GN','GW','LR','LY','YT','LS',
                'MA','ML','MR','MU','NA','NE','SZ','SC','RE','RW','SD','SN','SL','SO','SS','ST','TN','UG','ZA','ZM',
                'SH','TD','TG','TZ','CI','CM','GH','KE','MZ','MW','NG','KM','EG','GQ','MG','ET','ZW','CD']],
            ['AN', ['BV','AQ','TF','HM','GS']],
            ['AS', ['AM','AZ','BN','BT','CC','CN','BD','BH','CX','GE','JP','KG','KW','LA','LB','IO','IR','IQ','JO','KZ',
                'KH','ID','MO','MV','MM','MN','NP','OM','MY','SY','KP','PS','QA','SA','AF','PK','TM','TR','VN','UZ',
                'TJ','YE','KR','LK','HK','IL','AE','IN','SG','TH','TW','PH']],
            ['EU', ['CH','BG','AX','AL','AT','BY','FI','GB','GG','CY','CZ','DK','ES','EE','FO','GI','XK','HU','HR','IM',
                'IE','IS','IT','JE','NL','LI','LT','LV','MC','MD','MT','ME','SM','SE','PT','RO','SI','SJ','VA','AD',
                'FR','NO','DE','GR','LU','MK','PL','RU','UA','BE','BA','RS','SK']],
            ['NA', ['BZ','BB','AI','BS','BL','BM','GP','CU','CW','DM','DO','CR','KN','GL','GT','HN','HT','JM','NI','MF',
                'MX','MQ','MS','SV','SX','PR','PM','AW','US','VG','BQ','AG','TT','VI','LC','KY','CA','VC','GD','PA',
                'TC']],
            ['OC', ['AS','AU','CK','FJ','FM','KI','GU','MH','NF','MP','NU','NR','NZ','PN','PW','PG','SB','TK','TL','TV',
                'VU','UM','WF','NC','PF','WS','TO']],
            ['SA', ['BO','AR','CL','EC','FK','CO','GF','GY','SR','PE','PY','UY','VE','BR']],
        ];
    }
}