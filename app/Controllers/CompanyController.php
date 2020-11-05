<?php

namespace App\Controllers;

use App\Models\Company;
use App\Services\FindCompanyService;

class CompanyController
{


    public function index()
    {
        return require_once __DIR__ . '/../../app/Views/IndexView.php';
    }

    public function find()
    {
        try {
            $response = (new FindCompanyService())->execute($_POST['symbol']);
            $company = $response->getCompany();
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return require_once __DIR__ . '/../../app/Views/ShowView.php';
    }
}