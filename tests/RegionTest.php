<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Region;

class RegionTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEquals(['019', '142', '002', '150', '009'], Region::codes());
    }

    public function testHas()
    {
        $this->assertTrue(Region::has('150'));
        $this->assertTrue(Region::has('019'));
        $this->assertTrue(Region::has('142'));
        $this->assertFalse(Region::has('XXX'));
    }

    public function testNames()
    {
        $this->assertSame(['002' => 'Africa', '019' => 'Americas', 142 => 'Asia', 150 => 'Europe', '009' => 'Oceania'], Region::names());
        $this->assertSame(['019' => 'Americas', 142 => 'Asia', 150 => 'Europe'], Region::names(['150', '019', '142']));
        $this->assertSame([150 => 'Europe', '019' => 'Americas', 142 => 'Asia'], Region::names(['150', '019', '142'], false));
    }

    public function testName()
    {
        $this->assertSame('Americas', Region::name('019'));
        $this->assertSame('Asia', Region::name('142'));
        $this->assertSame('Africa', Region::name('002'));
        $this->assertSame('Europe', Region::name('150'));
        $this->assertSame('Oceania', Region::name('009'));
    }

    public function testCountryCodes()
    {
        $this->assertEquals(
            ['AW','AI','AG','BS','BL','BB','CU','CW','KY','DM','DO','GP','GD','HT','JM','KN','LC','MF','MS','MQ','PR',
                'SX','TC','TT','VC','VG','VI','BQ','AR','BO','BR','CL','CO','EC','FK','GF','GS','GY','PE','PY','SR',
                'UY','VE','BZ','CR','GT','HN','MX','NI','PA','SV','BM','CA','GL','PM','US','UM'],
            Region::countryCodes('019')
        );

        $this->assertEquals(
            ['AF','BD','BT','IN','IR','LK','MV','NP','PK','AE','AM','AZ','BH','CY','GE','IQ','IL','JO','KW','LB','OM',
                'PS','QA','SA','SY','TR','YE','BN','ID','IO','KH','LA','MM','MY','PH','SG','TH','TL','VN','CN','HK',
                'JP','KR','MO','MN','KP','TW','KZ','KG','TJ','TM','UZ'],
            Region::countryCodes('142')
        );

        $this->assertEquals(
            ['AO','CF','CM','CD','CG','GA','GQ','ST','TD','BI','KM','DJ','ER','ET','KE','MG','MZ','MU','MW','YT','RE',
                'RW','SO','SS','SC','TF','TZ','UG','ZM','ZW','BJ','BF','CI','CV','GH','GN','GM','GW','LR','ML','MR',
                'NE','NG','SN','SL','TG','SH','BW','LS','NA','SZ','ZA','DZ','EG','EH','LY','MA','SD','TN'],
            Region::countryCodes('002')
        );

        $this->assertEquals(
            ['AX','DK','EE','FI','FO','GB','GG','IM','IE','IS','JE','LT','LV','NO','SJ','SE','AL','AD','BA','ES','GI',
                'GR','HR','IT','MK','MT','ME','PT','SM','RS','SI','VA','XK','AT','BE','CH','DE','FR','LI','LU','MC',
                'NL', 'BG','BY','CZ','HU','MD','PL','RO','RU','SK','UA'],
            Region::countryCodes('150')
        );

        $this->assertEquals(
            ['AS','CK','NU','PN','PF','TK','TO','TV','WF','WS','AU','CC','CX','HM','NF','NZ','FJ','NC','PG','SB','VU',
                'FM','GU','KI','MH','MP','NR','PW'],
            Region::countryCodes('009')
        );
    }

    public function testCountryRegionCode()
    {
        $this->assertEquals('150', Region::countryRegionCode('RU'));
        $this->assertEquals('019', Region::countryRegionCode('US'));
        $this->assertEquals('142', Region::countryRegionCode('CN'));
    }
}