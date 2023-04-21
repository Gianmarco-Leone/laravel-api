@extends('layouts.app')

@section('page-name', 'Lista progetti')

@section('content')

<section class="container pt-4">

    @if (session('message_content'))
        <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
            {{session('message_content')}}
        </div>
    @endif

    <div class="row justify-content-between align-items-center my-4">
        <div class="col">
            <h1>I Progetti</h1>
        </div>

        <div class="col-3 text-end">
            <a href="{{route('admin.projects.create')}}" class="btn btn-primary ms-auto">
                Crea nuovo progetto
            </a>
            
        <a href="{{ url('admin/projects/trash') }}" class="btn btn-danger ms-auto">Cestino</a>
        </div>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">
                    <a href="{{route('admin.projects.index')}}?sort=id&order={{$sort == 'id' && $order != 'desc' ? 'desc' : 'asc'}}">
                        ID
                        @if ($sort == 'id')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.index')}}?sort=title&order={{$sort == 'title' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Titolo
                        @if ($sort == 'title')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.index')}}?sort=type_id&order={{$sort == 'type_id' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Tipologia
                        @if ($sort == 'type_id')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">Tecnologie</th>
                <th scope="col">
                    <a href="{{route('admin.projects.index')}}?sort=description&order={{$sort == 'description' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Descrizione
                        @if ($sort == 'description')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.index')}}?sort=is_published&order={{$sort == 'is_published' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Pubblicato
                        @if ($sort == 'is_published')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.index')}}?sort=created_at&order={{$sort == 'created_at' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Creazione
                        @if ($sort == 'created_at')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.index')}}?sort=updated_at&order={{$sort == 'updated_at' && $order != 'desc' ? 'desc' : 'asc'}}">
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
            @forelse($projects as $project)
                <tr>
                    <th scope="row">{{$project->id}}</th>
                    <td>{{$project->title}}</td>
                    <td>{!!$project->type?->getPillsHTML()!!}</td>
                    <td>
                        @forelse ($project->technologies as $technology)
                            {!!$technology->getBadgeHTML()!!}
                        @empty
                            -
                        @endforelse 
                    </td>
                    <td>{{$project->getAbstract()}}</td>
                    <td class="text-center">
                        <span class="{{$project->is_published ? 'text-success' : 'text-danger'}}">
                            {!!$project->getIconHTML()!!}
                        </span>
                    </td>
                    <td>{{$project->created_at}}</td>
                    <td>{{$project->updated_at}}</td>
                    <td>
                        <a href="{{route('admin.projects.show', $project)}}" title="Mostra il progetto">
                            <i class="bi bi-eye-fill"></i>
                        </a>

                        <a href="{{route('admin.projects.edit', $project)}}" title="Modifica il progetto" class="mx-3">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <!-- Bottone che triggera la modal -->
                        <button class="bi bi-trash3-fill btn-icon text-danger" data-bs-toggle="modal" data-bs-target="#trash-project-{{$project->id}}" title="Cestina il progetto"></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" scope="row">Nessun risultato</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $projects->links() }}

</section>

@endsection

@section('modals')
    @foreach($projects as $project)
        <!-- Modal -->
        <div class="modal fade" id="trash-project-{{$project->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Attenzione!!!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler spostare nel cestino il progetto <span class="fw-semibold">{{$project->title}}</span> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <!-- Form per il destroy -->
                        <form method="POST" action="{{route('admin.projects.destroy', $project)}}">
                        @csrf
                        @method('delete')
                        
                        <button type="submit" class="btn btn-danger">Cestina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection