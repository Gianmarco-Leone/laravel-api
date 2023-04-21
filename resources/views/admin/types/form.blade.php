@extends('layouts.app')

@section('page-name', 'Modifica tipologia')

@section('content')

<section class="container pt-4">

    <!-- Se sono presenti errori nella compilazione del form -->
    @include('layouts.partials._validation-errors')

    <div class="text-center">
        <h1 class="my-4">{{$type->id ? 'Modifica tipologia - ' . $type->label : 'Aggiungi una nuova tipologia'}}</h1>

        <a href="{{route('admin.types.index')}}" class="btn btn-primary">
            Torna alla lista
        </a>
    </div>

    <div class="card my-5">
        <div class="card-body">

            @if ($type->id)
                <form method="POST" action="{{route('admin.types.update', $type)}}" class="row">
                @method('put')
            @else
                <form method="POST" action="{{route('admin.types.store')}}" class="row">
            @endif 
                @csrf
    
                <div class="col-4">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="label" class="form-label">
                                Tipologia    
                            </label> 
                            <input type="text" name="label" id="label" class="@error('label') is-invalid @enderror form-control" value="{{old('label', $type->label)}}">
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
                            <input type="color" name="color" id="color" class="@error('color') is-invalid @enderror form-control" value="{{old('color', $type->color)}}">
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