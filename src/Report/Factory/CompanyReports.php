<?php

namespace App\Report\Factory;

use App\Report\Company\CompanyInterface;

interface CompanyReports
{
    /**
     * @return CompanyInterface[]
     */
    public function createCompanyReports(): array;
}
