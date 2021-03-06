<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\never;

class TaskController extends Controller
{
    private $scope;
    private $task_model;
    private $user_model;
    function __construct()
    {
        $this->scope = "Employee";
        $this->task_model = new Task();
        $this->user_model = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;
        $tasks = $employee->tasks();

        if ($request->task_name || $request->filter_apply) {
            $tasks = $this->data_filter($request, $tasks);
        }

        $tasks = $tasks->paginate()->appends($request->all());
        $page_name = "Task Data";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'tasks' => $tasks,
            'page_name' => $page_name,
            'max_paginate' => 10,
            'num_item' => $tasks->firstItem()
        ];
        return view('employee.task.task_list', $data);
    }

    function data_filter(Request $request, $task_model)
    {
        $tasks = $task_model;
        // search name
        if ($request->task_name) {
            $tasks = $tasks->where("task_name", 'like', "%" . $request->task_name . "%");
            return $tasks;
        }
        // search name
        if ($request->has('task_status')) {
            $tasks = $tasks->where("is_completed", $request->task_status);
            return $tasks;
        }
        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = "Task Create";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "POST",
        ];
        return view('admin.task.task_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'task_name' => ['required', 'filled'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $task_data = [
                'task_name' => $request->task_name,
                'task_desc' => $request->task_desc,
                'created_at' => new \DateTime
            ];
            $this->task_model->insert($task_data);
            $response = [
                'success' => "Task has been created"
            ];
            return redirect('admin/task')->with($response);
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
    public function edit($id)
    {
        $task = $this->task_model->find($id);
        $page_name = "Task Edit";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "PUT",
            'task' => $task
        ];
        return view('admin.task.task_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $employee = $user->employee;
        $rules = [
            'task_status' => ['required', 'filled', 'boolean'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $task = $employee->tasks->where('pivot.id', $id)->first()->pivot;
            $task->is_completed = $request->task_status;
            $task->save();

            $response = [
                'success' => "Task has been Updated"
            ];
            return redirect('task')->with($response);
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
    public function destroy($id)
    {
        $task = $this->task_model->find($id);
        try {
            $task->delete();
            $response = [
                'success' => "Task has been Deleted"
            ];
            return redirect('admin/task')->with($response);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'error' => "Server Error 500"
            ];
            return redirect()->back()->with($response)->withInput();
        }
    }
}
