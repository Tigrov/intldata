<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Language;

class LanguageTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEmpty(array_diff(['zh','en','es','ar','pt','ru','de','fr','it','tr'], Language::codes()));
    }

    public function testMainCodes()
    {
        $this->assertEquals(['zh','en','es','ar','pt','ru','de','fr','it','tr'], Language::MAIN_CODES);
        $this->assertEmpty(array_diff(Language::MAIN_CODES, Language::codes()));
    }

    public function testHas()
    {
        $this->assertTrue(Language::has('ru'));
        $this->assertTrue(Language::has('en'));
        $this->assertTrue(Language::has('zh'));
        $this->assertFalse(Language::has('xx'));
    }

    public function testNames()
    {
        $this->assertArraySubset(['ru' => 'Russian', 'en' => 'English', 'zh' => 'Chinese'], Language::names());
        $this->assertSame(['zh' => 'Chinese', 'en' => 'English', 'ru' => 'Russian'], Language::names(['ru', 'en', 'zh']));
        $this->assertSame(['ru' => 'Russian', 'en' => 'English', 'zh' => 'Chinese'], Language::names(['ru', 'en', 'zh'], false));
    }

    public function testName()
    {
        $this->assertSame('Russian', Language::name('ru'));
        $this->assertSame('English', Language::name('en'));
        $this->assertSame('Chinese', Language::name('zh'));
    }

    public function testLanguageName()
    {
        $this->assertSame('русский', Language::languageName('ru'));
        $this->assertSame('English', Language::languageName('en'));
        $this->assertSame('中文', Language::languageName('zh'));
    }

    public function testLanguageNames()
    {
        $this->assertSame(['ru' => 'русский', 'en' => 'English', 'zh' => '中文'], Language::languageNames(['ru', 'en', 'zh']));
    }

    public function testFindMainCode()
    {
        $this->assertSame('en', Language::findMainCode(['es', 'en', 'pt', 'jp']));
        $this->assertNull(Language::findMainCode(['jp', 'fi']));
    }

    public function testCountryLanguageCodes()
    {
        $this->assertEmpty(array_diff(['en', 'es'], Language::countryLanguageCodes('US')));
    }

    public function testCountriesLanguageCode()
    {
        $this->assertArraySubset(['RU' => 'ru', 'US' => 'en', 'CN' => 'zh'], Language::countriesLanguageCode());
    }

    public function testCountryLanguageCode()
    {
        $this->assertSame('ru', Language::countryLanguageCode('RU'));
        $this->assertSame('en', Language::countryLanguageCode('US'));
        $this->assertSame('zh', Language::countryLanguageCode('CN'));
    }
}