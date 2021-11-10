<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function farmaceutico()
    {
        return $this->belongsTo(User::class, 'farmaceutico_id');
    }

    public function medicamentos()
    {
        return $this->belongsToMany('App\Models\Medicamento')->using('App\Models\Medicamento_Receita')->withPivot('qtd', 'preco_un');;
    }
}
