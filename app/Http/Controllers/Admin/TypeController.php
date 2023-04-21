<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Type;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // * Funzione per visualizzare lista types DB
    public function index(Request $request)
    {

        $sort = (!empty($sort_request=$request->get('sort'))) ? $sort_request : "updated_at";

        $order = (!empty($order_request=$request->get('order'))) ? $order_request : 'desc';

        $types = Type::orderBy($sort, $order)->paginate(10)->withQueryString();
        return view('admin.types.index', compact('types', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // * Funzione per visualizzare form di creazione type nel DB
    public function create()
    {
        $type = new Type;
        return view('admin.types.form', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    // * Funzione per salvare i dati del type inseriti tramite il form della view create
    public function store(Request $request)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        $type = new Type;
        $type->fill($data);
        $type->save();
        return to_route('admin.types.index', $type)
            ->with('message_content', 'Tipologia creata con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    
    // * Funzione per visualizzare dettaglio elemento DB
    public function show(Type $type)
    {
        return view('admin.types.show', compact('type'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    
    // * Funzione per visualizzare form modifica type
    public function edit(Type $type)
    {
        return view('admin.types.form', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */

    // * Funzione per salvare modifiche apportate nel form
    public function update(Request $request, Type $type)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        $type->update($data);
        return to_route('admin.types.index', $type)
        ->with('message_content', 'Tipologia ' . $type->title . ' modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return to_route('admin.types.index')
        ->with('message_type', 'danger')
        ->with('message_content', 'Tipologia ' . $type->title . ' eliminata con successo.');
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