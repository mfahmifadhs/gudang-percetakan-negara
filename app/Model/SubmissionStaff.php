<?php

namespace App\Model;

use App\Model\submissionModel as ModelSubmissionModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmissionStaff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_pengajuan_petugas";
    protected $primaryKey = "id_kedatangan";
    public $timestamps = false;

    protected $fillable = [
        'id_kedatangan',
        'pengajuan_id',
        'nama_petugas',
        'jabatan',
        'nomor_mobil',
        'created_at'
    ];

    public function pengajuan() {
        return $this->belongsTo(SubmissionModel::class, 'pengajuan_id');
    }
}
