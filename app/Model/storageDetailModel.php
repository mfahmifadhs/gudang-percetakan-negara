<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class storageDetailModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_penyimpanan_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'id_detail',
        'penyimpanan_id',
        'pengajuan_detail_id',
        'total_masuk',
        'total_keluar',
        'keterangan'
    ];

    public function penyimpanan() {
        return $this->belongsTo(storageModel::class, 'penyimpanan_id');
    }

    public function barang() {
        return $this->belongsTo(submissionDetailModel::class, 'pengajuan_detail_id');
    }

    public function history() {
        return $this->hasMany(StorageHistory::class, 'penyimpanan_detail_id');
    }

    public function keluar() {
        return $this->hasMany(ItemOutgoing::class, 'penyimpanan_id');
    }
}
