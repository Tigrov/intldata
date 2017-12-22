<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Country;

class CountryTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEquals([
            'AD','AE','AF','AG','AI','AL','AM','AO','AQ','AR','AS','AT','AU','AW','AX','AZ','BA','BB','BD','BE',
            'BF','BG','BH','BI','BJ','BL','BM','BN','BO','BQ','BR','BS','BT','BV','BW','BY','BZ','CA','CC','CD',
            'CF','CG','CH','CI','CK','CL','CM','CN','CO','CR','CU','CV','CW','CX','CY','CZ','DE','DJ','DK','DM',
            'DO','DZ','EC','EE','EG','EH','ER','ES','ET','FI','FJ','FK','FM','FO','FR','GA','GB','GD','GE','GF',
            'GG','GH','GI','GL','GM','GN','GP','GQ','GR','GS','GT','GU','GW','GY','HK','HM','HN','HR','HT','HU',
            'ID','IE','IL','IM','IN','IO','IQ','IR','IS','IT','JE','JM','JO','JP','KE','KG','KH','KI','KM','KN',
            'KP','KR','KW','KY','KZ','LA','LB','LC','LI','LK','LR','LS','LT','LU','LV','LY','MA','MC','MD','ME',
            'MF','MG','MH','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ','NA',
            'NC','NE','NF','NG','NI','NL','NO','NP','NR','NU','NZ','OM','PA','PE','PF','PG','PH','PK','PL','PM',
            'PN','PR','PS','PT','PW','PY','QA','RE','RO','RS','RU','RW','SA','SB','SC','SD','SE','SG','SH','SI',
            'SJ','SK','SL','SM','SN','SO','SR','SS','ST','SV','SX','SY','SZ','TC','TD','TF','TG','TH','TJ','TK',
            'TL','TM','TN','TO','TR','TT','TV','TW','TZ','UA','UG','UM','US','UY','UZ','VA','VC','VE','VG','VI',
            'VN','VU','WF','WS','XK','YE','YT','ZA','ZM','ZW'
        ], Country::codes());
    }

    public function testHas()
    {
        $this->assertTrue(Country::has('RU'));
        $this->assertTrue(Country::has('US'));
        $this->assertTrue(Country::has('CN'));
        $this->assertFalse(Country::has('XX'));
    }

    public function testNames()
    {
        $this->assertArraySubset(['RU' => 'Russia', 'US' => 'United States', 'CN' => 'China'], Country::names());
        $this->assertSame(['CN' => 'China', 'RU' => 'Russia', 'US' => 'United States'], Country::names(['RU', 'US', 'CN']));
        $this->assertSame(['RU' => 'Russia', 'US' => 'United States', 'CN' => 'China'], Country::names(['RU', 'US', 'CN'], false));
    }

    public function testName()
    {
        $this->assertSame('Russia', Country::name('RU'));
        $this->assertSame('United States', Country::name('US'));
        $this->assertSame('China', Country::name('CN'));
    }
}