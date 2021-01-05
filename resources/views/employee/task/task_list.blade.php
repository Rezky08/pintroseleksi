@extends('employee.template.template')
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
                <th>Description</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach ($tasks as $index => $task)
                    <tr>
                        <th>{{ $num_item++ }}</th>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->task_desc }}</td>
                        <td>
                            <div class="status">
                                <div class="status-tag">
                                    @if ($task->pivot->is_completed)
                                        <span class="tag is-success">Completed</span>
                                    @else
                                        <span class="tag is-danger">Incompleted</span>
                                    @endif
                                </div>
                                <div class="status-form is-hidden">
                                    <form action="{{ url('task/' . $task->pivot->id) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="field">
                                            <div class="select">
                                                <select name="task_status">
                                                    <option value="" disabled selected>
                                                        select
                                                    </option>
                                                    <option value="1" @if ($task->pivot->is_completed)selected
                @endif >Completed</option>
                <option value="0" @if (!$task->pivot->is_completed)selected
                    @endif
                    >Incompleted</option>
                </select>
    </div>
    </div>
    </form>

    </div>
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

    {{-- modal --}}
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
                        <label class="label">Status</label>
                        <div class="control">
                            <input class="is-checkradio" type="radio" value="" name="task_status" id="task_all" checked>
                            <label for="task_all">All</label>
                            <input class="is-checkradio" type="radio" value="1" name="task_status" id="task_completed">
                            <label for="task_completed">Completed</label>
                            <input class="is-checkradio" type="radio" value="0" name="task_status" id="task_incompleted">
                            <label for="task_incompleted">Incompleted</label>
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
            document.querySelectorAll('div.status').forEach((item) => {
                item.addEventListener("click", () => {
                    tag = item.querySelector('.status-tag')
                    form = item.querySelector('.status-form')
                    tag.classList.add('is-hidden');
                    form.classList.remove('is-hidden');
                })
            });
            document.querySelectorAll('select[name=task_status]').forEach((item) => {
                item.addEventListener("change", () => {
                    parentForm = item.parentElement
                    while (parentForm.nodeName != 'FORM') {
                        parentForm = parentForm.parentElement
                    }
                    parentForm.submit();
                });
                item.addEventListener("blur", () => {
                    parentForm = item.parentElement
                    while (parentForm.nodeName != 'FORM') {
                        parentForm = parentForm.parentElement
                    }
                    parentForm.submit();
                });
            });

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
