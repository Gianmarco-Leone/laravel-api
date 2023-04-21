<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare lista elementi DB
    public function index(Request $request)
    {

        $sort = (!empty($sort_request=$request->get('sort'))) ? $sort_request : "updated_at";

        $order = (!empty($order_request=$request->get('order'))) ? $order_request : 'desc';

        $projects = Project::orderBy($sort, $order)->paginate(10)->withQueryString();
        return view('admin.projects.index', compact('projects', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // * Funzione per visualizzare form di creazione elemento nel DB
    public function create()
    {
        $project = new Project;
        $types = Type::orderBy('label')->get();
        $technologies = Technology::orderBy('label')->get();
        return view('admin.projects.form', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // * Funzione per salvare i dati dell'elemento inseriti tramite il form della view create
    public function store(Request $request)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        // * Metodo della classe Arr di Laravel per cercare un elemento per la chiave all'interno di un array
        if(Arr::exists($data, 'image')) {

            // con il metodo Storage::put() carico l'immagine nella cartella del progetto
            $path = Storage::put('uploads/projects', $data['image']);
            
            $data['image'] = $path;
        };

        $project = new Project;
        $project->fill($data);
        $project->slug = Project::generateSlug($project->title);
        $project->is_published = $request->has('is_published') ? 1 : 0;
        $project->save();

        if(Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);

        return to_route('admin.projects.show', $project)
            ->with('message_content', 'Nuovo progetto aggiunto con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare dettaglio elemento DB
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // * Funzione per visualizzare form di modifica elemento nel DB
    public function edit(Project $project)
    {
        $types = Type::orderBy('label')->get();
        $technologies = Technology::orderBy('label')->get();
        $project_technologies = $project->technologies->pluck('id')->toArray();
        return view('admin.projects.form', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // * Funzione che salva i dati modificati passati tramite form della view edit
    public function update(Request $request, Project $project)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        // * Metodo della classe Arr di Laravel per cercare un elemento per la chiave all'interno di un array
        if(Arr::exists($data, 'image')) {

            // SE il progetto ha già una foto caricata, prima di aggiungerne un'altra elimino l'immagine presente
            if ($project->image) Storage::delete($project->image);
            // con il metodo Storage::put() carico l'immagine nella cartella del progetto
            $path = Storage::put('uploads/projects', $data['image']);
            
            $data['image'] = $path;
        };

        $project->fill($data);
        $project->slug = Project::generateSlug($project->title);
        $project->is_published = $request->has('is_published') ? 1 : 0;
        $project->save();

        if(Arr::exists($data, 'technologies'))
            $project->technologies()->sync($data['technologies']);
        else 
            $project->technologies()->detach();

        return to_route('admin.projects.show', $project)
        ->with('message_content', 'Progetto ' . $project->title . ' modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // * Funzione per eliminare elemento dal DB
    public function destroy(Project $project)
    {
        // Quando elimino un elemento dal DB controllo se aveva un'immagine, in quel caso la elimino
        if($project->image) Storage::delete($project->image);
        
        $project->delete();
        return to_route('admin.projects.index')
        ->with('message_type', 'danger')
        ->with('message_content', 'Progetto ' . $project->title . ' cestinato con successo.');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare lista elementi DB nel cestino
    public function trash(Request $request) {
        $sort = (!empty($sort_request=$request->get('sort'))) ? $sort_request : "updated_at";

        $order = (!empty($order_request=$request->get('order'))) ? $order_request : 'desc';

        $trashed_projects = Project::onlyTrashed()->orderBy($sort, $order)->paginate(10)->withQueryString();
        return view('admin.projects.trash', compact('trashed_projects', 'sort', 'order'));
    }

    /**
     * Restores the specified resource from storage.
     *
     * @param  \App\Models\Shoe  $shoe
     * @return \Illuminate\Http\Response
     */
    public function restore(Int $id)
    {
        $project = Project::where('id', $id)->onlyTrashed()->first();
        $project->restore();
        return to_route('admin.projects.index')->with('message_content', 'Progetto ripristinato!');
    }

    /**
     * Force deletes the specified resource from storage.
     *
     * @param  \App\Models\Shoe  $shoe
     * @return \Illuminate\Http\Response
     */
    public function forcedelete(Int $id)
    {
        $project = Project::where('id', $id)->onlyTrashed()->first();
        if ($project->image) Storage::delete($project->image);

        // * In questo caso non servirebbe perchè nella migration è stato specificato cascadeOnDelete() però per stare sicuri faccio un detach() dei record collegati
        $project->technologies()->detach();

        $project->forceDelete();
        return to_route('admin.projects.trash')->with('message_content', 'Progetto eliminato definitivamente!')
            ->with('message_type', 'danger');
    }



    // * Funzione per la validazione dei campi inseriti nei form
    private function validation($data) {
        return Validator::make(
            $data,
            [
            'title'=>'required|string|max:60',
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
            'description'=>'required|string',
            'is_published' => 'boolean',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'
            ],
            [
            'title.required'=>"Il titolo è obbligatorio",
            'title.string'=>"Il titolo deve essere una stringa",
            'title.max'=>"Il titolo deve essere di massimo 60 caratteri",

            'image.image'=>"Il file caricato deve essere un'immagine",
            'image.mimes'=>"I formati accettati per le immagini sono: jpg, jpeg e png",

            'description.required'=>"La descrizione è obbligatoria",
            'description.string'=>"La descrizione deve essere una stringa",

            'is_published.boolean' => '"Pubblicato" puù assumere solo valori di 1 o 0',

            'type_id.exists' => 'L\'ID della tipologia non è valido',

            'technologies.exists' => 'Le tecnologie selezionate non sono valide'
            ],
        )->validate();
    }
}