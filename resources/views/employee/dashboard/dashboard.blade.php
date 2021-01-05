@extends('employee.template.template')
@section('title', $title)
@section('content')
    @parent
@section('page_name', $page_name)
    <div class="container">
        <div class="columns">
            <div class="column is-offset-one-third is-one-quarter has-text-centered">
                <div class="box">
                    <span class="is-size-3">
                        {{ $task_count }}
                    </span>
                    <div class="block">
                        <span class="is-size-4 has-text-weight-bold">
                            Task
                        </span>

                    </div>
                </div>
            </div>
        </div>
        <div class="columns has-text-centered">
            <div class="column is-offset-1 is-one-third">
                <div class="box">
                    <span class="is-size-3">
                        {{ $completed_count }}
                    </span>
                    <div class="block">
                        <span class="tag is-success is-size-4 has-text-weight-bold">
                            Task Completed
                        </span>
                    </div>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="box">
                    <span class="is-size-3">
                        {{ $incompleted_count }}
                    </span>
                    <div class="block">
                        <span class="tag is-danger is-size-4 has-text-weight-bold">
                            Task Incompleted
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
