<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["title", "description", "image", "is_published", "type_id"];

    // * RELAZIONI
    
    // Relazione con tabella technologies
    public function technologies() {
        return $this->belongsToMany(Technology::class);
    }

    // Relazione con tabella types
    public function type() {
        return $this->belongsTo(Type::class);
    }

    
    // * GETTER

     // Funzione che ritorna una sottostringa e accetta come parametro il numero massimo di caratteri desiderati, con un valore di default di 30
     public function getAbstract($max = 30) {
        return substr($this->description, 0 , $max) . "...";
    }

    // Creo un getter per avere sempre o il percorso dell'immagine caricata come file o il path assoluto di un'immagine di placeholder
    public function getImageUri() {
        return $this->image ? asset('storage/' . $this->image) : 'https://www.grouphealth.ca/wp-content/uploads/2018/05/placeholder-image.png';
    }

    // * MUTATORS

    protected function getCreatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    protected function getUpdatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    // * GENERAL

    // Funzione statica per generare uno slug unico che aggiunge un "-" più un numero crescente se riscontra nel DB uno slug uguale a quello che il sistema prova ad inserire
    public static function generateSlug($title) {
        $possible_slug = Str::of($title)->slug('-');
        $projects = Project::where('slug', $possible_slug)->get();
        $original_slug = $possible_slug;
        $i = 2;
        while(count($projects)) {
            $possible_slug = $original_slug . "-" . $i;
            $projects = Project::where('slug', $possible_slug)->get();
            $i++;
        }
        return $possible_slug;
    }

    // * HTML

    // Funzione che restituisce un icona html
    public function getIconHTML() {
        if ($this->is_published) {
            return '<i class="bi bi-check-lg"></i>';
        } else {
            return '<i class="bi bi-x-lg"></i>';
        }
    }
}