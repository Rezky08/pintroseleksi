<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $scope;
    function __construct()
    {
        $this->scope = "Admin";
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard | ' . $this->scope
        ];
        return view('admin.dashboard.dashboard', $data);
    }
}
