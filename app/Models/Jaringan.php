<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Jaringan extends Model
{
    use HasFactory;

    protected $table = 'jaringan'; // Nama tabel
    protected $fillable = [
        'nama_jaringan',
        'allowedRangeStart',
        'allowedRangeEnd',
    ];
}
