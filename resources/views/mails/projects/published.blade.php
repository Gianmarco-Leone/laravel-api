<x-mail::message>
# {{$project->title}}

## {{$message}}

{{$project->description}}

@if($project->is_published)
<x-mail::button :url="env('APP_FRONTEND_URL') . '/projects/' . $project->slug">
    Vai al progetto
</x-mail::button>
@endif

Thanks, <br>
{{config('app.name')}}
</x-mail::message>