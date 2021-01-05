@section('sidebar')
    <aside class="menu">
        <ul class="menu-list">
            <li>
                <a href="{{ url('/') }}">
                    <span class="icon">
                        <i class="fa fa-home"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/task') }}">
                    <span class="icon">
                        <i class="fas fa-tasks"></i>
                    </span>
                    <span>Task</span>
                </a>
            </li>
        </ul>
    </aside>
@endsection

@section('script')
    @parent
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let current_url = "{{ URL::current() }}";
            current_url_splitted = current_url.split(/[\/|\\]/);
            path = document.querySelectorAll('ul.menu-list li a');

            path_link = [];
            path.forEach((item) => {
                path_link.push(item.getAttribute('href'));
            });
            path_link_sorted = path_link.sort((a, b) => {
                return a.length - b.length
            });
            url_menu = ''
            path_link_sorted.forEach((link) => {
                if (current_url.includes(link)) {
                    url_menu = link
                }
            });

            path.forEach((item) => {
                url = item.getAttribute('href');
                url_splitted = url.split(/[\/|\\]/);
                if (url.length == url_menu.length) {
                    if (url_menu.includes(url)) {
                        item.classList.add('has-background-primary', 'has-text-white');
                    }
                }
            });
        });

    </script>
@endsection
