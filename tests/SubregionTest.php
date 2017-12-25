<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Subregion;

class SubregionTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEquals(['029','005','013','021','034','145','035','030','143','017','014','011','018','015','154',
            '039','155','151','061','053','054','057'], Subregion::codes());

        $this->assertEquals(['029','005','013','021'], Subregion::codes('019'));
        $this->assertEquals(['034','145','035','030','143'], Subregion::codes('142'));
        $this->assertEquals(['017','014','011','018','015'], Subregion::codes('002'));
        $this->assertEquals(['154','039','155','151'], Subregion::codes('150'));
        $this->assertEquals(['061','053','054','057'], Subregion::codes('009'));
    }

    public function testHas()
    {
        $this->assertTrue(Subregion::has('151'));
        $this->assertTrue(Subregion::has('021'));
        $this->assertTrue(Subregion::has('030'));
        $this->assertFalse(Subregion::has('XXX'));
    }

    public function testNames()
    {
        $this->assertArraySubset([151 => 'Eastern Europe', '021' => 'Northern America', '030' => 'Eastern Asia'], Subregion::names());
        $this->assertSame([151 => 'Eastern Europe', 154 => 'Northern Europe', '039' => 'Southern Europe', 155 => 'Western Europe'], Subregion::names('150'));
        $this->assertEquals([151 => 'Eastern Europe', 154 => 'Northern Europe', '039' => 'Southern Europe', 155 => 'Western Europe'], Subregion::names('150'), false);
    }

    public function testName()
    {
        $this->assertSame('Eastern Europe', Subregion::name('151'));
        $this->assertSame('Northern America', Subregion::name('021'));
        $this->assertSame('Eastern Asia', Subregion::name('030'));
    }

    public function testRegionCode()
    {
        $this->assertEquals('150', Subregion::regionCode('151'));
        $this->assertEquals('019', Subregion::regionCode('021'));
        $this->assertEquals('142', Subregion::regionCode('030'));
        // Wrong subregion code
        $this->assertNull(Subregion::regionCode('xxx'));
    }

    public function testCountryCodes()
    {
        $this->assertEquals(['BG','BY','CZ','HU','MD','PL','RO','RU','SK','UA'], Subregion::countryCodes('151'));
        $this->assertEquals(['BM','CA','GL','PM','US','UM'], Subregion::countryCodes('021'));
        $this->assertEquals(['CN','HK','JP','KR','MO','MN','KP','TW'], Subregion::countryCodes('030'));
    }

    public function testCountrySubregionCode()
    {
        $this->assertEquals('151', Subregion::countrySubregionCode('RU'));
        $this->assertEquals('021', Subregion::countrySubregionCode('US'));
        $this->assertEquals('030', Subregion::countrySubregionCode('CN'));
        // Antarctica is without region in UN geoscheme
        $this->assertNull(Subregion::countrySubregionCode('AQ'));
        // Wrong country code
        $this->assertNull(Subregion::countrySubregionCode('XX'));
    }
}