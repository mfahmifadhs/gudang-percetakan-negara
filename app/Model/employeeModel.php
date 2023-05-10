<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class employeeModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_pegawai";
    protected $primaryKey = "id_pegawai";
    public $timestamps = false;

    protected $fillable = [
        'id_pegawai',
        'unit_kerja_id',
        'nip',
        'nama_pegawai',
        'jabatan',
        'status_id'
    ];

    public function status() {
        return $this->belongsTo(statusModel::class, 'status_id');
    }

    public function workunit() {
        return $this->belongsTo(workunitModel::class, 'unit_kerja_id');
    }
}
