<div class="col-lg-3 col-sm-6">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-xs-5">
                    <div class="icon-big {{ $color ?? "icon-warning" }} text-center">
                        <i class="{{ $icon ?? "ti-alert" }}"></i>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="numbers">
                        <p>{{ $title ?? "Title" }}</p>
                        {{ $value ?? "value" }}
                    </div>
                </div>
            </div>
            {!! $footer ?? "" !!}
            {{--<div class="footer">--}}
                {{--<hr>--}}
                {{--<div class="stats">--}}
                    {{--<i class="ti-reload"></i> Updated now--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
</div>