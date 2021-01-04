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
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'employee_task', 'employee_id', 'id');
    }
    public function getEmployeeFullnameAttribute()
    {
        return "{$this->employee_first_name} {$this->employee_last_name}";
    }
    public function getGenderAttribute()
    {
        if ($this->employee_gender == "M") {
            return "Male";
        }
        if ($this->employee_gender == "F") {
            return "Female";
        }
    }
}
