@extends('layouts.app')

@section('page-name', 'Modifica DB')

@section('content')

<div class="container pt-4">

    <!-- Se sono presenti errori nella compilazione del form -->
    @include('layouts.partials._validation-errors')

</div>

<section class="container">

    <div class="text-center">
        <h1 class="my-4">{{$project->id ? 'Modifica progetto - ' . $project->title : 'Aggiungi un nuovo progetto'}}</h1>

        <a href="{{route('admin.projects.index')}}" class="btn btn-primary">
            Torna alla lista
        </a>

        @if (session('message_content'))
        <div class="alert alert-{{session('message_type') ? session('message_type') : 'success'}} mt-4">
            {{session('message_content')}}
        </div>
        @endif
    </div>

    <div class="card my-5 p-3">
        <div class="card-body">

            @if ($project->id)
                <form method="POST" action="{{route('admin.projects.update', $project)}}" enctype="multipart/form-data" class="row">
                @method('put')
            @else
                <form method="POST" action="{{route('admin.projects.store')}}" enctype="multipart/form-data" class="row">
            @endif 
                @csrf
                    <div class="col-6 mb-4">
                        <label for="title" class="form-label">
                            Titolo    
                        </label> 
                        <input type="text" name="title" id="title" class="@error('title') is-invalid @enderror form-control" value="{{old('title', $project->title)}}">
                        @error('title')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-4">
                        <label for="type_id" class="form-label">
                            Tipologia    
                        </label> 
                        <select name="type_id" id="type_id" class="@error('type_id') is-invalid @enderror form-select">
                            <option value="">Non specificato</option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}" @if(old('type_id', $project->type_id) == $type->id) selected @endif>{{$type->label}}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-3 form-label">
                                Tecnologie usate:
                            </div>
                            <div class="col-9">
                                <div class="form-check @error('technologies')is-invalid @enderror">
                                    @foreach ($technologies as $technology)
                                        <label for="technology-{{$technology->id}}" class="me-3">
                                            {{$technology->label}}    
                                        </label>
                                        <input 
                                            type="checkbox" 
                                            value="{{$technology->id}}" 
                                            name="technologies[]" 
                                            id="technology-{{$technology->id}}"
                                            @if(in_array($technology->id, old('technologies', $project_technologies ?? []))) checked @endif
                                            class="form-check-control"
                                        >
                                    @endforeach
                                </div>
                                
                                @error('technologies')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>            
                    </div>

                    <!-- Sezione upload immagine + anteprima -->
                    <div class="col-8">
                        <label for="image" class="form-label">
                            Immagine    
                        </label> 
                        <input type="file" name="image" id="image" class="@error('image') is-invalid @enderror form-control" value="{{old('image', $project->image)}}">
                        @error('image')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-4 border p-2 position-relative">
                        <img src="{{$project->getImageUri()}}" alt="{{$project->title}}" class="img-fluid" id="image_preview">
                        @if($project->image)
                        <span id="button-delete-project-image" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            X
                        </span>
                        @endif
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">
                            Descrizione    
                        </label>
                        <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control"  rows="6">{{old('description', $project->description)}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-2 mt-4">
                        <div class="form-check form-switch">
                            <label for="is_published" class="form-check-label">
                                Pubblicato    
                            </label>
                            <input type="checkbox" name="is_published" id="is_published" class="@error('is_published') is-invalid @enderror form-check-input" role="switch" value="1" @checked(old('is_published', $project->is_published))>
                            @error('is_published')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="offset-8 col-4 text-end my-4">
                        <button type="submit" class="btn btn-primary">
                            Salva
                        </button>
                    </div>

                </form>

                @if($project->image)
                {{-- FORM eliminazione image preview --}}
                <form id="form-delete-project-image" action="{{route('admin.projects.deleteimage', $project)}}" method="POST">
                    @method('delete')
                    @csrf

                </form>
                @endif
        </div>
    </div>
</section>

@endsection

@section('scripts')

<script>
    const imageEl = document.getElementById('image');
    const imagePreviewEl = document.getElementById('image_preview');
    const imagePlaceholder = imagePreviewEl.src;

    imageEl.addEventListener(
        'change', () => {
            if (imageEl.files && imageEl.files[0]) {
                const reader = new FileReader();
                reader.readAsDataURL(imageEl.files[0]);

                reader.onload = e => {
                    imagePreviewEl.src = e.target.result;
                }
            } else {
                imagePreviewEl.src = imagePlaceholder;
            }
        });
</script>

@if($project->image)
<script>
    const deleteImageButton = document.getElementById('button-delete-project-image');
    const deleteImageForm = document.getElementById('form-delete-project-image');

    deleteImageButton.addEventListener(
        'click', () => {
            deleteImageForm.submit();
        });
</script>
@endif

@endsection