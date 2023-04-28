@extends('layouts.app')

@section('page-name', 'Messagio')

@section('content')

    <section class="container text-center pt-4">

        @if (session('message_content'))
            <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
                {{session('message_content')}}
            </div>
        @endif

        <h1 class="my-4">Messagio da {{$message->author}}</h1>

        <div class="d-flex justify-content-center">
            <a href="{{route('admin.messages.index')}}" class="btn btn-primary me-3">
                Torna alla lista
            </a>
    
            {{-- ? MODIFICA --}}
            {{-- <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-primary ms-3">
                Modifica progetto
            </a> --}}
        </div>

        <div class="card my-4">
            <div class="card-header d-flex justify-content-between">
                <strong>
                    {{$message->author}}
                </strong>
                <span>
                    {{$message->email}}
                </span>
            </div>
            <div class="card-body">
                <p>
                    {{$message->text}}
                </p>
            </div>
            <div class="card-footer">
                Inviato: {{$message->created_at}}
            </div>
        </div>
    </section>

@endsection