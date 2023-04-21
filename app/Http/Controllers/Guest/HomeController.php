<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    // Funzione che ritorna la vista del template home guest con la visualizzazione delle card di tutti i progetti
    public function index() {
        $projects = Project::where('is_published', 1)->orderBy('updated_at', 'DESC')->get();
        return view('guest.home', compact('projects'));
    }

    // Funzione per visualizzare il dettaglio della Card per i Guest
    public function showDetail($id) {
        $project = Project::findOrFail($id);

        return view('guest.card_detail', compact('project'));
    }
}