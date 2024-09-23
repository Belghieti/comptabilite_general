<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Assurez-vous que seul un utilisateur authentifié peut accéder à cette page
   

    public function index()
    {
        return view('auth.dashboard'); // Charge la vue dashboard.blade.php
    }
}
