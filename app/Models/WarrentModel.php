<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrentModel extends Model
{
    use HasFactory;
    protected $table = "tbl_warrents";
    protected $primary_key = "id_warrent";
    public $timestamps = false;

    protected $fillable = [
        'warr_num',
        'workunit_id',
        'warr_name',
        'warr_position',
        'warr_category',
        'warr_status',
        'warr_dt',
        'warr_tm'
    ];
}
