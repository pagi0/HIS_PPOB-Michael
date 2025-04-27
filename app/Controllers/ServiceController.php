<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceController extends BaseController
{
    public function index($service = null)
    {
        if ($service) {
            return view('service', ['service' => $service]);
        }

        return view('service');
    }
}
