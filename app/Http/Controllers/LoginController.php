<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $employee_model;
    private $user_model;
    function __construct()
    {
        $this->employee_model = new Employee();
        $this->user_model = new User();
    }
    public function index()
    {
        $data = [
            'title' => "Login"
        ];
        return view('login.login', $data);
    }
    public function login(Request $request)
    {
        $rules = [
            'username' => ['required', 'filled', 'exists:users,username,deleted_at,NULL'],
            'password' => ['required', 'filled']
        ];
        $messages = [
            'username.exists' => "Username or Password is invalid"
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $user = $this->user_model->where('username', $request->username)->first();
        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if ($user->role->role_name == 'admin') {
                return redirect('/admin');
            }
            if ($user->role->role_name == 'employee') {
                return redirect('/dashboard');
            }
        } else {
            $messages = [
                'username' => "Username or Password is invalid"
            ];
            return redirect()->back()->withErrors($messages)->withInput();
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        try {
            Auth::logout($user);
            return redirect('/login');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'error' => "Server Error 500"
            ];
            return redirect()->to('/')->with($response);
        }
    }
}
