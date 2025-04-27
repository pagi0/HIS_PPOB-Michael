<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MockupController extends BaseController
{
    public function mockup_register()
    {
        // Simulate a registration process
        $data_ok = [
            'status' => 0,
            'message' => 'Registration successful',
            "data" => null,
        ];

        $data_err = [
            'status' => 102,
            'message' => 'Parameter tidak sesuai',
            "data" => null,
        ];

        //return $this->response->setStatusCode(400)->setJSON($data_err);
        return $this->response->setStatusCode(200)->setJSON($data_ok);
    
    }


    public function mockup_login()
    {
        // Simulate a registration process
        $data_ok = [
            'status' => 0,
            'message' => 'Registration successful',
            'data' => [
                "token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"
            ],
        ];

        $data_err0 = [
            'status' => 102,
            'message' => 'Parameter tidak sesuai',
            "data" => null,
        ];

        $data_err1 = [
            'status' => 103,
            'message' => 'Username password tidak sesuai',
            "data" => null,
        ];

        //return $this->response->setStatusCode(400)->setJSON($data_err0);
        //return $this->response->setStatusCode(401)->setJSON($data_err1);
        return $this->response->setStatusCode(200)->setJSON($data_ok);
    
    }


    public function mockup_transaction()
    {
        // Simulate a registration process
        $data_ok = [
            'status' => 0,
            'message' => 'Registration successful',
            "data" => null,
        ];

        $data_err = [
            'status' => 102,
            'message' => 'Parameter tidak sesuai',
            "data" => null,
        ];

        //return $this->response->setStatusCode(400)->setJSON($data_err);
        return $this->response->setStatusCode(400)->setJSON($data_ok);
    
    }
}
