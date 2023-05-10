<?php

namespace App\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bast extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_berita_acara";
    protected $primaryKey = "id_berita_acara";
    public $timestamps = false;

    protected $fillable = [
        'id_berita_acara',
        'pengajuan_id',
        'nomor_surat'
    ];

    public function pengajuan() {
        return $this->belongsTo(submissionModel::class, 'pengajuan_id');
    }
}
