@extends('layouts.app')

@section('page-name', 'Cestino')

@section('content')

<section class="container pt-4">

    @if (session('message_content'))
        <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
            {{session('message_content')}}
        </div>
    @endif

    <div class="row justify-content-between align-items-center my-4">
        <div class="col">
            <h1>Cestino</h1>
        </div>

        <div class="col-3 text-end">
            <a href="{{route('admin.projects.index')}}" class="btn btn-primary ms-auto">
                Torna alla lista
            </a>
        </div>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">
                    <a href="{{route('admin.projects.trash')}}?sort=id&order={{$sort == 'id' && $order != 'desc' ? 'desc' : 'asc'}}">
                        ID
                        @if ($sort == 'id')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.trash')}}?sort=title&order={{$sort == 'title' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Titolo
                        @if ($sort == 'title')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.trash')}}?sort=type_id&order={{$sort == 'type_id' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Tipologia
                        @if ($sort == 'type_id')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">Tecnologie</th>
                <th scope="col">
                    <a href="{{route('admin.projects.trash')}}?sort=description&order={{$sort == 'description' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Descrizione
                        @if ($sort == 'description')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.trash')}}?sort=created_at&order={{$sort == 'created_at' && $order != 'desc' ? 'desc' : 'asc'}}">
                        Creazione
                        @if ($sort == 'created_at')
                        <i class="bi bi-caret-down-fill d-inline-block @if($order == 'desc') rotate-180 @endif"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="{{route('admin.projects.trash')}}?sort=updated_at&order={{$sort == 'updated_at' && $order != 'desc' ? 'desc' : 'asc'}}">
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
            @forelse($trashed_projects as $project)
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
                    <td>{{$project->created_at}}</td>
                    <td>{{$project->updated_at}}</td>
                    <td>
                        <button class="bi bi-recycle btn-icon ms-3 text-success" data-bs-toggle="modal"
                        data-bs-target="#restore-modal-{{ $project->id }}" title="Ripristina il progetto">
                        </button>

                        <button class="bi bi-trash3-fill btn-icon ms-3 text-danger" data-bs-toggle="modal"
                        data-bs-target="#delete-modal-{{ $project->id }}" title="Elimina il progetto">
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Cestino vuoto</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $trashed_projects->links() }}

</section>

@endsection

@section('modals')
    @foreach($trashed_projects as $project)

        <!-- Modal restore -->
        <div class="modal fade" id="restore-modal-{{ $project->id }}" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="restore-modal-{{ $project->id }}-label" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="restore-modal-{{ $project->id }}-label">Conferma Ripristino</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                Sei sicuro di voler ripristinare il prodotto <strong>{{ $project->model }}</strong> con ID
                <strong> {{ $project->id }}</strong>?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                <!-- Form per il restore -->
                <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST" class="">
                    @method('put')
                    @csrf

                    <button type="submit" class="btn btn-success">Ripristina</button>
                </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal delete -->
        <div class="modal fade" id="delete-modal-{{ $project->id }}" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="delete-modal-{{ $project->id }}-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-project-{{$project->id}}">Attenzione!!!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare definitivamente il progetto <span class="fw-semibold">{{$project->title}}</span> dal DataBase?
                        <br>
                        Ricorda che l'operazione non è reversibile.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <!-- Form per il forceDelete -->
                        <form method="POST" action="{{route('admin.projects.forcedelete', $project->id)}}">
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