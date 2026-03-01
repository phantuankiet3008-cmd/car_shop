<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'khach_hang'; 

    protected $primaryKey = 'id_Khach_Hang';

    public $timestamps = false; 

    protected $fillable = [
        'Ho_Ten',
        'Email',
        'So_Dien_Thoai',
        'Mat_Khau',
        'Dia_Chi',
        'Trang_Thai'
    ];

    protected $hidden = [
        'Mat_Khau'
    ];

    
    public function getAuthPassword()
    {
        return $this->Mat_Khau;
    }
}