<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        "company_name",
        "machine_ip",
        "serial_no",
        "start_time",
        "punch_start_before",
        "end_time",
        "punch_end_after",
        "last_log",
    ];
}
