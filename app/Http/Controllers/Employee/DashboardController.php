<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $scope;
    function __construct()
    {
        $this->scope = "Employee";
    }
    public function index()
    {
        $user = Auth::user();
        $employees = $user->employee;
        $tasks = $employees->tasks;
        $completed_count = $tasks->where('pivot.is_completed', true)->count();
        $incompleted_count = $tasks->where('pivot.is_completed', false)->count();
        $tasks_count = $tasks->count();
        $data = [
            'task_count' => $tasks_count,
            'completed_count' => $completed_count,
            'incompleted_count' => $incompleted_count,
            'title' => 'Dashboard | ' . $this->scope,
            'page_name' => "Dashboard"
        ];
        return view('employee.dashboard.dashboard', $data);
    }
}
