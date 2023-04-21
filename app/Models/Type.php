<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ["label", "color"];

    // * Relazione con table projects
    public function projects() {
        return $this->hasMany(Project::class);
    }

    // * HTML

    // Funzione che restituisce una pills html
    public function getPillsHTML() {
        return '<span class="badge rounded-pill" style="background-color:' . $this->color . '">'. $this->label .'</span>';
    }
}