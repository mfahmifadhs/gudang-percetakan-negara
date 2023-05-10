<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class statusCapacity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_status_kapasitas";
    protected $primaryKey = "id_kapasitas";
    public $timestamps = false;

    protected $fillable = [
        'id_kapasitas',
        'nama_kapasitas'
    ];
}
