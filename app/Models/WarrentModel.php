<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WarrentEntryModel;

class WarrentModel extends Model
{
    protected $table        = 'tbl_warrents';
    protected $primaryKey   = 'id_warrent';
    public $timestamps      = false;

    protected $fillable = [
        'id_warrent',
        'appletter_id',
        'warr_file',
        'workunit_id',
        'warr_emp_name',
        'warr_emp_position',
        'warr_purpose',
        'warr_total_item',
        'warr_date',
        'warr_status'
    ];

    public function entryitem() {
        return $this->hasMany(WarrentEntryModel::class, 'warrent_id');
    }

    public function exititem() {
        return $this->hasMany('App\Models\WarrentExit');
    }
}
