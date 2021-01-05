<?php

namespace App\Models;

use App\Traits\TableColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes, TableColumn;
    protected $fillable = ['*'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'employee_task', 'employee_id', 'task_id')->withPivot(['id', 'is_completed']);
    }
    public function tasksCompleted()
    {
        return $this->belongsToMany(Task::class, 'employee_task', 'employee_id', 'task_id')->where('is_completed', true)->withPivot('id');
    }
    public function tasksIncompleted()
    {
        return $this->belongsToMany(Task::class, 'employee_task', 'employee_id', 'task_id')->where('is_completed', false)->withPivot('id');
    }
    public function getEmployeeFullnameAttribute()
    {
        return "{$this->employee_first_name} {$this->employee_last_name}";
    }
    public function getGenderDetailAttribute()
    {
        if ($this->employee_gender == "M") {
            return "Male";
        }
        if ($this->employee_gender == "F") {
            return "Female";
        }
    }
}
