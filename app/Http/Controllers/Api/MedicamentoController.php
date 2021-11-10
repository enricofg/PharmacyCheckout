<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Medicamento as MedicamentoResource;
use App\Models\Medicamento;

class MedicamentoController extends Controller
{
    public function index(Request $request)
    {
        $medicamentos = DB::table('medicamentos')->take(30)->get();

        return $medicamentos;
    }

    public function search(Request $request)
    {
        $medicamentos = MedicamentoResource::collection(Medicamento::all());
        $isGenerico = $request->isGenerico;
        $searchTerm = strtolower($request->searchTerm);

        if($searchTerm==null){
            return $this->index($request);
        }

        $pesquisa = $medicamentos->filter(function ($item) use ($searchTerm, $isGenerico) {
            if($isGenerico!=null){
                return strpos(strtolower($item->nome), $searchTerm) && $item->generico == $isGenerico;
            }
            return strpos(strtolower($item->nome), $searchTerm);

        })->values();

        return $pesquisa;
    }
}
