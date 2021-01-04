@extends('admin.template.template')
@section('content')
    @parent
@section('page_name', $page_name)
    <div class="buttons is-right">
        <a href="{{ url('admin/employee/create') }}" class="button is-primary">
            <span class="icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Add Employee</span>
        </a>
    </div>
    <div class="box">
        <table class="table is-fullwidth">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>Hire Date</th>
                <th></th>
            </thead>
            <tbody>
                @php
                $num_item=1;
                @endphp
                @foreach ($employees as $employee)
                    <th>{{ $num_item++ }}</th>
                    <td>{{ $employee->employee_fullname }}</td>
                    <td>{{ $employee->gender }}</td>
                    <td>{{ date('d-M-Y', strtotime($employee->employee_hire_date)) }}</td>
                    <td>{{ date('d-M-Y', strtotime($employee->employee_dob)) }}</td>
                    <td>
                        <div class="buttons">
                            <a href="" class="button button-primary is-info">
                                <span class="icon">
                                    <i class="fa fa-info"></i>
                                </span>
                            </a>
                            <a href="" class="button is-danger is-outlined">
                                <span class="icon">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </a>
                        </div>
                    </td>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container px-5">
        <nav class="pagination is-centered">
            <a class="pagination-previous" href="{{ $employees->previousPageUrl() }}">
                <span class="icon">
                    <i class="fa fa-chevron-left"></i>
                </span>
            </a>
            <ul class="pagination-list">
                @php
                $max_paginate = ($max_paginate < $employees->lastPage()) ? $max_paginate : $employees->lastPage();
                    @endphp
                    @for ($i = 1; $i <= $max_paginate; $i++)
                        <li>
                            <a href="{{ $employees->url($i) }}" class="pagination-link">{{ $i }}</a>
                        </li>
                    @endfor
            </ul>
            <a class="pagination-next" href="{{ $employees->previousPageUrl() }}">
                <span class="icon">
                    <i class="fa fa-chevron-right"></i>
                </span>
            </a>
        </nav>
    </div>
@endsection
