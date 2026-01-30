<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
    ];

    // 1:N - Company has many Projects (vamos criar Project depois)
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
