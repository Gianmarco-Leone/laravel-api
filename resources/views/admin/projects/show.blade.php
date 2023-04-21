@extends('layouts.app')

@section('page-name', $project->title)

@section('content')

    <section class="container text-center pt-4">

        @if (session('message_content'))
            <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
                {{session('message_content')}}
            </div>
        @endif

        <h1 class="my-4">Dettaglio - {{$project->title}}</h1>

        <div class="d-flex justify-content-center">
            <a href="{{route('admin.projects.index')}}" class="btn btn-primary me-3">
                Torna alla lista
            </a>
    
            <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-primary ms-3">
                Modifica progetto
            </a>
        </div>

        <div class="card clearfix my-4">
            <div class="card-body">
                <figure class="float-end ms-5 mb-3">
                    <img src="{{$project->getImageUri()}}" alt="{{$project->title}}" width="300">
                    <figcaption>
                        <p class="text-muted text-secondary m-0">
                            {{$project->slug}}
                        </p>
                    </figcaption>
                </figure>

                <div class="d-flex flex-wrap justify-content-evenly mb-4">
                    <p>
                        <strong>Tipologia:</strong>
                        <br>
                        @if ($project->type)
                            {!!$project->type?->getPillsHTML()!!}
                        @else
                            Tipologia non specificata
                        @endif
                    </p>
    
                    <div>
                        <strong>Tecnologie:</strong>
                        <ul>
                            @forelse ($project->technologies as $technology)
                                <li>
                                    {!!$technology->getBadgeHTML()!!}
                                </li>
                            @empty
                                Nessuna tecnologia associata
                            @endforelse 
                        </ul>
                    </div>

                    <p>
                        <strong>Creato il:</strong>
                        <br>
                        {{$project->created_at}}
                    </p>
    
                    <p>
                        <strong>Ultima modifica:</strong>
                        <br>
                        {{$project->updated_at}}
                    </p>
                </div>

                <p class="mb-5">
                    <strong class="text-center">Descrizione:</strong>
                    <br>
                    {{$project->description}}
                </p>

                <p class="text-start">
                    <strong>Stato:</strong>
                    <span class="{{$project->is_published ? 'text-success' : 'text-danger'}}">
                        {{$project->is_published ? 'Pubblicato' : 'Da pubblicare'}}
                    </span>
                </p>
            </div>
        </div>
    </section>

@endsection