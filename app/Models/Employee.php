<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function employee_task()
    {
        return $this->hasMany(EmployeeTask::class, 'employee_id', 'id');
    }
}
