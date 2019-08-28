@extends("master")

@section("nav_title")
    <a class="navbar-brand" href="#">Dashboard</a>
@stop

@section("contents")
    @component("components.dash")
        @slot("color")
            icon-danger
        @endslot
        @slot("icon")
            ti-user
        @endslot
        @slot("title")
            Active User
        @endslot
        @slot("value")
            {{ $activeUser }}
        @endslot
    @endcomponent

    @component("components.dash")
        @slot("color")
            icon-primary
        @endslot
        @slot("icon")
            ti-lock
        @endslot
        @slot("title")
            Accounts
        @endslot
        @slot("value")
            {{ $accountCount }}
        @endslot
    @endcomponent

    @component("components.dash")
        @slot("color")
            icon-warning
        @endslot
        @slot("icon")
            ti-bag
        @endslot
        @slot("title")
            Package
        @endslot
        @slot("value")
            {{ $packageCount }}
        @endslot
    @endcomponent

    @component("components.dash")
        @slot("color")
            icon-primary
        @endslot
        @slot("icon")
            ti-money
        @endslot
        @slot("title")
            Pending payment
        @endslot
        @slot("value")
            {{ $pendingPaymentCount }}
        @endslot
    @endcomponent
@stop
