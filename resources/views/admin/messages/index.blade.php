@extends('layouts.app')

@section('page-name', 'Lista messaggi')

@section('content')

<section class="container pt-4">

    @if (session('message_content'))
        <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
            {{session('message_content')}}
        </div>
    @endif

    <div class="row justify-content-between align-items-center my-4">
        <div class="col">
            <h1>Messaggi ricevuti</h1>
        </div>

        <div class="col-3 text-end">
            {{-- ! SOFT DELETE --}}
        {{-- <a href="{{ url('admin/messages/trash') }}" class="btn btn-danger ms-auto">Cestino</a> --}}
        </div>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">
                    <a href="{{route('admin.messages.index')}}?sort=id&order={{$sort == 'id' && $order != 'desc' ? 'desc' : 'asc'}}">
                        ID
                        @if ($sort == 'id')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.messages.index')}}?sort=author&order={{$sort == 'author' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Autore
                        @if ($sort == 'author')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.messages.index')}}?sort=email&order={{$sort == 'email' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Email
                        @if ($sort == 'email')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.messages.index')}}?sort=text&order={{$sort == 'text' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Testo
                        @if ($sort == 'text')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.messages.index')}}?sort=created_at&order={{$sort == 'created_at' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Ricevuto
                        @if ($sort == 'created_at')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>

                {{-- ? MODIFICA --}}
                {{-- <th scope="col">
                    <a href="{{route('admin.messages.index')}}?sort=updated_at&order={{$sort == 'updated_at' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Ultima modifica
                        @if ($sort == 'updated_at')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th> --}}
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr>
                    <th scope="row">{{$message->id}}</th>
                    <td>{{$message->author}}</td>
                    <td>{{$message->email}}</td>
                    <td>{{$message->getAbstract()}}</td>
                    <td>{{$message->created_at}}</td>
                    <td>
                        <a href="{{route('admin.messages.show', $message)}}" title="Mostra il messaggio">
                            <i class="bi bi-eye-fill"></i>
                        </a>

                        {{-- ? MODIFICA --}}
                        {{-- <a href="{{route('admin.messages.edit', $message)}}" title="Modifica il progetto" class="mx-3">
                            <i class="bi bi-pencil-fill"></i>
                        </a> --}}

                        {{-- ? ELIMINAZIONE --}}
                        <!-- Bottone che triggera la modal -->
                        {{-- <button class="bi bi-trash3-fill btn-icon text-danger" data-bs-toggle="modal" data-bs-target="#trash-message-{{$message->id}}" title="Cestina il progetto"></button> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" scope="row">Nessun risultato</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $messages->links() }}

</section>

@endsection




{{-- ? MODALI --}}
{{-- @section('modals')
    @foreach($messages as $message)
        <!-- Modal -->
        <div class="modal fade" id="trash-message-{{$message->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Attenzione!!!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler spostare nel cestino il progetto <span class="fw-semibold">{{$message->title}}</span> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <!-- Form per il destroy -->
                        <form method="POST" action="{{route('admin.messages.destroy', $message)}}">
                        @csrf
                        @method('delete')
                        
                        <button type="submit" class="btn btn-danger">Cestina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection --}}