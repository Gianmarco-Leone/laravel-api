@extends('layouts.app')

@section('page-name', 'Lista tipologie')

@section('content')

<section class="container pt-4">

    @if (session('message_content'))
        <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
            {{session('message_content')}}
        </div>
    @endif

    <div class="row justify-content-between align-items-center my-4">
        <div class="col">
            <h1>Le Tipologie</h1>
        </div>

        <div class="col-3 text-end">
            <a href="{{route('admin.types.create')}}" class="btn btn-primary ms-auto">
                Crea nuova tipologia
            </a>
            
            <!-- Force Delete -->
            {{-- <a href="{{ url('admin/types/trash') }}" class="btn btn-danger ms-auto">Cestino</a> --}}
        </div>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">
                    <a href="{{route('admin.types.index')}}?sort=id&order={{$sort == 'id' && $order != 'desc' ? 'desc' : 'asc'}}">
                        ID
                        @if ($sort == 'id')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.types.index')}}?sort=label&order={{$sort == 'label' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Tipologia
                        @if ($sort == 'label')
                            <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.types.index')}}?sort=color&order={{$sort == 'color' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Colore
                        @if ($sort == 'color')
                            <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.types.index')}}?sort=created_at&order={{$sort == 'created_at' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Creazione
                        @if ($sort == 'created_at')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.types.index')}}?sort=updated_at&order={{$sort == 'updated_at' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Ultima modifica
                        @if ($sort == 'updated_at')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($types as $type)
                <tr>
                    <th scope="row">{{$type->id}}</th>
                    <td>{{$type->label}}</td>
                    <td>
                        <span class="circle-color-preview" style="background-color: {{$type->color}}"></span>
                        {{$type->color}}
                    </td>
                    <td>{{$type->created_at}}</td>
                    <td>{{$type->updated_at}}</td>
                    <td>
                        <!-- Commento la vista del dettaglio che non serve -->
                        {{-- <a href="{{route('admin.types.show', $type)}}" title="Mostra la tipologia">
                            <i class="bi bi-eye-fill"></i>
                        </a> --}}

                        <a href="{{route('admin.types.edit', $type)}}" title="Modifica la tipologia" class="mx-3">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <!-- Bottone che triggera la modal -->
                        <button class="bi bi-trash3-fill btn-icon text-danger" data-bs-toggle="modal" data-bs-target="#delete-type-{{$type->id}}" title="Elimina la tipologia"></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nessun risultato</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $types->links() }}

</section>

@endsection

@section('modals')
    @foreach($types as $type)
        <!-- Modal -->
        <div class="modal fade" id="delete-type-{{$type->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-type-{{$type->id}}">Attenzione!!!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare la tipologia <span class="fw-semibold">{{$type->label}}</span> ?
                        <br>
                        L'operazione non è reveresibile.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <!-- Form per il destroy -->
                        <form method="POST" action="{{route('admin.types.destroy', $type)}}">
                        @csrf
                        @method('delete')
                        
                        <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection