<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = ["label", "color"];

    // * RELAZIONI

    // Relazione con tabella projects
    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    // * HTML

    // Funzione che restituisce un badge html
    public function getBadgeHTML() {
        return '<span class="badge" style="background-color:' . $this->color . '">'. $this->label .'</span>';
    }
}