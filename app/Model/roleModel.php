<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class roleModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_role";
    protected $primaryKey = "id_role";
    public $timestamps = false;

    protected $fillable = [
        'id_role',
        'nama_role'
    ];
}
