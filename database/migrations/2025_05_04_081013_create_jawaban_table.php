<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')
                  ->constrained('tugas')
                  ->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->text('jawaban_text');
            $table->decimal('nilai', 5, 2)
                  ->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban');
    }
};