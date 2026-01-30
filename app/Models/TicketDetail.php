<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'details',
        'processed_at',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
