<?php

namespace App\Http\Controllers\Healthspace;

use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    public function show()
    {
        // Asumsi bahwa 'healthspace.resources.views.homepage' adalah path ke view Anda
        return view('healthspace.resources.views.homepage');
    }
}

