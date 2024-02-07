@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Add Adjustment') }}
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
                    <h3>{{ __('admin_local.Add Adjustment') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Product') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Add Adjustment') }}</li>
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
                                <span class="text-danger err-mgs"></span>
                            </div>
                           
                            <div class="col-lg-6 mt-2">
                                <label for="brand_image"><strong>{{ __('Brand Image') }} </strong></label>
                                <input type="file" class="form-control" name="brand_image" id="brand_image">
                                <span class="text-danger err-mgs"></span>
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
                                <span class="text-danger err-mgs"></span>
                            </div>
                           
                            <div class="col-lg-6 mt-2">
                                <label for="brand_image"><strong>{{ __('Brand Image') }} </strong></label>
                                <input type="file" class="form-control" name="brand_image" id="brand_image">
                                <span class="text-danger err-mgs"></span>
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
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray;background:azure;">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Add Adjustment') }}</h3>
                    </div>

                    <div class="card-body">
                        <form id="add_adjustment_form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <label for="warehouse"><strong>{{ __('admin_local.Warehouse') }} *</strong></label>
                                    <select class="js-example-basic-single" name="warehouse" id="warehouse">
                                        <option value="">Select One</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger err-mgs"></span>
                                </div>
                               
                                <div class="col-lg-4 mt-2">
                                    <label for="attatched_file"><strong>{{ __('admin_local.Attatched File') }} </strong></label>
                                    <input type="file" class="form-control" name="attatched_file" id="attatched_file">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="referance"><strong>{{ __('admin_local.Reference') }} </strong></label>
                                    <input type="text" class="form-control" name="referance" id="referance">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="product"><strong>{{ __('admin_local.Select Product') }} *</strong></label>
                                    <div class="input-group col-md-12" id="the-basics">
                                        <span class="input-group-text col-md-1" style="border:1px solid black;"><i
                                                class="fa fa-barcode"></i></span>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control"
                                            id="add_combo_product" style="width: 100% !important;">
                                        </div>
                                        
                                    </div>
                                    <span class="text-danger err-mgs-add_combo_product"></span>
                                </div>
                                <div class="form-group col-md-12 mt-4">
                                    <label for="add_combo_product">{{ __('admin_local.Order Table') }} *</label>
                                    <div class="table-responsive">
                                        <table id="combo_product_table" class="table table-bordered table-striped" class="display table table-bordered">
                                            <thead>
                                                <tr style="background-color: azure">
                                                    <th style="width: 30%"><b>{{ __('admin_local.Product Name') }}</b></th>
                                                    <th style="width: 10%"><b>{{ __('admin_local.Code') }}</b></th>
                                                    <th style="width: 10%"><b>{{ __('admin_local.Price') }}</b></th>
                                                    <th style="width: 20%"><b>{{ __('admin_local.Quantity') }}</b></th>
                                                    <th style="width: 20%"><b>{{ __('admin_local.Action') }}</b></th>
                                                    <th style="width: 10%"><b>{{ __('admin_local.Delete') }}</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-2">
                                    <label for="notes"><strong>{{ __('admin_local.Notes') }} </strong></label>
                                    <textarea class="form-control" name="notes" id="notes" rows="8"></textarea>
                                    <span class="text-danger err-mgs"></span>
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
    <script src="{{ asset('admin/assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset('admin/assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-brand-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var form_url = "{{ route('admin.productAdjustment.store') }}";
        // var getting_permission = `<span>{{ __('admin_local.Getting Permissons') }} ...... <i class="fa fa-spinner fa-spin" ></i></span>`;
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this brand data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = '{{ __('admin_local.No file') }}';

        
    </script>
    <script src="{{ asset('admin/custom/product/add_adjustment.js') }}"></script>
@endpush
