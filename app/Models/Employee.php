<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        "uid",
        "userid",
        "name",
        "role",
        "password",
        "cardno",
    ];
    public function AttendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
