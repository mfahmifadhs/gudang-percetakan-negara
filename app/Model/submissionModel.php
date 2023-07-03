<?php

namespace App\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class submissionModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_pengajuan";
    protected $primaryKey = "id_pengajuan";
    public $timestamps = false;

    protected $fillable = [
        'id_pengajuan',
        'user_id',
        'pegawai_id',
        'unit_kerja_id',
        'jenis_pengajuan',
        'tanggal_pengajuan',
        'keterangan_proses',
        'keterangan_ketidaksesuaian',
        'surat_pengajuan',
        'surat_perintah',
        'keterangan',
        'batas_waktu',
        'status_pengajuan_id',
        'status_proses_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pegawai() {
        return $this->belongsTo(employeeModel::class, 'pegawai_id');
    }

    public function unitkerja() {
        return $this->belongsTo(workunitModel::class, 'unit_kerja_id');
    }

    public function penyimpanan() {
        return $this->hasMany(submissionDetailModel::class, 'pengajuan_id');
    }

    public function pengambilan() {
        return $this->hasMany(ItemOutgoing::class, 'pengajuan_id');
    }

    public function petugas() {
        return $this->hasMany(SubmissionStaff::class, 'pengajuan_id');
    }

    public function riwayat() {
        return $this->hasMany(StorageHistory::class, 'pengajuan_id');
    }
}
