<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';        // tên bảng
    protected $primaryKey = 'id_Ad';   // khóa chính
    public $timestamps = false;        // nếu bảng không có created_at/updated_at
    protected $fillable = ['UserName', 'PassWord', 'role_id'];
    protected $hidden = ['PassWord'];

    public function getAuthPassword()
    {
        return $this->PassWord; 
    }
}