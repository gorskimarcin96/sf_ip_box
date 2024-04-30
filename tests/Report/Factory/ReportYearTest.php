<?php

namespace App\Tests\Report\Factory;

use App\Report\Factory\CompanyReports2024;
use App\Report\Factory\ReportYear;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReportYearTest extends KernelTestCase
{
    private ReportYear $factory;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var ReportYear $factory */
        $factory = self::getContainer()->get(ReportYear::class);

        $this->factory = $factory;
    }

    public function testCreateFactoryForYear(): void
    {
        $result = $this->factory->createFactoryForYear(2024);

        $this->assertInstanceOf(CompanyReports2024::class, $result);
    }

    public function testCreateFactoryForYearWhenYearIsInvalid(): void
    {
        $this->expectException(\LogicException::class);

        $this->factory->createFactoryForYear(2023);
    }
}
