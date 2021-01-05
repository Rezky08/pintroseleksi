@extends('admin.template.template')
@section('content')
    @parent
@section('page_name', $page_name)
    <div class="columns">
        <div class="column">
            <form action="" method="get">
                <div class="field">
                    <div class="control">
                        <input type="text" name="employee_name" class="input" placeholder="search employee name...">
                    </div>
                </div>
            </form>
        </div>
        <div class="column">
            <div class="buttons is-right">
                <a href="{{ url('admin/employee/create') }}" class="button is-primary">
                    <span class="icon">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span>Add Employee</span>
                </a>
                <button class="button modal-button" data-target="filter">
                    <span class="icon">
                        <i class="fas fa-filter"></i>
                    </span>
                    <span>
                        Filter
                    </span>
                </button>
            </div>
        </div>
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
                @foreach ($employees as $index => $employee)
                    <tr>
                        <th>{{ $num_item++ }}</th>
                        <td>{{ $employee->employee_fullname }}</td>
                        <td>{{ $employee->gender_detail }}</td>
                        <td>{{ date('d-M-Y', strtotime($employee->employee_hire_date)) }}</td>
                        <td>{{ date('d-M-Y', strtotime($employee->employee_dob)) }}</td>
                        <td>
                            <div class="buttons">
                                <a href="{{ url('admin/employee/' . $employee->id . '/task') }}" class="button is-info"
                                    data-tooltip="Employee Task">
                                    <span class="icon">
                                        <i class="fa fa-tasks"></i>
                                    </span>
                                </a>
                                <a href="{{ url('admin/employee/' . $employee->id, []) }}" class="button is-primary"
                                    data-tooltip="Employee Detail">
                                    <span class="icon">
                                        <i class="fa fa-info"></i>
                                    </span>
                                </a>
                                <a href="{{ url('admin/employee/' . $employee->id . '/edit') }}" class="button is-info"
                                    data-tooltip="Employee Edit">
                                    <span class="icon">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                </a>
                                <form action="{{ url('admin/employee/' . $employee->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button is-danger is-outlined" data-tooltip="Employee Delete">
                                        <span class="icon">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
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
    <div class="modal" id="filter">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <div class="block">
                    <span class="is-size-4 has-text-weight-bold">
                        Filter
                    </span>
                </div>
                <form action="" method="GET">
                    <div class="field">
                        <label class="label">Gender</label>
                        <div class="control">
                            <input class="is-checkradio" type="radio" value="" name="employee_gender" id="gender_all"
                                checked>
                            <label for="gender_all">All</label>
                            <input class="is-checkradio" type="radio" value="M" name="employee_gender" id="gender_male">
                            <label for="gender_male">Male</label>
                            <input class="is-checkradio" type="radio" value="F" name="employee_gender" id="gender_female">
                            <label for="gender_female">Female</label>
                        </div>
                    </div>
                    <span class="label">Date of Birth</span>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <div class="control">
                                    <input type="date" name="employee_dob_from">
                                </div>
                            </div>
                        </div>
                        <div class="column is-1 has-text-centered">
                            <span>to</span>
                        </div>
                        <div class="column">
                            <div class="field">
                                <div class="control">
                                    <input type="date" name="employee_dob_to">
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="label">Hire Date</span>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <div class="control">
                                    <input type="date" name="employee_hire_date_from">
                                </div>
                            </div>
                        </div>
                        <div class="column is-1 has-text-centered">
                            <span>to</span>
                        </div>
                        <div class="column">
                            <div class="field">
                                <div class="control">
                                    <input type="date" name="employee_hire_date_to">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="button is-primary is-fullwidth" name="filter_apply" value="true">
                        <span>Apply Filter</span>
                    </button>
                </form>
            </div>
        </div>
        <button class="modal-close"></button>
    </div>
@endsection

@section('script')
    @parent
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            options = {
                'displayMode': 'dialog'
            }
            let calendars = bulmaCalendar.attach('[type="date"]', options);

            document.querySelectorAll(".modal-button").forEach(item => {
                data_target = item.getAttribute('data-target');
                item.addEventListener("click", () => {
                    document.querySelector('#' + data_target).classList.add('is-active')
                })
            });
            document.querySelectorAll(".modal-close").forEach(item => {
                modal_parent = item.parentElement
                item.addEventListener("click", () => {
                    modal_parent.classList.remove('is-active')
                });
            });
        });

    </script>
@endsection
