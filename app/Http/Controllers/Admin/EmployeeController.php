<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\never;

class EmployeeController extends Controller
{
    private $scope;
    private $employee_model;
    private $user_model;
    function __construct()
    {
        $this->scope = "Admin";
        $this->employee_model = new Employee();
        $this->user_model = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filter_apply || $request->employee_name) {
            $employees = $this->data_filter($request);
        } else {
            $employees = $this->employee_model;
        }
        $employees = $employees->paginate()->appends($request->all());
        $page_name = "Employee Data";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'employees' => $employees,
            'page_name' => $page_name,
            'max_paginate' => 10,
            'num_item' => $employees->firstItem()
        ];
        return view('admin.employee.employee_list', $data);
    }

    function data_filter(Request $request)
    {
        // filter gender
        $employees = $this->employee_model;
        if ($request->employee_gender) {
            $employees = $employees->where('employee_gender', $request->employee_gender);
        }
        // filter dob
        if ($request->employee_dob_from && $request->employee_dob_to) {
            $from = date('Y-m-d', strtotime($request->employee_dob_from));
            $to = date('Y-m-d', strtotime($request->employee_dob_to));
            $employees = $employees->whereBetween('employee_dob', [$from, $to]);
        }
        // filter hiredate
        if ($request->employee_hire_date_from && $request->employee_hire_date_to) {
            $from = date('Y-m-d', strtotime($request->employee_hire_date_from));
            $to = date('Y-m-d', strtotime($request->employee_hire_date_to));
            $employees = $employees->whereBetween('employee_hire_date', [$from, $to]);
        }
        // search name
        if ($request->employee_name) {
            $employees = $employees->where("employee_first_name", 'like', "%" . $request->employee_name . "%")->orWhere("employee_last_name", 'like', "%" . $request->employee_name . "%");
            return $employees;
        }
        return $employees;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = "Employee Create";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "POST",
        ];
        return view('admin.employee.employee_form', $data);
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
            'username' => ['required', 'filled', 'unique:users,username,NULL,id,deleted_at,NULL'],
            'email' => ['required', 'filled', 'email', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'password' => ['required', 'filled', 'confirmed', 'min:6', 'max:12'],
            'employee_first_name' => ['required', 'filled'],
            'employee_last_name' => ['required', 'filled'],
            'employee_gender' => ['required', 'filled', 'in:M,F'],
            'employee_dob' => ['required', 'filled', 'date'],
            'employee_hire_date' => ['required', 'filled', 'date'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $user_data = [
                'name' => $request->employee_first_name . " " . $request->employee_last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2, // for employee
                'created_at' => new \DateTime

            ];
            $user_id = $this->user_model->insertGetId($user_data);

            $employee_data = [
                'user_id' => $user_id,
                'employee_first_name' => $request->employee_first_name,
                'employee_last_name' => $request->employee_last_name,
                'employee_gender' => $request->employee_gender,
                'employee_dob' => date("Y-m-d", strtotime($request->employee_dob)),
                'employee_hire_date' => date("Y-m-d", strtotime($request->employee_hire_date)),
                'created_at' => new \DateTime
            ];
            $this->employee_model->insert($employee_data);
            $response = [
                'success' => "Employee has been created"
            ];
            return redirect('admin/employee')->with($response);
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
        $employee = $this->employee_model->find($id);
        $page_name = "Employee Detail";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "",
            'employee' => $employee
        ];
        return view('admin.employee.employee_form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->employee_model->find($id);
        $page_name = "Employee Edit";
        $data = [
            'title' => $page_name . " |" . $this->scope,
            'page_name' => $page_name,
            'method' => "PUT",
            'employee' => $employee
        ];
        return view('admin.employee.employee_form', $data);
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
        $employee = $this->employee_model->find($id);
        $rules = [
            'username' => ['required', 'filled', 'unique:users,username,' . $employee->user_id . ',id,deleted_at,NULL'],
            'email' => ['required', 'filled', 'email', 'unique:users,email,' . $employee->user_id . ',id,deleted_at,NULL'],
            'password' => ['required', 'filled', 'confirmed', 'min:6', 'max:12'],
            'employee_first_name' => ['required', 'filled'],
            'employee_last_name' => ['required', 'filled'],
            'employee_gender' => ['required', 'filled', 'in:M,F'],
            'employee_dob' => ['required', 'filled', 'date'],
            'employee_hire_date' => ['required', 'filled', 'date'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $user_data = [
                'name' => $request->employee_first_name . " " . $request->employee_last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            $user_id = $this->user_model->where('id', $employee->user_id)->update($user_data);

            $employee_data = [
                'employee_first_name' => $request->employee_first_name,
                'employee_last_name' => $request->employee_last_name,
                'employee_gender' => $request->employee_gender,
                'employee_dob' => date("Y-m-d", strtotime($request->employee_dob)),
                'employee_hire_date' => date("Y-m-d", strtotime($request->employee_hire_date)),
            ];
            $this->employee_model->where('id', $employee->id)->update($employee_data);
            $response = [
                'success' => "Employee has been Updated"
            ];
            return redirect('admin/employee')->with($response);
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
        $employee = $this->employee_model->find($id);
        try {
            $employee->delete();
            $response = [
                'success' => "Employee has been Deleted"
            ];
            return redirect('admin/employee')->with($response);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'error' => "Server Error 500"
            ];
            return redirect()->back()->with($response)->withInput();
        }
    }
}
