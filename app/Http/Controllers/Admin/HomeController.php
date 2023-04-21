<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Funzione che ritorna la vista del template dashboard
    public function index() {
        return view('admin.home');
    }
}