<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Temporada;
use App\Models\User;
use App\Services\TableWithTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemporadasController extends Controller
{
    public function index(Int $serieId)
    {
        $user = User::query()->where('id', Auth::id())->first();

        $serie = $user->series()->find($serieId);
        $temporadas = $serie->temporadas;
        $link = [];

        foreach ($temporadas as $temporada) {
            $link[] = $temporada->hasLinkEps();
        }

        $linkReverse = array_reverse($link);
        $ultmoLinkReverse = array_reverse($link[0]);

        return view('series.temporadas.index', compact('temporadas', 'serie', 'link'));
    }

    public function addTemp(Request $request, TableWithTemp $tablewithTemp)
    {
        $epsPorTemp = $request->epsPorTemp;
        $primeiroEp = $request->ep;
        $temp = $request->temp;
        $link = $request->link;
        $idSerie = $request->idSerie;

        $serie = Serie::find($idSerie);
        if (mb_strpos($link, $temp."*") !== false) {
            $tablewithTemp->addEpsOnlyTemp($serie ,$epsPorTemp, $link, $temp, $primeiroEp, true);
        } else {
            $tablewithTemp->addEpsOnlyTemp($serie, $epsPorTemp, $link, $temp, $primeiroEp, false);
        }
        return redirect()->back();
    }

    public function removerTemp(Request $request)
    {
        $id = $request->idTemp;

        Temporada::destroy($id);

        return redirect()->back();
    }
}
