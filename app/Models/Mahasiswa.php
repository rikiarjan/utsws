<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $fillable = [
        'nim',
        'nama_mahasiswa',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->formatLocalized('%d %B %Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->formatLocalized('%d %B %Y');
    }
}
