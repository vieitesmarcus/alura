<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }
}
