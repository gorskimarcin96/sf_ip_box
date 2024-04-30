<?php

namespace App\Report\Factory;

readonly class ReportYear
{
    public function __construct(private CompanyReports2024 $report2024)
    {
    }

    public function createFactoryForYear(int $year): CompanyReports2024
    {
        return match ($year) {
            2024 => $this->report2024,
            default => throw new \LogicException('Report for year '.$year.' is not defined.')
        };
    }
}
