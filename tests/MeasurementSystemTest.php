<?php

namespace tigrov\tests\unit\pgsql\audit;

use PHPUnit\Framework\TestCase;
use tigrov\intldata\MeasurementSystem;

class MeasurementSystemTest extends TestCase
{
    public function testCodes()
    {
        $this->assertEquals(['SI', 'US'], MeasurementSystem::codes());
    }

    public function testHas()
    {
        $this->assertTrue(MeasurementSystem::has('SI'));
        $this->assertTrue(MeasurementSystem::has('US'));
        $this->assertFalse(MeasurementSystem::has('XX'));
    }

    public function testNames()
    {
        $this->assertSame(['SI' => 'International System (metre, kilogram)', 'US' => 'United States (inch, pound)'], MeasurementSystem::names());
        $this->assertSame(['SI' => 'International System (metre, kilogram)', 'US' => 'United States (inch, pound)'], MeasurementSystem::names(['US', 'SI']));
        $this->assertSame(['US' => 'United States (inch, pound)', 'SI' => 'International System (metre, kilogram)'], MeasurementSystem::names(['US', 'SI'], false));
    }

    public function testName()
    {
        $this->assertSame('International System (metre, kilogram)', MeasurementSystem::name('SI'));
        $this->assertSame('United States (inch, pound)', MeasurementSystem::name('US'));
    }

    public function testCountryMeasurementSystemCode()
    {
        $this->assertSame('SI', MeasurementSystem::countryMeasurementSystemCode('RU'));
        $this->assertSame('US', MeasurementSystem::countryMeasurementSystemCode('US'));
        $this->assertSame('SI', MeasurementSystem::countryMeasurementSystemCode('CN'));
    }
}