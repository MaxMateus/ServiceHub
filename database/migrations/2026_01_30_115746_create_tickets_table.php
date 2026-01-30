<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // N:1 – Ticket pertence a um Project
            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();

            // N:1 – Ticket criado por um User
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // N:1 – Ticket atribuído a um User (opcional)
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description');

            // caminho do arquivo anexado (JSON/TXT)
            $table->string('attachment_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
