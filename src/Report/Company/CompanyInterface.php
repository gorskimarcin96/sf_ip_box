<?php

namespace App\Report\Company;

interface CompanyInterface
{
    public function getName(): string;

    /**
     * @return TaskService[]
     */
    public function getTaskServices(int $year): array;
}
