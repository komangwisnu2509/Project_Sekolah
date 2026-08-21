<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'nip',
        'nama',
        'mata_pelajaran',
        'status',
        'tahun_purna',
        'pesan_purna',
        'no_hp',
        'foto',
        'user_id',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function piket()
    {
        return $this->hasMany(PiketGuru::class, 'guru_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'guru_id');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalPelajaran::class, 'guru_id');
    }

    public function izin()
    {
        return $this->hasMany(IzinGuru::class, 'guru_id');
    }
}
