<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Serie;
use App\Models\User;
use App\Services\TableWithTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesController extends Controller
{

    public function index(Request $request) {
        $user = User::find(Auth::user()->id);

        $series = $user->series()->orderBy('nome')->get();

        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, TableWithTemp $tableWithTemp)
    {
        $user = User::find(Auth::user()->id);
        $name = $request->nome;
        $temp = filter_var($request->temporadas, FILTER_SANITIZE_NUMBER_INT);
        $eps = filter_var($request->episodios, FILTER_SANITIZE_NUMBER_INT);
        $animesHouse = $request->animeshouse;
        $pobreFlix = $request->pobreflix;
        $link = $request->link;

        if (!empty($animesHouse)) {
            $nameUrl = trim($name);
            $nameUrl = str_replace(' ', '-', $nameUrl);
            $nameUrl = strtolower($nameUrl);
            $nameUrl = ucfirst($nameUrl);
            $link = "https://animeshouse.net/episodio/$nameUrl-episodio-$^/";
        } else if (!empty($pobreFlix)) {
            $nameUrl = strtolower(trim($name));
            $nameUrl = str_replace(' ', '-', $nameUrl);
            $link = "https://pobreflix.com/episodios/assistir-$nameUrl-$*x$^-online-hd-dublado/";
        }
        $serie = $tableWithTemp->create($name, $temp, $eps, $link, $user->series());

        $request->session()->flash('mensagem', "$name adicionada com sucesso.");

        return redirect()->route('series');
    }

    public function destroy(Request $request, TableWithTemp $tableWithTemp)
    {

        $user = User::find(Auth::user()->id);

        $id = filter_var($request->id, FILTER_SANITIZE_NUMBER_INT);
        /** @var Serie $serie */

        $serie = $user->getSeriesForId($id);

        //$tableWithTemp->delete(Serie::class, $id);

        foreach ($serie as $serieId) {
            $serie = $serieId;
        }

        Serie::destroy($id);

        $request->session()->flash('mensagem', "{$serie->nome} foi deletada com sucesso.");

        return redirect()->route('series');

    }

    public function updateName(Request $request, int $serieId)
    {
        $user = User::find(Auth::user()->id);
        $newName = $request->nome;

        $serie = $user->series->find($serieId);

        $serie->nome = $newName;
        $serie->save();

    }


}
