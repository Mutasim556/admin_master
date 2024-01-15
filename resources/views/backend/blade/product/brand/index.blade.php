@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Brand List') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
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
                    <h3>{{ __('admin_local.Brand List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Product') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Brand') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="add-brand-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('Add Brand') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POST" action="" id="add_brand_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="brand_name"><strong>{{ __('Brand Name') }} *</strong></label>
                                <input type="text" class="form-control" name="brand_name" id="brand_name">
                            </div>
                           
                            <div class="col-lg-6 mt-2">
                                <label for="brand_image"><strong>{{ __('Brand Image') }} </strong></label>
                                <input type="file" class="form-control" name="brand_image" id="brand_image">
                            </div>
                        </div>
                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">
                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add User Modal End --}}

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="edit-brand-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('Edit Brand') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form id="edit_brand_form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="brand_id" name="brand_id" value="">
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="brand_name"><strong>{{ __('Brand Name') }} *</strong></label>
                                <input type="text" class="form-control" name="brand_name" id="brand_name">
                            </div>
                           
                            <div class="col-lg-6 mt-2">
                                <label for="brand_image"><strong>{{ __('Brand Image') }} </strong></label>
                                <input type="file" class="form-control" name="brand_image" id="brand_image">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="parent_brand_image"><strong>{{ __('Previous Parent brand Image') }} </strong></label>
                                <div style="height: 50px" id="image_preview">
                                    <img src="" alt="">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">
                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add User Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Brand List') }}</h3>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                    data-bs-target="#add-brand-modal">+ {{ __('admin_local.Add Brand') }}</button>
                            </div>
                        </div>

                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Brand Image') }}</th>
                                        <th>{{ __('admin_local.Brand Name') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr id="trid-{{ $brand->brand_id }}" data-id="{{ $brand->brand_id }}">
                                            <td>@if($brand->brand_image)<img src="{{ asset($brand->brand_image) }}" alt="" style="height:">@else No File @endif</td>
                                            <td>{{ $brand->brand_name }}</td>
                                            <td class="text-center">
                                                <span class="mx-2">{{ $brand->brand_status }}</span><input
                                                    data-status="{{ $brand->brand_status == 'Active' ? 'Inactive' : 'Active' }}"
                                                    id="status_change" type="checkbox" data-toggle="switchery"
                                                    data-color="green" data-secondary-color="red" data-size="small"
                                                    {{ $brand->brand_status == 'Active' ? 'checked' : '' }} />
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-brand-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>

                                                        {{-- <a class="text-info" id="delete_button" style="cursor: pointer;"><i
                                                            class="fa fa-trash mx-1"></i> Email</a> --}}

                                                        <a class="text-danger" id="delete_button"
                                                            style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                                            {{ __('admin_local.Delete') }}</a>
                                                    </div>
                                                </div>
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
    {{-- <script src="{{ asset('inventory/assets/js/select2/select2-custom.js') }}"></script> --}}
    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-brand-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-brand-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            "language" : {
                "decimal":        "",
                "emptyTable":     "{{ __('admin_local.No data available in table') }}",
                "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty":      "Showing 0 to 0 of 0 entries",
                "infoFiltered":   "(filtered from _MAX_ total entries)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Show _MENU_ entries",
                "loadingRecords": "Loading...",
                "processing":     "",
                "search":         "Search:",
                "zeroRecords":    "No matching records found",
                "paginate": {
                    "first":      "First",
                    "last":       "Last",
                    "next":       "Next",
                    "previous":   "Previous"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });

        var form_url = "{{ route('admin.product.brand.store') }}";
        // var getting_permission = `<span>{{ __('admin_local.Getting Permissons') }} ...... <i class="fa fa-spinner fa-spin" ></i></span>`;
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this brand data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = '{{ __("admin_local.No file") }}'
    </script>
    <script src="{{ asset('admin/custom/product/brand.js') }}"></script>
    {{-- <script src="{{ asset('inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
