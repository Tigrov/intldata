<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\Locale;

class LocaleTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEmpty(array_diff(['ru_RU', 'en_US', 'zh_Hans_CN'], Locale::codes()));
    }

    public function testHas()
    {
        $this->assertTrue(Locale::has('ru_RU'));
        $this->assertTrue(Locale::has('en_US'));
        $this->assertTrue(Locale::has('zh_Hans_CN'));
        $this->assertFalse(Locale::has('xx'));
    }

    public function testNames()
    {
        $this->assertArraySubset(['ru_RU' => 'Russian (Russia)', 'en_US' => 'English (United States)', 'zh_Hans_CN' => 'Chinese (Simplified, China)'], Locale::names());
        $this->assertSame(['zh-Hans-CN' => 'Chinese (Simplified, China)', 'en-US' => 'English (United States)', 'ru-RU' => 'Russian (Russia)'], Locale::names(['ru-RU', 'en-US', 'zh-Hans-CN']));
        $this->assertSame(['ru-RU' => 'Russian (Russia)', 'en-US' => 'English (United States)', 'zh-Hans-CN' => 'Chinese (Simplified, China)'], Locale::names(['ru-RU', 'en-US', 'zh-Hans-CN'], false));
    }

    public function testName()
    {
        $this->assertSame('Russian (Russia)', Locale::name('ru-RU'));
        $this->assertSame('English (United States)', Locale::name('en-US'));
        $this->assertSame('Chinese (Simplified, China)', Locale::name('zh-Hans-CN'));
    }

    public function testLocaleName()
    {
        $this->assertSame('русский (Россия)', Locale::localeName('ru-RU'));
        $this->assertSame('English (United States)', Locale::localeName('en-US'));
        $this->assertSame('中文（简体、中国）', Locale::localeName('zh-Hans-CN'));
    }

    public function testLocaleNames()
    {
        $this->assertSame(['ru-RU' => 'русский (Россия)', 'en-US' => 'English (United States)', 'zh-Hans-CN' => '中文（简体、中国）'], Locale::localeNames(['ru-RU', 'en-US', 'zh-Hans-CN']));
    }

    public function testAcceptCode()
    {
        $this->assertSame('en_US', Locale::acceptCode('en-US,en;q=0.9,ru;q=0.8'));
    }

    public function testLanguageCode()
    {
        $this->assertSame('ru', Locale::languageCode('ru-RU'));
        $this->assertSame('en', Locale::languageCode('en-US'));
        $this->assertSame('zh', Locale::languageCode('zh-Hans-CN'));
    }

    public function testLanguageLocaleCodes()
    {
        $this->assertEmpty(array_diff(['ru_RU', 'ru_BY'], Locale::languageLocaleCodes('ru')));
        $this->assertEmpty(array_diff(['en_US', 'en_GB', 'en_AU', 'en_CA'], Locale::languageLocaleCodes('en')));
        $this->assertEmpty(array_diff(['zh_Hans_CN', 'zh_Hant_TW'], Locale::languageLocaleCodes('zh')));
    }

    public function testLanguagesLocaleCodes()
    {
        $this->assertEmpty(array_diff(['ru_RU', 'ru_BY'], Locale::languagesLocaleCodes()['ru']));
        $this->assertEmpty(array_diff(['en_US', 'en_GB', 'en_AU', 'en_CA'], Locale::languagesLocaleCodes()['en']));
        $this->assertEmpty(array_diff(['zh_Hans_CN', 'zh_Hant_TW'], Locale::languagesLocaleCodes()['zh']));
    }

    public function testCountryLocaleCodes()
    {
        $this->assertEmpty(array_diff(['be_BY', 'ru_BY'], Locale::countryLocaleCodes('BY')));
        $this->assertEmpty(array_diff(['en_US', 'es_US'], Locale::countryLocaleCodes('US')));
        $this->assertEmpty(array_diff(['zh_Hans_CN'], Locale::countryLocaleCodes('CN')));
    }

    public function testCountriesLocaleCodes()
    {
        $this->assertEmpty(array_diff(['be_BY', 'ru_BY'], Locale::countriesLocaleCodes()['BY']));
        $this->assertEmpty(array_diff(['en_US', 'es_US'], Locale::countriesLocaleCodes()['US']));
        $this->assertEmpty(array_diff(['zh_Hans_CN'], Locale::countriesLocaleCodes()['CN']));
    }

    public function testFindMainCode()
    {
        $this->assertSame('en-US', Locale::findMainCode(['ru-RU', 'en-US', 'ja-JP']));
        $this->assertEmpty(Locale::findMainCode(['ja-JP', 'fi-FI']));
    }

    public function testCountryLocaleCode()
    {
        $this->assertSame('ru_RU', Locale::countryLocaleCode('RU'));
        $this->assertSame('en_US', Locale::countryLocaleCode('US'));
        $this->assertSame('zh_Hans_CN', Locale::countryLocaleCode('CN'));
    }

    public function testLanguageCountryLocaleCode()
    {
        $this->assertSame('ru_RU', Locale::languageCountryLocaleCode('ru', 'RU'));
        $this->assertSame('en_US', Locale::languageCountryLocaleCode('en', 'US'));
        $this->assertSame('zh_Hans_CN', Locale::languageCountryLocaleCode('zh', 'CN'));
    }
}