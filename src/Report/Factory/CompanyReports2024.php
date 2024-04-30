<?php

namespace App\Report\Factory;

use App\Report\Company\ACube;
use App\Report\Company\CompanyInterface;

readonly class CompanyReports2024 implements CompanyReports
{
    public function __construct(private ACube $ACube)
    {
    }

    /**
     * @return CompanyInterface[]
     */
    #[\Override]
    public function createCompanyReports(): array
    {
        return [$this->ACube];
    }
}
