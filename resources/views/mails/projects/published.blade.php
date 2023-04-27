<x-mail::message>
# {{$project->title}}

## {{$message}}

{{$project->description}}

@if($project->is_published)
<x-mail::button url=''>
    Vai al progetto
</x-mail::button>
@endif

Thanks, <br>
{{config('app.name')}}
</x-mail::message>