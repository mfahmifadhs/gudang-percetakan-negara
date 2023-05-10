<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouseStorageModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_penyimpanan_model";
    protected $primaryKey = "id_model";
    public $timestamps = false;

    protected $fillable = [
        'id_model',
        'nama_model',
        'keterangan'
    ];
}
