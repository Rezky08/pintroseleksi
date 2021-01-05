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
            @if (Session::has('success'))
                <div class="notification is-success">
                    <button class="delete"></button>
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="notification is-danger">
                    <button class="delete"></button>
                    {{ Session::get('error') }}
                </div>
            @endif
            @section('content')
            @show
        </div>
    </div>


    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                    var $notification = $delete.parentNode;

                    $delete.addEventListener('click', () => {
                        $notification.parentNode.removeChild($notification);
                    });
                });
            });

        </script>
    @show
</body>

</html>
