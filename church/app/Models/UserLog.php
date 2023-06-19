<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table='tbluser_logins';
    protected $fillable = [
        'user_id',
        'login_time',
        'logout_time',
        'is_proper_logout',
        'machine_name',
        'machine_ip',
    ];
}
