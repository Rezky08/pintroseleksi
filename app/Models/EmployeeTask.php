<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTask extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'employee_task';
    public function employee()
    {
        return $this->belongsToMany(Employee::class, 'employee_task', 'employee_id', 'id');
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'employee_task', 'task_id', 'id');
    }
}
