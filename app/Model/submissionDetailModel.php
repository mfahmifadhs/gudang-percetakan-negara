<?php

namespace App\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class submissionDetailModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_pengajuan_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'id_detail',
        'pengajuan_id',
        'jenis_barang_id',
        'nama_barang',
        'deskripsi',
        'kondisi_barang',
        'tahun_perolehan',
        'keterangan',
        'jumlah_pengajuan',
        'jumlah_disetujui',
        'jumlah_diterima',
        'satuan',
        'keterangan_kesesuaian',
        'status'
    ];

    public function pengajuan() {
        return $this->belongsTo(submissionModel::class, 'pengajuan_id');
    }

    public function slot() {
        return $this->hasMany(storageDetailModel::class, 'pengajuan_detail_id')
            ->join('t_penyimpanan','id_penyimpanan','penyimpanan_id')
            ->join('t_gedung','id_gedung','gedung_id');
    }
}
