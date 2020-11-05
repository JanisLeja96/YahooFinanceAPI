<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

class FindCompanyService
{
    private CompanyRepository $companyRepository;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
    }

    public function execute(string $symbol): FindCompanyServiceResponse
    {
        return new FindCompanyServiceResponse($this->companyRepository->getBySymbol($symbol));
    }
}