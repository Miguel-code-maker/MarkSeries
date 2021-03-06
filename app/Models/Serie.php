<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['nome'];

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function epsPorTemp()
    {
        $number = 0;
        foreach ($this->temporadas as $temporada) {
            $number += $temporada->episodios()->count();
        }

        return $number;
    }
}
