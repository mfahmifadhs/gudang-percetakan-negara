<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouseModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_gedung";
    protected $primaryKey = "id_gedung";
    public $timestamps = false;

    protected $fillable = [
        'id_gedung',
        'kode_gedung',
        'kategori_id',
        'nama_gedung',
        'keterangan',
        'status_id'
    ];

    public function status() {
        return $this->belongsTo(statusModel::class, 'status_id');
    }

    public function kategori() {
        return $this->belongsTo(warehouseCategoryModel::class, 'kategori_id');
    }

    public function penyimpanan() {
        return $this->hasMany(storageModel::class, 'gedung_id');
    }
}
