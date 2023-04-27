<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Type;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Funzione per ritornare solo i Progetti con la spunta pubblicati così da poterli stampare in un'app Vue
    public function index()
    {
        $projects = Project::where('is_published', true)
        ->with('type', 'technologies') // Eager Loading per passarmi tramite API anche le tabelle types e technologies
        ->orderBy('updated_at', 'DESC')
        ->paginate(4);

        // Controllando tutti i progetti, invoco il getter dell'image scritto nel Model Project
        foreach($projects as $project) {
            $project->image = $project->getImageUri();
        }

        return response()->json($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Funzione per ritornare il dettaglio del singolo oggetto passando lo Slug (che ho precedentemento reso unico) come parametro  
    public function show($slug)
    {
        // Query per il progetto facendo un JOIN anche delle table types e technologies
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();

        $project->image = $project->getImageUri();

        // SE non si trovano risultati crea un errore 404
        if (!$project) return response(null, 404);

        // Infine ritorna il progetto
        return response()->json($project);
    }

    /**
     * Display a listing of project with a type_id.
     *
     * @param  int  $type_id
     * @return \Illuminate\Http\Response
     */

    // Funzione per ritornare solo i Progetti con la spunta pubblicati così da poterli stampare in un'app Vue
    public function getProjectsByType($type_id)
    {
        $projects = Project::where('type_id', $type_id)
                            ->where('is_published', true)
                            ->with('type', 'technologies')
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(4);

        $type = Type::find($type_id);


        // Controllando tutti i progetti, invoco il getter dell'image scritto nel Model Project
        foreach($projects as $project) {
            $project->image = $project->getImageUri();
        }

        return response()->json(compact('projects', 'type'));
    }
}