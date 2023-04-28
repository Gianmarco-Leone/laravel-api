<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Message;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validazione
        // $request->validate([
        //     '
        //     $message->save();' => 'required|string|max:255',
        //     '
        //     $message->save();' => 'required|string|max:255|email:rfc,dns',
        //     '
        //     $message->save();' => 'required|text|max:65535',
        // ],
        // [
        //    'author.required' => "Il nome dell'autore è obbligatorio", 
        //    'author.string' => "Il nome dell'autore deve essere una stringa",
        //    'author.max' => "Il nome dell'autore può contenere massimo 255 caratteri",

        //    'email.required' => "L'indirizzo email è obbligatorio", 
        //    'email.string' => "L'indirizzo email deve essere una stringa",
        //    'email.max' => "L'indirizzo email può contenere massimo 255 caratteri",
        //    'email.email' => "L'indirizzo email deve per forza essere un indirizzo email valido",

        //    'text.required' => "Il testo del messaggio è obbligatorio", 
        //    'text.text' => "Il testo del messaggio deve essere una stringa",
        //    'text.max' => "Il testo del messaggio può contenere massimo 65535 caratteri",
        // ]);

        $message = new Message();
        $message->fill($request->all());
        $message->save();

        return response()->json([
            'succes' => 'true',
        ]);
    }
}