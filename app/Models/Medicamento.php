<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    public function receitas()
    {
        return $this->belongsToMany('App\Models\Receita')->using('App\Models\Medicamento_Receita');
    }
}
