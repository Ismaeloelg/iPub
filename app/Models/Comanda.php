<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Comanda extends Model
{
    protected $fillable = [
        'mesa_id',
        'stock_id',
        'cantidad',
        'precio',
        'user_id',
        'notas'
    ];

    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class);
    }

    public function stock(): BelongsTo
    {
        return $this->BelongsTo(Stock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
