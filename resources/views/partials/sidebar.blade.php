<div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
        Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
        Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
    -->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text">
                GRAMSHOOT
            </a>
        </div>

        <ul class="nav">
            <li class="{{ strpos(Request::url(),"dashboard") !== false || Request::is("/") ? "active":"" }}">
                <a href="{{ url("admin/dashboard") }}">
                    <i class="ti-pie-chart"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="{{ strpos(Request::url(),"user") !== false ? "active":"" }}">
                <a href="{{ url("admin/user") }}">
                    <i class="ti-user"></i>
                    <p>Users</p>
                </a>
            </li>

            <li class="{{ strpos(Request::url(),"account") !== false ? "active":"" }}">
                <a href="{{ url("admin/account") }}">
                    <i class="ti-lock"></i>
                    <p>Accounts</p>
                </a>
            </li>

            <li class="{{ strpos(Request::url(),"package") !== false ? "active":"" }}">
                <a href={{ url("admin/package") }}>
                    <i class="ti-files"></i>
                    <p>Package</p>
                </a>
            </li>

            <li class="{{ strpos(Request::url(),"payment") !== false ? "active":"" }}">
                <a href={{ url("admin/payment") }}>
                    <i class="ti-money"></i>
                    <p>Payment</p>
                </a>
            </li>

        </ul>
    </div>
</div>
