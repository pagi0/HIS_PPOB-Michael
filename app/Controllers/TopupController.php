<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TopupController extends BaseController
{
    public function index()
    {
        return view('topup');
    }
}
