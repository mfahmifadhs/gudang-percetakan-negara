<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mainunitModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_unit_utama";
    protected $primaryKey = "id_unit_utama";
    public $timestamps = false;

    protected $fillable = [
        'id_unit_utama',
        'kode_unit_utama',
        'nama_unit_utama'
    ];
}
