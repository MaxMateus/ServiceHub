<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];

    // N:1 – Project pertence a uma Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // 1:N – Project tem muitos Tickets (vamos criar depois)
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
