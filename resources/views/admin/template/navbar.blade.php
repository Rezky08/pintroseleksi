@section('navbar')
    <div class="navbar has-background-primary">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('admin') }}">
                <span class="is-size-4 has-text-weight-bold has-text-white">Task Divider</span>
            </a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item has-text-white" href="{{ url('logout') }}">Logout</a>
            </div>
        </div>
    </div>
@endsection
