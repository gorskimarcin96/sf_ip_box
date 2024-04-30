<?php

namespace App\Tests\Report\Factory;

use App\Report\Company\ACube;
use App\Report\Company\CompanyInterface;
use App\Report\Factory\CompanyReports2024;
use PHPUnit\Framework\TestCase;

class CompanyReports2024Test extends TestCase
{
    public function testCreateCompanyReports(): void
    {
        $factory = new CompanyReports2024($this->createMock(ACube::class));
        $result = $factory->createCompanyReports();

        $this->assertIsArray($result);
        $this->assertInstanceOf(CompanyInterface::class, $result[0]);
    }
}
