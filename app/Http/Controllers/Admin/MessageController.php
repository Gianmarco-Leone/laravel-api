<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Message;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare lista messaggi inviati dai visitatori
    public function index(Request $request)
    {
        $sort = (!empty($sort_request=$request->get('sort'))) ? $sort_request : "updated_at";

        $order = (!empty($order_request=$request->get('order'))) ? $order_request : 'desc';

        $messages = Message::orderBy($sort, $order)->paginate(10)->withQueryString();
        return view('admin.messages.index', compact('messages', 'sort', 'order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('admin.messages.show', compact('message'));
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // * Funzione per eliminare messaggi dal DB
    public function destroy()
    {
        // 
    }
}