<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            {{ isset($slot) ? $slot: '<a class="navbar-brand" href="#">'.$slot.'</a>'}}

        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ url("logout") }}">
                        <i class="ti-shine"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
