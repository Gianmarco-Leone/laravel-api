<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Technology;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare lista technologies DB
    public function index(Request $request)
    {
        $sort = (!empty($sort_request=$request->get('sort'))) ? $sort_request : "updated_at";

        $order = (!empty($order_request=$request->get('order'))) ? $order_request : 'desc';

        $technologies = Technology::orderBy($sort, $order)->paginate(15)->withQueryString();
        return view('admin.technologies.index', compact('technologies', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // * Funzione per visualizzare form di creazione technology nel DB
    public function create()
    {
        $technology = new Technology;
        return view('admin.technologies.form', compact('technology'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // * Funzione per salvare i dati della technology inseriti tramite il form della view create
    public function store(Request $request)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        $technology = new Technology;
        $technology->fill($data);
        $technology->save();
        return to_route('admin.technologies.index', $technology)
            ->with('message_content', 'Tecnologia creata con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare dettaglio elemento DB
    public function show(Technology $technology)
    {
        return view('admin.technologies.show', compact('technology'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare form modifica technology
    public function edit(Technology $technology)
    {
        return view('admin.technologies.form', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */

    // * Funzione per salvare modifiche apportate nel form
    public function update(Request $request, Technology $technology)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        $technology->update($data);
        return to_route('admin.technologies.index', $technology)
        ->with('message_content', 'Tecnologia ' . $technology->title . ' modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return to_route('admin.technologies.index')
                ->with('message_type', 'danger')
                ->with('message_content', 'Tecnologia ' . $technology->label . ' eliminata con successo.');
    }

    // * VALIDAZIONE

    private function validation($data) {
        return Validator::make(
            $data,
            [
            'label'=>'required|string|max:30',
            'color'=>'required|string|size:7'
            ],
            [
            'label.required'=>"L'etichetta è obbligatoria",
            'label.string'=>"L'etichetta deve essere una stringa",
            'label.max'=>"L'etichetta deve avere un massimo di 30 caratteri",

            'color.required'=>"Il colore è obbligatorio",
            'color.string'=>"Il colore deve essere una stringa",
            'color.size'=>"Il colore deve essere un esadecimale con massimo 7 caratteri es: #ffffff"
            ],
        )->validate();
    }
}