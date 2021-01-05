@extends('admin.template.template')
@section('content')
    @parent
@section('page_name', $page_name)
    <div class="columns">
        <div class="column">
            <form action="" method="get">
                <div class="field">
                    <div class="control">
                        <input type="text" name="task_name" class="input" placeholder="search task name...">
                    </div>
                </div>
            </form>
        </div>
        <div class="column">
            <div class="buttons is-right">
                <a href="{{ url('admin/employee/' . $employee->id . '/task/create') }}" class="button is-primary">
                    <span class="icon">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span>Add Task</span>
                </a>
            </div>
        </div>
    </div>
    <div class="box">
        <table class="table is-fullwidth">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($tasks as $index => $task)
                    <tr>
                        <th>{{ $num_item++ }}</th>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->task_desc }}</td>
                        <td>
                            <div class="buttons">
                                <a href="{{ url('admin/employee/' . $employee->id . '/task/' . $task->pivot->id . '/edit') }}"
                                    class="button is-info">
                                    <span class="icon">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                </a>
                                <form action="{{ url('admin/employee/' . $employee->id . '/task/' . $task->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button is-danger is-outlined">
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
    @if ($tasks)
        <div class="container px-5">
            <nav class="pagination is-centered">
                <a class="pagination-previous" href="{{ $tasks->previousPageUrl() }}">
                    <span class="icon">
                        <i class="fa fa-chevron-left"></i>
                    </span>
                </a>
                <ul class="pagination-list">
                    @php
                    $max_paginate = ($max_paginate < $tasks->lastPage()) ? $max_paginate : $tasks->lastPage();
                        @endphp
                        @for ($i = 1; $i <= $max_paginate; $i++)
                            <li>
                                <a href="{{ $tasks->url($i) }}" class="pagination-link">{{ $i }}</a>
                            </li>
                        @endfor
                </ul>
                <a class="pagination-next" href="{{ $tasks->previousPageUrl() }}">
                    <span class="icon">
                        <i class="fa fa-chevron-right"></i>
                    </span>
                </a>
            </nav>
        </div>

    @endif
@endsection

@section('script')
    @parent
    <script>
        document.addEventListener("DOMContentLoaded", () => {

        });

    </script>
@endsection
