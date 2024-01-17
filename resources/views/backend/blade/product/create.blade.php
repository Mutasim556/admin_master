@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Add Product') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/taginputs/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/date-picker.css') }}">
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
        .cke_contents {
            border: 2px dashed #5c61f2 !important;
            border-radius: 0px 0px 10px 10px
        }

        .cke_top {
            border: 2px dashed #5c61f2 !important;
            border-bottom: 0px !important;
            border-radius: 10px 10px 0px 0px
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('Add Product') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('Product') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Add Product') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('Add Product') }}</h3>
                    </div>
                    <p class="px-4 text-danger"><i>{{ __('The field labels marked with * are required input fields.') }}</i>
                    </p>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="theme-form" id="add_product_form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="product_type">{{ __('Product Type') }}</label>
                                            <select class="form-select" id="product_type" name="product_type">
                                                <option value="" disabled>{{ __('Please Select') }} *
                                                </option>
                                                <option value="standard" selected>Standard</option>
                                                <option value="combo">Combo</option>
                                                <option value="digital">Digital</option>
                                                <option value="service">Service</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product_name">{{ __('Product Name') }} *</label>
                                            <input type="text" class="form-control" id="product_name"
                                                name="product_name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product_code">{{ __('Product Code') }} *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="product_code"
                                                    name="product_code"><span id="get_code" class="input-group-text"
                                                    style="border:1px solid black;"><i class="fa fa-refresh"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="barcode_symbology">{{ __('Barcode Symbology') }} *</label>
                                            <select class="form-select" id="barcode_symbology" name="barcode_symbology">
                                                <option value="" disabled>{{ __('Please Select') }}</option>
                                                <option value="C128" selected>Code 128</option>
                                                <option value="C39">Code 39</option>
                                                <option value="UPCA">UPC-A</option>
                                                <option value="UPCE">UPC-E</option>
                                                <option value="EAN8">EAN-8</option>
                                                <option value="EAN13">EAN-13</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4" id="attatchment_div">
                                            <label for="attatch_file">{{ __('Attatched File') }} *</label>
                                            <input type="file" class="form-control" id="attatch_file"
                                                name="attatch_file">
                                        </div>
                                        <div class="form-group col-md-4" id="brand_div">
                                            <label for="brand">{{ __('Brand') }}</label>
                                            <select class="js-example-basic-single form-select" id="brand"
                                                name="brand">
                                                <option value="">{{ __('Please Select') }}</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4" id="category_div">
                                            <label for="category">{{ __('Category') }} *</label>
                                            <select class="js-example-basic-single form-control" id="category"
                                                name="category">
                                                <option value="">{{ __('Please Select') }}</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="combo">
                                        <div class="form-group col-md-8">
                                            <label for="add_combo_product">{{ __('Add Combo Product') }} *</label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="border:1px solid black;"><i
                                                        class="fa fa-barcode"></i></span>
                                                <input type="text" class="form-control" name="add_combo_product"
                                                    id="add_combo_product">
                                            </div>

                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="add_combo_product">{{ __('Combo Products') }} *</label>
                                            <table id="" class="display table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><b>{{ __('Product') }}</b></th>
                                                        <th><b>{{ __('Quantity') }}</b></th>
                                                        <th><b>{{ __('Unit Price') }}</b></th>
                                                        <th><b>{{ __('Action') }}</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Test</td>
                                                        <td><input type="number" class="form-control" value="1"
                                                                min="1"></td>
                                                        <td><input type="number" class="form-control" value="1"
                                                                min="1"></td>
                                                        <td class="text-center"><button type="button"
                                                                class="btn btn-danger btn-sm px-2 py-2"><i
                                                                    class="fa fa-trash"
                                                                    style="font-size: 17px"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" id="visible_unit">
                                        <div class="form-group col-md-4">
                                            <label for="product_unit">{{ __('Product Unit') }} *</label>
                                            <select class="js-example-basic-single form-control" id="product_unit"
                                                name="product_unit">
                                                <option value="">{{ __('Please Select') }}</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="sale_unit">{{ __('Sale Unit') }} *</label>
                                            <select class="js-example-basic-single form-control" id="sale_unit"
                                                name="sale_unit">
                                                <option value="">{{ __('Please Select') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="purchase_unit">{{ __('Purchase Unit') }} *</label>
                                            <select class="js-example-basic-single form-control" id="purchase_unit"
                                                name="purchase_unit">
                                                <option value="">{{ __('Please Select') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="unit_size">{{ __('Unit Size') }} *</label>
                                            <input type="text" class="form-control" id="unit_size" name="unit_size">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="cartoon_size">{{ __('Cartoon Size') }} *</label>
                                            <input type="text" class="form-control" id="cartoon_size"
                                                name="cartoon_size">
                                        </div>
                                        <div class="form-group col-md-4" id="product_cost_div">
                                            <label for="product_cost">{{ __('Product Cost') }} *</label>
                                            <input type="text" class="form-control" id="product_cost"
                                                name="product_cost">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product_price">{{ __('Product Price') }} *</label>
                                            <input type="text" class="form-control" id="product_price"
                                                name="product_price">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="daily_sale_objective">{{ __('Daily Sale Objective') }} <i
                                                    style="font-size: 16px;cursor:pointer"
                                                    class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ __('Minimum qty which must be sold in a day. If not, you will be notified on dashboard. But you have to set up the cron job properly for that. Follow the documentation in that regard.') }}"></i></label>
                                            <input type="text" class="form-control" id="daily_sale_objective"
                                                name="daily_sale_objective">
                                        </div>
                                        <div class="form-group col-md-4" id="alert_quantity_div">
                                            <label for="alert_quantity">{{ __('Alert Quantity') }} </label>
                                            <input type="number" class="form-control" id="alert_quantity"
                                                name="alert_quantity" min="0">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product_tax">{{ __('Product Tax') }}</label>
                                            <select class="form-control" id="product_tax" name="product_tax">
                                                <option value="">No Tax</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="tax_method">{{ __('Tax Method') }} <i
                                                    style="font-size: 16px;cursor:pointer"
                                                    class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ __('Exclusive: Poduct price = Actual product price + Tax. Inclusive: Actual product price = Product price - Tax') }}"></i></label>
                                            <select class="form-control" id="tax_method" name="tax_method">
                                                <option value="1">Inclusive</option>
                                                <option value="2">Exclusive</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="checkbox" id="featured" class="mr-2" name="featured">
                                            &nbsp;&nbsp;<label for="featured">{{ __('Featured') }} </label>
                                            <p>Featured product will be displayed in POS</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="checkbox" id="embedded_barcode" name="embedded_barcode" />
                                            &nbsp;&nbsp;<label for="embedded_barcode">{{ __('Embedded Barcode') }} <i
                                                    style="font-size: 16px;cursor:pointer"
                                                    class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ __('Check this if this product will be used in weight scale machine.') }}"></i></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="product_image">{{ __('Product Image / Images') }} <i
                                                    style="font-size: 16px;cursor:pointer"
                                                    class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ __('You can upload multiple image. Only .jpeg, .jpg, .png, .gif file can be uploaded. First image will be base image.') }}"></i>
                                            </label>
                                            <div id="dropzoneDragArea" class="dropzone dropzone-info">
                                                <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                                                    <h6>Drop files here or click to upload.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="product_details">{{ __('Product Details') }} </label>
                                            <textarea id="editor1" name="product_details" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="row" id="variant_row">
                                        <div class="form-group col-md-12">
                                            <input type="checkbox" id="variant" class="mr-2" name="variant">
                                            &nbsp;&nbsp;<label for="variant">{{ __('This product has variant') }}
                                            </label>
                                        </div>

                                    </div>
                                    <div class="row variant_option_row" id="variant_option_row"
                                        style="margin-bottom: -30px;">
                                        <div class="form-group col-md-5">
                                            <label for="variant_option">{{ __('Option *') }}</label>
                                            <input type="text" class="form-control" name="variant_option[]"
                                                id="variant_option">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="variant_value">{{ __('Value *') }}</label>
                                            <input type="text" class="form-control variant_value"
                                                name="variant_value[]" id="variant_value" data-role="tagsinput">
                                        </div>
                                        <div class="form-group col-md-2 text-center" style="line-height: 100px;">
                                            <button type="button" class="btn btn-primary" id="add_new_variant">+ Add New
                                                Varient</button>
                                        </div>
                                    </div>
                                    <div>

                                    </div>
                                    <div class="row mb-4" id="variant_option_table">
                                        <div class="form-group col-md-12">
                                            <table class="display table table-bordered">
                                                <thead>
                                                    <tr class="table-dark">
                                                        <th><b>{{ __('Name') }}</b></th>
                                                        <th><b>{{ __('Item Code') }}</b></th>
                                                        <th><b>{{ __('Additional Cost') }}</b></th>
                                                        <th><b>{{ __('Additional Price') }}</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row " id="warehouse_price_row">
                                        <div class="form-group col-md-8">
                                            <input type="checkbox" id="warehouse_price" class="mr-2"
                                                name="warehouse_price">
                                            &nbsp;&nbsp;<label
                                                for="warehouse_price">{{ __('This product has different price for different warehouse') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="warehouse_price_table">
                                        <div class="form-group col-md-6">
                                            <table class="display table table-bordered">
                                                <thead>
                                                    <tr class="table-success">
                                                        <th><b>{{ __('Warehouse') }}</b></th>
                                                        <th><b>{{ __('Price') }}</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Test</td>
                                                        <td><input type="number" class="form-control" value="1"
                                                                min="1"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" id="batch_expire_date_row">
                                        <div class="form-group col-md-8">
                                            <input type="checkbox" id="batch_expire_date" class="mr-2"
                                                name="batch_expire_date" value="1">
                                            &nbsp;&nbsp;<label
                                                for="batch_expire_date">{{ __('This product has batch and expired date') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row" id="imei_row">
                                        <div class="form-group col-md-8">
                                            <input type="checkbox" id="imei" class="mr-2" name="imei">
                                            &nbsp;&nbsp;<label
                                                for="imei">{{ __('This product has IMEI or Serial numbers') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row" id="add_promotional_price_div">
                                        <div class="form-group col-md-8">
                                            <input type="checkbox" id="add_promotional_price" class="mr-2"
                                                name="add_promotional_price">
                                            &nbsp;&nbsp;<label
                                                for="add_promotional_price">{{ __('Add Promotional Price') }} </label>
                                        </div>
                                    </div>
                                    <div class="row" id="add_promotional_price_row">
                                        <div class="form-group col-md-4">
                                            <label for="promotional_price">{{ __('Promotional Price') }}</label>
                                            <input type="text" name="promotional_price" id="promotional_price"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="promotional_start">{{ __('Promotion Starts') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="border:1px solid black;"><i
                                                        class="fa fa-calendar"></i></span><input type="date"
                                                    name="promotional_start" id="promotional_start"
                                                    class="datepicker-here form-control digits" data-language="en"
                                                    data-position="top right">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="promotional_end">{{ __('Promotion Ends') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="border:1px solid black;"><i
                                                        class="fa fa-calendar"></i></span><input type="date"
                                                    name="promotional_end" id="promotional_end"
                                                    class="datepicker-here form-control digits" data-language="en"
                                                    data-position="top right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <button class="btn btn-primary" id="submit-btn" type="submit">Submit
                                                Product</button>
                                        </div>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin/assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('admin/assets/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
    <script src="{{ asset('admin/plugins/taginputs/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    {{-- <script src="{{ asset('inventory/assets/js/select2/select2-custom.js') }}"></script> --}}
    <script>
        $('.js-example-basic-single').select2();
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $("#get_code").click(function() {
            $.get('generate/product-code', function(data) {
                $("input[name='product_code']").empty().val(data);
            });
        })
        var oTable = $("#basic-1").DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "{{ __('admin_local.No size available in table') }}",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Show _MENU_ entries",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });

        var form_url = "{{ route('admin.product.category.store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this size data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
    </script>
    <script src="{{ asset('admin/custom/product/product.js') }}"></script>
    {{-- <script src="{{ asset('inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
