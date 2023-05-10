<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorageHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_penyimpanan_riwayat";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'id_riwayat',
        'pengajuan_id',
        'penyimpanan_detail_id',
        'jumlah',
    ];

    public function pengajuan() {
        return $this->belongsTo(submissionModel::class, 'pengajuan_id');
    }

    public function penyimpanan() {
        return $this->belongsTo(storageModel::class, 'penyimpanan_id');
    }

    public function detailPenyimpanan() {
        return $this->belongsTo(storageDetailModel::class, 'penyimpanan_detail_id');
    }
}
