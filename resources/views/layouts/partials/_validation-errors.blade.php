@if($errors->any())
    <div class="alert alert-danger">
        <h5>Durante l'invio del form sono stati riscontrati i seguenti errori:</h5>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif