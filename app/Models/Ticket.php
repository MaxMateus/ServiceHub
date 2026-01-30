<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'attachment_path',
    ];

    // N:1 – Ticket pertence a um Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 1:1 – Ticket tem um TicketDetail
    public function detail()
    {
        return $this->hasOne(TicketDetail::class);
    }

    // N:1 – Ticket criado por um User
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // N:1 – Ticket atribuído a um User (responsável)
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
