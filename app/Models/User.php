<?php

namespace App\Models;

use App\Model\employeeModel;
use App\Model\roleModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table      = "users";
    protected $primaryKey = "id";
    public $timestamps    = false;

    protected $fillable = [
        'role_id',
        'pegawai_id',
        'nip',
        'password',
        'password_text',
        'status_id'
    ];

    public function pegawai() {
        return $this->belongsTo(employeeModel::class, 'pegawai_id');
    }

    public function role() {
        return $this->belongsTo(roleModel::class, 'role_id');
    }

}
