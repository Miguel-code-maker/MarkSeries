<?php

namespace App\Services;


use App\Models\Episodio;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;

class TableWithTemp
{
    public function create(string $nome, int $temp, int $eps, $link, $table)
    {
        DB::beginTransaction();
        $column = $table->create([
            'nome' => $nome
        ]);
        $zero = 0;

        if(!empty($link)) {
            $link1 = str_replace('$*', $zero."*", $link);
            if($link1 == $link) {
                $semTemp = true;
            } else {
                $semTemp = false;
            }
            $link = $link1;
            $link = str_replace('$^', $zero."^", $link);
        } else {
            $semTemp = false;
        }

        for($i = 1; $i <= $temp; $i++) {
            $iT = $i-1;
            $temporada = $column->temporadas()->create(['numero' => $i]);
            if (!empty($link) && !$semTemp) $link = str_replace($iT."*", $i."*", $link);
            $this->addEps($temporada, $eps, $i, $link, $semTemp);

        }
        DB::commit();

        return $column;
    }

    protected function addEps($temporada, $eps, $iTemp, &$link, $semTemp) {
        $zero = 0;
        for($ie = 1; $ie <= $eps; $ie++) {
            if (!empty($link)) {
                if(!$semTemp || $iTemp == 1) {
                    $link = str_replace($eps.'^', $zero."^", $link);
                    $ieE = $ie-1;
                    $link = str_replace($ieE."^", $ie."^", $link);
                } else {
                    $ieE = $ie - 1;
                    $link = str_replace(($ieE+(($eps)*($iTemp-1)))."^", ($ie+(($eps)*($iTemp-1)))."^", $link);
                }

                $temporada->episodios()->create(['numero' => $ie, 'link' => $link]);
            } else {
                $temporada->episodios()->create(['numero' => $ie]);
            }
        }
    }

    public function delete($table, $id)
    {
        DB::beginTransaction();
        $table->temporadas->each(function (Temporada $temporada) {
            $temporada->episodios->each(function(Episodio $episodio) {
                $episodio->delete();
            });
            $temporada->delete();
        });
        $table::destroy($id);
        DB::commit();

    }

    public function addEpsOnlyTemp($serie, $eps, $link, $temp, $ep, $comTemp) {
        DB::beginTransaction();
        $temporada = $serie->temporadas()->create([
            'numero' => $temp
        ]);

        for ($i=1; $i<=$eps; $i++) {
            if ($comTemp) {
                $link = str_replace($ep.'^', $i.'^', $link);
                $link = str_replace(($i-1)."^", $i."^", $link);
            } else {
                $link = str_replace($ep."^", ($i+$ep)."^", $link);
                $link = str_replace((($ep+$i)-1)."^", ($ep+$i)."^", $link);
            }

            $temporada->episodios()->create([
                'numero' => $i,
                'link' => $link
            ]);
        }
        DB::commit();

        return $serie;
    }
}
