<?php

// app/Helpers/info_helper.php
use CodeIgniter\CodeIgniter;

function get_api_base(): string
{
    return env('API_BASE');
}