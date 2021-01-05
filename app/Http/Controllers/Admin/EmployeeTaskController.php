<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\never;

class EmployeeTaskController extends Controller
{
    private $scope;
    private $employee_model;
    private $task_model;
    private $user_model;
    function __construct()
    {
        $this->scope = "Admin";
        $this->employee_model = new Employee();
        $this->task_model = new Task();
        $this->user_model = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $employee = $this->employee_model->find($id);
        $tasks = [];
        if ($employee->tasks) {
            $tasks = $employee->tasks();
        }
        if ($tasks) {
            if ($request->task_name) {
                $tasks = $this->data_filter($request, $tasks);
            }
            $tasks = $tasks->paginate()->appends($request->all());
        }

        $page_name = ucwords($employee->employee_fullname) . " Task Data";
        $data = [
            'employee' => $employee,
            'title' =>  $page_name . " |" . $this->scope,
            'tasks' => $tasks,
            'page_name' => $page_name,
            'max_paginate' => 10,
            'num_item' => $tasks ? $tasks->firstItem() : 0
        ];
        return view('admin.employee.task.task_list', $data);
    }

    function data_filter(Request $request, $task_model)
    {
        $tasks = $task_model;
        // search name
        if ($request->task_name) {
            $tasks = $tasks->where("task_name", 'like', "%" . $request->task_name . "%");
            return $tasks;
        }
        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($employee_id)
    {
        $employee = $this->employee_model->find($employee_id);
        $tasks = $this->task_model->all();
        $page_name = ucfirst($employee->employee_fullname) . " Task Create";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "POST",
            'tasks' => $tasks
        ];
        return view('admin.employee.task.task_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $employee_id)
    {
        $rules = [
            'task_id' => ['required', 'filled', 'exists:tasks,id,deleted_at,NULL'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $employee =  $this->employee_model->find($employee_id);
            $task = $this->task_model->find($request->task_id);
            $employee->tasks()->save($task);
            $response = [
                'success' => "Task has been added"
            ];
            return redirect('admin/employee/' . $employee_id . '/task')->with($response);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'error' => "Server Error 500"
            ];
            return redirect()->back()->with($response)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->task_model->find($id);
        $page_name = "Task Detail";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "",
            'task' => $task
        ];
        return view('admin.task.task_form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($employee_id, $id)
    {
        $employee = $this->employee_model->find($employee_id);
        $task = $employee->tasks()->where('employee_task.id', $id)->first();
        if (!$task) {
            $response = [
                'error' => 'Task Not Found'
            ];
            return redirect('/admin/employee/' . $employee_id)->with($response);
        }
        $tasks = $this->task_model->all();
        $page_name = $employee->employee_fullname . " Task Edit";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "PUT",
            'task' => $task,
            'tasks' => $tasks
        ];
        return view('admin.employee.task.task_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee_id, $id)
    {

        $rules = [
            'task_id' => ['required', 'filled', 'exists:tasks,id,deleted_at,NULL'],
            'employee_task_id' => ['required', 'filled', 'exists:employee_task,id,employee_id,' . $employee_id . ',deleted_at,NULL']
        ];
        $validator = Validator::make($request->all() + [
            'employee_task_id' => $id
        ], $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $employee = $this->employee_model->find($employee_id);
            $task = $employee->tasks()->where('employee_task.id', $id)->first()->pivot;
            $task->task_id = $request->task_id;
            $task->save();

            $response = [
                'success' => "Task has been Updated"
            ];
            return redirect('admin/employee/' . $employee_id . '/task')->with($response);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'error' => "Server Error 500"
            ];
            return redirect()->back()->with($response)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee_id, $id)
    {
        $employee = $this->employee_model->find($employee_id);
        $task = $employee->tasks()->find($id);;

        try {
            $task->pivot->delete();
            $response = [
                'success' => "Task has been Deleted"
            ];
            return redirect('admin/employee/' . $employee_id . '/task')->with($response);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'error' => "Server Error 500"
            ];
            return redirect()->back()->with($response)->withInput();
        }
    }
}
