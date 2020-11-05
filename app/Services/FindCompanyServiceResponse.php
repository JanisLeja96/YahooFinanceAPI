<?php

namespace App\Services;

use App\Models\Company;

class FindCompanyServiceResponse
{
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }
}