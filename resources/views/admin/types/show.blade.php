@extends('layouts.app')

@section('page-name', $type->label)

@section('content')

    <section class="container text-center pt-4">

        @if (session('message_content'))
            <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}}">
                {{session('message_content')}}
            </div>
        @endif

        <h1 class="my-4">Dettaglio - {{$type->label}}</h1>

        <div class="d-flex justify-content-center">
            <a href="{{route('admin.types.index')}}" class="btn btn-primary me-3">
                Torna alla lista
            </a>
    
            <a href="{{route('admin.types.edit', $type)}}" class="btn btn-primary ms-3">
                Modifica tipologia
            </a>
        </div>

        <div class="row justify-content-center my-5">
            <div class="col-10 border pt-5">
                <div class="row justify-content-center">
                    <div class="col-4 my-5">
                        <p class="fw-semibold">
                            {{$type->label}}
                        </p>
                    </div>
                    <div class="col-4 my-5">
                        <p class="fw-semibold">
                            {!!$type->getBadgeHTML()!!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection