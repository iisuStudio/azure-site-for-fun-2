<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Modal extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }
}
