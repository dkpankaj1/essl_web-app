<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        "uid",
        "employee_id",
        "timestamp",
        "type",
    ];
    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
