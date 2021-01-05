@include('employee.template.sidebar')
@include('employee.template.navbar')
@extends('template.template')

@section('title', $title)

@section('content')
    @hasSection ('page_name')
        <div class="my-5">
            <span class="is-size-4 has-text-weight-bold">
                @yield('page_name')
            </span>
        </div>
        <hr>
    @else

    @endif

@endsection
