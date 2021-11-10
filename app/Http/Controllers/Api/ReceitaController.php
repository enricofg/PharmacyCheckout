<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Receita as ReceitaResource;
use App\Models\Receita;

class ReceitaController extends Controller
{
    public function minhasReceitas(Request $request)
    {
        $id = Auth::user()->id;
        $receitas = ReceitaResource::collection(Receita::all());

        return $receitas->filter(function ($item) use ($id) {
            return $item->cliente_id == $id;
        })->sortByDesc('id')->sortByDesc('data')->values()->take(10);
    }

    public function store(Request $request)
    {
        $id = Auth::user()->id;

        $receita = new Receita();
        $receita->data=date("Y-m-d");
        $receita->estado_receita="A";
        $receita->cliente_id=$id;
        $receita->farmaceutico_id=null;
        $receita->total=$request->price;
        $receita->save();

        foreach ($request->order as $item) {
            $receita->medicamentos()->attach($item['item']['id'], ['receita_id' => $receita->id, 'qtd' => $item['quantity'], 'preco_un' => $item['item']['preco']]);
        }

        return response()->json(new ReceitaResource($receita), 201);
    }

    public function receitasAbertas(Request $request)
    {
        $receitas = ReceitaResource::collection(Receita::all());

        return $receitas->filter(function ($item) {
            return $item->estado_receita=="A";
        })->sortByDesc('id')->sortByDesc('data')->values()->take(10);
    }

    public function fecharReceita(Request $request)
    {
        $id = Auth::user()->id;

        $receita = Receita::find($request->id);
        $receita->estado_receita="F";
        $receita->farmaceutico_id=$id;
        $receita->save();

        return $this->receitasAbertas($request);
    }

    public function rejeitarReceita(Request $request)
    {
        $id = Auth::user()->id;

        $receita = Receita::find($request->id);
        $receita->estado_receita="R";
        $receita->farmaceutico_id=$id;
        $receita->save();

        return $this->receitasAbertas($request);
    }

    public function receitasFechadasPorMim(Request $request)
    {
        $id = Auth::user()->id;
        $receitas = ReceitaResource::collection(Receita::all());

        return $receitas->filter(function ($item) use ($id) {
            return $item->estado_receita=="F" && $item->farmaceutico_id==$id;
        })->sortByDesc('id')->sortByDesc('data')->values()->take(10);
    }

    public function receitasRecusadasPorMim(Request $request)
    {
        $id = Auth::user()->id;
        $receitas = ReceitaResource::collection(Receita::all());

        return $receitas->filter(function ($item) use ($id) {
            return $item->estado_receita=="R" && $item->farmaceutico_id==$id;
        })->sortByDesc('id')->sortByDesc('data')->values()->take(10);
    }
}
