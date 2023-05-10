<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouseCategoryModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_gedung_kategori";
    protected $primaryKey = "id_kategori";
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_kategori',
        'keterangan'
    ];
}
