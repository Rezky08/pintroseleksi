@include('template.head')
@include('template.script')
<!DOCTYPE html>
<html>

<head>
    @section('head')
    @show
</head>

<body>
    @section('navbar')
    @show
    <div class="columns">
        @hasSection ('sidebar')
            <div class="column is-one-fifth">
                @section('sidebar')
                @show
            </div>
        @else

        @endif
        <div class="column">
            @section('content')
            @show
        </div>
    </div>


    @section('script')
    @show
</body>

</html>
