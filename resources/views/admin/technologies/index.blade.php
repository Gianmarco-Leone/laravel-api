@extends('layouts.app')

@section('page-name', 'Lista tecnologie')

@section('content')

<section class="container pt-4">

    @if (session('message_content'))
        <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
            {{session('message_content')}}
        </div>
    @endif

    <div class="row justify-content-between align-items-center my-4">
        <div class="col">
            <h1>Le Tecnologie</h1>
        </div>

        <div class="col-3 text-end">
            <a href="{{route('admin.technologies.create')}}" class="btn btn-primary ms-auto">
                Crea nuova tecnologia
            </a>
            
            <!-- Force Delete -->
            {{-- <a href="{{ url('admin/technologies/trash') }}" class="btn btn-danger ms-auto">Cestino</a> --}}
        </div>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">
                    <a href="{{route('admin.technologies.index')}}?sort=id&order={{$sort == 'id' && $order != 'desc' ? 'desc' : 'asc'}}">
                        ID
                        @if ($sort == 'id')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.technologies.index')}}?sort=label&order={{$sort == 'label' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Tecnologia
                        @if ($sort == 'label')
                            <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.technologies.index')}}?sort=color&order={{$sort == 'color' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Colore
                        @if ($sort == 'color')
                            <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.technologies.index')}}?sort=created_at&order={{$sort == 'created_at' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Creazione
                        @if ($sort == 'created_at')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.technologies.index')}}?sort=updated_at&order={{$sort == 'updated_at' && $order != 'desc' ? 'desc' : 'asc'}}">
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
            @forelse($technologies as $technology)
                <tr>
                    <th scope="row">{{$technology->id}}</th>
                    <td>{{$technology->label}}</td>
                    <td>
                        <span class="circle-color-preview" style="background-color: {{$technology->color}}"></span>
                        {{$technology->color}}
                    </td>
                    <td>{{$technology->created_at}}</td>
                    <td>{{$technology->updated_at}}</td>
                    <td>
                        <!-- Commento la vista del dettaglio che non serve -->
                        {{-- <a href="{{route('admin.technologies.show', $technology)}}" title="Mostra la tipologia">
                            <i class="bi bi-eye-fill"></i>
                        </a> --}}

                        <a href="{{route('admin.technologies.edit', $technology)}}" title="Modifica la tipologia" class="mx-3">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <!-- Bottone che triggera la modal -->
                        <button class="bi bi-trash3-fill btn-icon text-danger" data-bs-toggle="modal" data-bs-target="#delete-technology-{{$technology->id}}" title="Elimina la tipologia"></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nessun risultato</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $technologies->links() }}

</section>

@endsection

@section('modals')
    @foreach($technologies as $technology)
        <!-- Modal -->
        <div class="modal fade" id="delete-technology-{{$technology->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-technology-{{$technology->id}}">Attenzione!!!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare la tipologia <span class="fw-semibold">{{$technology->label}}</span> ?
                        <br>
                        L'operazione non è reveresibile.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <!-- Form per il destroy -->
                        <form method="POST" action="{{route('admin.technologies.destroy', $technology)}}">
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