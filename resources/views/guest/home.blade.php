@extends('layouts.guest')

@section('content')

<section class="container py-4">
    <h1 class="my-4">I Progetti</h1>
    
    <div class="row flex-nowrap g-5">
        @forelse($projects as $project)
            <div class="col-4">
                <div class="card">
                    <div class="card-top">
                        <img src="{{$project->getImageUri()}}" class="card-img-top" alt="{{$project->title}}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">{{$project->title}}</h5>
                        <p class="card-text">{{$project->getAbstract(90)}}</p>
                        <div class="text-end">
                            <a href="{{route('card_detail', ['index' => $project->id])}}" class="btn btn-primary">
                                Dettaglio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <h2>Nessun progetto</h2>
            </div>
        @endforelse
    </div>
    
</section>

@endsection