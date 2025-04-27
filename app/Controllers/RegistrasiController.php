<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RegistrasiController extends BaseController
{
    public function index()
    {
        return view('registrasi');
    }
}
