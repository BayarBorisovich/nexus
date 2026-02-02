<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class MainController
{
    public function index()
    {
        return Inertia::render('Main');
    }
}
