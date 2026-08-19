<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbPendaftaran extends Model
{
    use HasFactory;
    protected $table = 'ppdb_pendaftarans';
    protected $guarded = ['id'];
}
