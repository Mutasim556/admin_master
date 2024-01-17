@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Access Denied') }}
@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Column -->
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                    <h3 class="card-title mb-0 text-center">{{ __('admin_local.Important Message') }}</h3>
                </div>
                <div class="card-body my-2">
                    <div class="row">
                        <div class="col-md-4 mx-auto text-center">
                            {{-- <audio id="my_audio" src="{{ asset('admin/assets/audio/access-denied2.mp3') }}" autoplay loop="loop"></audio> --}}
                            {{-- <audio id="audio" controls autoplay>
                                <source  src="{{ asset('admin/assets/audio/access-denied2.mp3') }}" type="audio/ogg">
                                <source  src="{{ asset('admin/assets/audio/access-denied2.mp3') }}" type="audio/mpeg">
                            </audio> --}}
                            <img src="{{ asset('admin/images/access-denied.gif') }}" style="height: 200px;width:100%"  alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('js')
{{-- <script>
    $(document).ready(function(){
        $('#audio')[0].play();
    })
</script> --}}
@endpush