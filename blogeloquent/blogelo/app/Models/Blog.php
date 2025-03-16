<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Blog extends Model{
    protected $table = "blog";
    public $timestamps = true; // Habilitar timestamps
    const CREATED_AT = 'created'; // Definir la columna personalizada para created_at
    const UPDATED_AT = 'updated'; // Definir la columna personalizada para updated_at

    public function Comments(){
        return $this->hasMany(Comment::class);
    }
}