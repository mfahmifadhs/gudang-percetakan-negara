<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class storageModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_penyimpanan";
    protected $primaryKey = "id_penyimpanan";
    public $timestamps = false;

    protected $fillable = [
        'id_penyimpanan',
        'gedung_id',
        'model_id',
        'kode_palet',
        'keterangan',
        'status_kapasitas_id'
    ];

    public function gedung() {
        return $this->belongsTo(warehouseModel::class, 'gedung_id');
    }

    public function model() {
        return $this->belongsTo(warehouseStorageModel::class, 'model_id');
    }

    public function kapasitas() {
        return $this->belongsTo(statusCapacity::class, 'status_kapasitas_id');
    }
}
