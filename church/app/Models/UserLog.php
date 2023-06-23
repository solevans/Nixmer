<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table='tbluser_logins';
    protected $primaryKey = 'logid';
    
    protected $dates=[
        'login_time',
        'logout_time'
    ];

    protected $fillable = [
        'user_id',
        'login_time',
        'logout_time',
        'is_proper_logout',
        'machine_name',
        'machine_ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }
}
