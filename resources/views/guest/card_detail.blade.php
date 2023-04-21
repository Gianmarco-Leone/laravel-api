@extends('layouts.guest')

@section('content')

<section class="container py-4">
    <h1 class="text-center my-4">{{$project->title}}</h1>

    <figure>
        <img src="{{$project->getImageUri()}}" alt="{{$project->title}}">
    </figure>

    <p class="text-center fs-5">
        <span class="fw-semibold">Tecnologia usata:</span>
        {{$project->type?->label}}
    </p>

    <p class="text-center fs-4">
        {{$project->description}}
    </p>

    <div class="text-center my-4">
        <a href="{{url('/')}}" class="btn btn-primary">
            Torna ai progetti
        </a>
    </div>
    
</section>

@endsection