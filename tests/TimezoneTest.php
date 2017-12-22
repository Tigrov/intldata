<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Timezone;

class TimezoneTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEmpty(array_diff(['Europe/Moscow','America/New_York','Asia/Shanghai'], Timezone::codes()));
        $this->assertEmpty(array_diff(['Europe/Moscow','Asia/Vladivostok','Asia/Kamchatka'], Timezone::codes('RU')));
        $this->assertEmpty(array_diff(['America/Chicago','America/Los_Angeles','America/New_York'], Timezone::codes('US')));
    }

    public function testHas()
    {
        $this->assertTrue(Timezone::has('Europe/Moscow'));
        $this->assertTrue(Timezone::has('America/New_York'));
        $this->assertTrue(Timezone::has('Asia/Shanghai'));
        $this->assertFalse(Timezone::has('XXX'));
    }

    public function testNames()
    {
        $this->assertArraySubset(['America/New_York' => '(EST) New York Time','Asia/Shanghai' => '(GMT+8) China Time'], Timezone::names());
        $this->assertSame(['America/New_York' => '(EST) New York Time','Asia/Shanghai' => '(GMT+8) China Time'], Timezone::names(['Asia/Shanghai','America/New_York']));
        $this->assertSame(['Asia/Shanghai' => '(GMT+8) China Time','America/New_York' => '(EST) New York Time'], Timezone::names(['Asia/Shanghai','America/New_York'], false));
    }

    public function testName()
    {
        $this->assertSame('(EST) New York Time', Timezone::name('America/New_York'));
        $this->assertSame('(GMT+8) China Time', Timezone::name('Asia/Shanghai'));
    }

    public function testCountriesTimezoneCode()
    {
        $this->assertArraySubset(['RU' => 'Europe/Moscow', 'US' => 'America/New_York', 'CN' => 'Asia/Shanghai'], Timezone::countriesTimezoneCode());
    }

    public function testCountryTimezoneCode()
    {
        $this->assertSame('Europe/Moscow', Timezone::countryTimezoneCode('RU'));
        $this->assertSame('America/New_York', Timezone::countryTimezoneCode('US'));
        $this->assertSame('Asia/Shanghai', Timezone::countryTimezoneCode('CN'));
    }
}