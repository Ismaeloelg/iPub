<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMesa extends Model
{
    use HasFactory;

    protected $table = 'ticket_mesas';
    protected $fillable = [
        'mesa_id',
        'numero_ticket',
        'total',
        'cerrado_en'
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }



    public function comandas()
    {
        return $this->mesa->comandas();
    }
}
