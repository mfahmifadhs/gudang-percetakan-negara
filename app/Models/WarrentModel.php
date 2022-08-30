<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WarrentItemModel;

class WarrentModel extends Model
{
    use HasFactory;
    protected $table        = "tbl_warrents";
    protected $primaryKey   = "id_warrent";
    public $timestamps = false;

    protected $fillable = [
        'id_warrent',
        'warr_num',
        'workunit_id',
        'warr_name',
        'warr_position',
        'warr_category',
        'warr_status',
        'warr_total_item',
        'warr_dt',
        'warr_tm'
    ];

    public function entryitem() {
        return $this->hasMany(WarrentItemModel::class, 'warrent_entry_id');
    }
}
