<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;

    protected $table = 'error_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'error_message',
        'id_user'];
    public $timestamps = true;


}