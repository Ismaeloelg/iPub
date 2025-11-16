<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoComandas extends Model
{
    protected $fillable = [
        'mesa_id',
        'stock_id',
        'cantidad',
        'precio',
        'notas'
    ];
}
