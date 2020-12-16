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
    public function index(Int $serieId, Request $request)
    {
        $user = User::query()->where('id', Auth::id())->first();

        $serie = $user->series()->find($serieId);
        $temporadas = $serie->temporadas;
        $link = [];
        $linkModelo = [];

        foreach ($temporadas as $temporada) {
            $link[] = $temporada->hasLinkEps();
            $linkModelo[] = $temporada->linkModel();
        }

        $mensagem = $request->session()->get('mensagem');

        return view('series.temporadas.index', compact('temporadas', 'serie', 'link', 'mensagem', 'linkModelo'));
    }

    public function addTemp(Request $request, TableWithTemp $tablewithTemp)
    {
        $epsPorTemp = $request->epsPorTemp;
        $primeiroEp = $request->ep;
        $temp = $request->temp;
        $link = $request->link;
        $idSerie = $request->idSerie;
        $uniEp = $request->uniEp;

        $serie = Serie::find($idSerie);
        if (mb_strpos($link, $temp."*") !== false) {
            $tablewithTemp->addEpsOnlyTemp($serie ,$epsPorTemp, $link, $temp, $primeiroEp, true);
        } else {
            $link = str_replace($primeiroEp.'^',$uniEp.'^',$link);
            $tablewithTemp->addEpsOnlyTemp($serie, $epsPorTemp, $link, $temp, $uniEp, false);
        }
        $request->session()->flash('mensagem', "Temporada adicionada com sucesso.");

        return redirect()->back();
    }

    public function removerTemp(Request $request)
    {
        $id = $request->idTemp;

        Temporada::destroy($id);

        $request->session()->flash('mensagem', "Temporada removida com susesso.");

        return redirect()->back();
    }
}
