<?php

namespace App\Http\Controllers;

use App\Models\Episodio;
use App\Models\Temporada;
use Doctrine\DBAL\Driver\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EpisodiosController extends Controller
{
    public function watch(Temporada $temporada, Request $request)
    {
        $episodiosAssistidos = explode(',',$request->assistidoId);

        $temporada->episodios->each(function (Episodio $episodio)
        use ($episodiosAssistidos)
        {
            $episodio->assistido = in_array(
                $episodio->id,
                $episodiosAssistidos
            );
        });

        $temporada->push();

    }

    public function adicionar(Request $request)
    {
        $idTemp = $request->idTemp;
        $ep = $request->ep;
        $link = $request->link;

        $temporada = Temporada::find($idTemp);
        DB::beginTransaction();
        $temporada->episodios()->create([
            'numero' => $ep,
            'link' => $link
        ]);
        DB::commit();
        $request->session()->flash('mensagem', "Episodio adicionado com sucesso.");

        return true;
    }


    public function destroy(Request $request)
    {
         $id = $request->id;

         Episodio::destroy($id);
        $request->session()->flash('mensagem', "Episodio removido com sucesso.");

    }
}
