<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer('nim');
            $table->string('nama_mahasiswa');
            $table->timestamps();
        });

        // Memasukkan data ke dalam tabel province
        DB::table('mahasiswas')->insert([
            ['nim' => '2101040003', 'nama_mahasiswa' => 'M Thoriq Panca Mukti', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2101040008', 'nama_mahasiswa' => 'Muhammad Haikal Rabbani', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
