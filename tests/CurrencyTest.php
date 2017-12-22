<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Currency;

class CurrencyTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEquals([
            'AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BDT','BGN','BHD','BIF',
            'BMD','BND','BOB','BRL','BSD','BTN','BWP','BYR','BZD','CAD','CDF','CHF','CLP','CNY','COP','CRC',
            'CUC','CUP','CVE','CZK','DJF','DKK','DOP','DZD','EGP','ERN','ETB','EUR','FJD','FKP','GBP','GEL',
            'GHS','GIP','GMD','GNF','GTQ','GYD','HKD','HNL','HRK','HTG','HUF','IDR','ILS','INR','IQD','IRR',
            'ISK','JMD','JOD','JPY','KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD','KZT','LAK','LBP','LKR',
            'LRD','LSL','LYD','MAD','MDL','MGA','MKD','MMK','MNT','MOP','MRO','MUR','MVR','MWK','MXN','MYR',
            'MZN','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR',
            'RON','RSD','RUB','RWF','SAR','SBD','SCR','SDG','SEK','SGD','SHP','SLL','SOS','SRD','SSP','STD',
            'SVC','SYP','SZL','THB','TJS','TMT','TND','TOP','TRY','TTD','TWD','TZS','UAH','UGX','USD','UYU',
            'UZS','VEF','VND','VUV','WST','XAF','XCD','XOF','XPF','YER','ZAR','ZMW'
        ], Currency::codes());
    }

    public function testMainCodes()
    {
        $this->assertEquals(['USD', 'EUR', 'GBP', 'CNY', 'AUD', 'RUB', 'INR', 'ZAR'], Currency::MAIN_CODES);
        $this->assertEmpty(array_diff(Currency::MAIN_CODES, Currency::codes()));
    }

    public function testHas()
    {
        $this->assertTrue(Currency::has('RUB'));
        $this->assertTrue(Currency::has('USD'));
        $this->assertTrue(Currency::has('CNY'));
        $this->assertFalse(Currency::has('XXX'));
    }

    public function testNames()
    {
        $this->assertArraySubset(['RUB' => 'Russian Ruble', 'USD' => 'US Dollar', 'CNY' => 'Chinese Yuan'], Currency::names());
        $this->assertSame(['CNY' => 'Chinese Yuan', 'RUB' => 'Russian Ruble', 'USD' => 'US Dollar'], Currency::names(['RUB', 'USD', 'CNY']));
        $this->assertSame(['RUB' => 'Russian Ruble', 'USD' => 'US Dollar', 'CNY' => 'Chinese Yuan'], Currency::names(['RUB', 'USD', 'CNY'], false));
    }

    public function testAllNames()
    {
        $this->assertEmpty(array_diff(Currency::codes(), array_keys(Currency::allNames())));
    }

    public function testName()
    {
        $this->assertSame('Russian Ruble', Currency::name('RUB'));
        $this->assertSame('US Dollar', Currency::name('USD'));
        $this->assertSame('Chinese Yuan', Currency::name('CNY'));
    }

    public function testFindMainCode()
    {
        $this->assertSame('USD', Currency::findMainCode(['RUB', 'CAD', 'USD', 'MXN']));
        $this->assertNull(Currency::findMainCode(['CAD', 'MXN']));
    }

    public function testCountryCurrencyCode()
    {
        $this->assertSame('RUB', Currency::countryCurrencyCode('RU'));
        $this->assertSame('USD', Currency::countryCurrencyCode('US'));
        $this->assertSame('CNY', Currency::countryCurrencyCode('CN'));
    }

    public function testCountryCurrencySymbol()
    {
        $this->assertSame('₽', Currency::countryCurrencySymbol('RU'));
        $this->assertSame('$', Currency::countryCurrencySymbol('US'));
        $this->assertSame('￥', Currency::countryCurrencySymbol('CN'));
    }

    public function testCurrencySymbol()
    {
        $this->assertSame('₽', Currency::currencySymbol('RUB'));
        $this->assertSame('$', Currency::currencySymbol('USD'));
        $this->assertSame('CN¥', Currency::currencySymbol('CNY')); // for en-US locale
    }
}