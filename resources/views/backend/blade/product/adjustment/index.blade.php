@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Adjustment List') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/daterange-picker.css') }}">
@endpush
@push('page_css')
    <style>
        .loader-box {
            height: auto;
            padding: 10px 0px;
        }

        .loader-box .loader-35:after {
            height: 20px;
            width: 10px;
        }

        .loader-box .loader-35:before {
            width: 20px;
            height: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Adjustment List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Product') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Adjustment List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- View adjustment modal start --}}
    <div class="modal fade" id="view-adjustment-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Adjustment Details') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p> --}}
                <div class="modal-body" style="margin-top: -20px">
                    <h5 class="text-center mt-3">{{ __('admin_local.Product Details') }}</h5>
                    <table class="table table-bordered table-striped bg-primary">
                        <thead class="tbl-strip-thad-bdr">
                            <tr class="text-center">
                                <th>{{ __('admin_local.Product') }}</th>
                                <th>{{ __('admin_local.Code') }}</th>
                                <th>{{ __('admin_local.Quantity') }}</th>
                                <th>{{ __('admin_local.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                    <div class="row mt-4">
                        <div class="form-group col-lg-12">
                            <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                data-bs-dismiss="modal" style="float: right"
                                type="button">{{ __('admin_local.Close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- View adjustment Modal End --}}

    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Adjustment List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['adjustment-store']))
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <a href="{{ route('admin.productAdjustment.create') }}" class="btn btn-success" type="btn" >+ {{ __('admin_local.Add Adjustment') }}</a>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-4 " >
                            <form class="theme-form" action="">
                                @csrf
                                <div class="row col-md-6 mx-auto bg-info pb-4 pt-2 rounded">
                                    <div class="col-md-9">
                                        <label for="date_range" class="text-light">{{ __('admin_local.Select Date Range') }}</label>
                                        <input type="text" class="form-control" name="date_range" id="date_range">
                                    </div>
                                    <div class="col-md-3">
                                       <button class="btn btn-outline-dark form-control" style="margin-top: 31px;"><i class="fa fa-search-plus tetx-danger"></i> {{ __('admin_local.Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr class="text-center" style="background: azure">
                                        <th>{{ __('admin_local.Reference') }}</th>
                                        <th>{{ __('admin_local.Warehouse') }}</th>
                                        <th>{{ __('admin_local.Total Qty') }}</th>
                                        <th>{{ __('admin_local.Updated By') }}</th>
                                        <th>{{ __('admin_local.Updated At') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adjustments as $adjustment)
                                        <tr class="text-center" data-id="{{ $adjustment->id }}">
                                            <td>{{ $adjustment->reference_no }}</td>
                                            <td>{{ $adjustment->warehouse->name }}</td>
                                            <td>{{ array_sum(explode(',',$adjustment->total_qty)) }}</td>
                                            <td>{{ $adjustment->admin->name }}</td>
                                            <td>{{ date('d-M-Y',strtotime($adjustment->created_at)) }}</td>
                                            <td>
                                                @if (hasPermission(['permission-index']))
                                                <button class="btn btn-sm btn-primary px-2 py-1" data-bs-toggle="modal"
                                                data-bs-target="#view-adjustment-modal" id="view_btn"><i class="fa fa-desktop"></i></button> 
                                                @endif
                                                
                                                {{-- <button class="btn btn-sm btn-danger px-2 py-1"><i class="fa fa-trash"></i></button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @csrf
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker/daterange-picker/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker/daterange-picker/daterangepicker.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/datepicker/daterange-picker/daterange-picker.custom.js') }}"></script> --}}
    <script>
        $(document).ready(function(){
            var start = '{{ $startDate }}';
            var end = '{{ $endDate }}';

            function cb(start, end) {
                $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#date_range').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        })


        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-unit-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-unit-modal')
        });
        $('.js-example-basic-single3').select2({
            dropdownParent: $('#add-specific-user-permission-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            columnDefs: [{
                width: 250,
                targets: 0
            }, {
                width: 250,
                targets: 1
            }, {
                width: 90,
                targets: 2
            }],
        });

    </script>
    <script src="{{ asset('admin/custom/product/adjustmet_list.js') }}"></script>
@endpush
