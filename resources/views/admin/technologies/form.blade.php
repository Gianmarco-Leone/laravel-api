@extends('layouts.app')

@section('page-name', 'Modifica tecnologia')

@section('content')

<section class="container pt-4">

    <!-- Se sono presenti errori nella compilazione del form -->
    @include('layouts.partials._validation-errors')

    <div class="text-center">
        <h1 class="my-4">{{$technology->id ? 'Modifica tecnologia - ' . $technology->label : 'Aggiungi una nuova tecnologia'}}</h1>

        <a href="{{route('admin.technologies.index')}}" class="btn btn-primary">
            Torna alla lista
        </a>
    </div>

    <div class="card my-5">
        <div class="card-body">

            @if ($technology->id)
                <form method="POST" action="{{route('admin.technologies.update', $technology)}}" class="row">
                @method('put')
            @else
                <form method="POST" action="{{route('admin.technologies.store')}}" class="row">
            @endif 
                @csrf
    
                <div class="col-4">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="label" class="form-label">
                                Tipologia    
                            </label> 
                            <input type="text" name="label" id="label" class="@error('label') is-invalid @enderror form-control" value="{{old('label', $technology->label)}}">
                            @error('label')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label for="color" class="form-label">
                                Colore    
                            </label> 
                            <input type="color" name="color" id="color" class="@error('color') is-invalid @enderror form-control" value="{{old('color', $technology->color)}}">
                            @error('color')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="offset-8 col-4 text-end my-4">
                    <button type="submit" class="btn btn-primary">
                        Salva
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection