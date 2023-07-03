<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemOutgoing extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_barang_keluar";
    protected $primaryKey = "id_keluar";
    public $timestamps = false;

    protected $fillable = [
        'id_keluar',
        'pengajuan_id',
        'penyimpanan_id',
        'jumlah_pengajuan',
        'jumlah_keluar',
        'status_keluar'
    ];

    public function palet() {
        return $this->belongsTo(storageDetailModel::class, 'penyimpanan_id');
    }
}
