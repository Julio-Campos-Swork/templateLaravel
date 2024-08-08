<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginRegister extends Model
{
    use HasFactory;

    protected $table = 'login_register';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'key',
        'ip',
        'country',
        'city',
    ];
}
