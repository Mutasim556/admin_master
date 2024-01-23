@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Units') }}
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
                    <h3>{{ __('admin_local.Units') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Product') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Units') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- add unit modal start --}}
    <div class="modal fade" id="add-unit-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('Add Unit') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POST" action="" id="add_unit_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="unit_name"><strong>{{ __('Unit Name') }} *</strong></label>
                                <input type="text" class="form-control" name="unit_name" id="unit_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="unit_code"><strong>{{ __('Unit Code') }} *</strong></label>
                                <input type="text" class="form-control" name="unit_code" id="unit_code">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="base_unit"><strong>{{ __('Base Unit') }} </strong></label>
                                <select class="js-example-basic-single form-control" name="base_unit" id="base_unit">
                                    <option value="">Select Please</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                        </div>
                        <div class="row d-none" id="invisible_div">
                            <div class="col-lg-12 mt-2">
                                <label for="operator"><strong>{{ __('Operator') }} *</strong></label>
                                <input type="text" class="form-control" name="operator" id="operator">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="operation_value"><strong>{{ __('Operation value') }} *</strong></label>
                                <input type="text" class="form-control" name="operation_value" id="operation_value">
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

    <div class="modal fade" id="edit-unit-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('Edit Unit') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form id="edit_unit_form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="unit_id" name="unit_id" value="">
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="unit_name"><strong>{{ __('Unit Name') }} *</strong></label>
                                <input type="text" class="form-control" name="unit_name" id="unit_name">
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="unit_code"><strong>{{ __('Unit Code') }} *</strong></label>
                                <input type="text" class="form-control" name="unit_code" id="unit_code">
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="base_unit"><strong>{{ __('Base Unit') }} </strong></label>
                                <select class="js-example-basic-single1 form-control" name="base_unit" id="base_unit">
                                    <option value="">Select Please</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="invisible_div">
                            <div class="col-lg-12 mt-2">
                                <label for="operator"><strong>{{ __('Operator') }} *</strong></label>
                                <input type="text" class="form-control" name="operator" id="operator">
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="operation_value"><strong>{{ __('Operation value') }} *</strong></label>
                                <input type="text" class="form-control" name="operation_value" id="operation_value">
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
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Unit List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['unit-store']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-unit-modal">+ {{ __('admin_local.Add Unit') }}</button>
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Name') }}</th>
                                        <th>{{ __('admin_local.Code') }}</th>
                                        <th>{{ __('admin_local.Base Unit') }}</th>
                                        <th>{{ __('admin_local.Operator') }}</th>
                                        <th>{{ __('admin_local.Operation Value') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr id="trid-{{ $unit->id }}" data-id="{{ $unit->id }}">
                                            <td>{{ $unit->unit_name }}</td>
                                            <td>{{ $unit->unit_code }}</td>
                                            <td>{{ $unit->base_unit ? $unit->base_unit : 'N/A' }}</td>
                                            <td>{{ $unit->operator ? $unit->operator : '*' }}</td>
                                            <td>{{ $unit->operation_value }}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['unit-update']))
                                                    <span
                                                        class="mx-2">{{ $unit->unit_status == 0 ? 'Inactive' : 'Active' }}</span><input
                                                        data-status="{{ $unit->unit_status == 0 ? 1 : 0 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $unit->unit_status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (hasPermission(['unit-update','unit-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['unit-update']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-unit-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        @if (hasPermission(['unit-delete']))
                                                        <a class="text-danger" id="delete_button"
                                                            style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                                            {{ __('admin_local.Delete') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @else
                                                <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
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
    <script>
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
                width: 20,
                targets: 0
            }, {
                width: 80,
                targets: 1
            }, {
                width: 60,
                targets: 3
            }],
        });

        var form_url = "{{ route('admin.product.unit.store') }}";
        // var getting_permission = `<span>{{ __('admin_local.Getting Permissons') }} ...... <i class="fa fa-spinner fa-spin" ></i></span>`;
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this maintenance data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
    </script>
    <script src="{{ asset('admin/custom/product/unit.js') }}"></script>
@endpush
