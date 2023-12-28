@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('Dashboard') }}
@endpush
@section('content')
@endsection

@push('js')
    <script>
        function welcome_loggedin_user() {
            $.notify(
                '<i class="fa fa-check-square-o"></i><strong>{{ __("Hello ") }}{{ Auth::guard("admin")->user()->name }}</strong> {{ __("Welcome to ").env("APP_BACKEND_NAME")}}', {
                    type: 'info',
                    allow_dismiss: true,
                    delay: 2000,
                    showProgressbar: true,
                    timer: 300,
                    placement: {
                        from: 'bottom',
                        align: 'right'
                    },
                    animate: {
                        enter: 'animated rotateInDownLeft',
                        exit: 'animated zoomOutDown'
                    }
                });
        };

        // $(document).ready(function(){
        //         welcome_loggedin_user();
        //     });
    </script>

    @if(Session::has('success_login'))
        <script>
            $(document).ready(function(){
                welcome_loggedin_user();
            });
        </script>
    @endif
@endpush
