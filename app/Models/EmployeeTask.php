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
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
