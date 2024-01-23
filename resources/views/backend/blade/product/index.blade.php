@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Products') }}
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
                    <h3>{{ __('admin_local.Products') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Product') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Product List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- add unit modal start --}}
    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Product List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['product-store']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <a class="btn btn-success" href="{{ route('admin.product.create') }}" >+ {{ __('admin_local.Add Product') }}</a>
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Image') }}</th>
                                        <th>{{ __('admin_local.Name') }}</th>
                                        <th>{{ __('admin_local.Code') }}</th>
                                        <th>{{ __('admin_local.Brand') }}</th>
                                        <th>{{ __('admin_local.Category') }}</th>
                                        <th>{{ __('admin_local.Quantity') }}</th>
                                        <th>{{ __('admin_local.Vairant') }}</th>
                                        <th>{{ __('admin_local.Price') }}</th>
                                        <th>{{ __('admin_local.Cost') }}</th>
                                        <th>{{ __('admin_local.Cartoon') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><img src="{{ $product->image?asset(explode(',',$product->image)[0]):'' }}" style="height:50px" alt=""></td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->brand->brand_name }}</td>
                                            <td>{{ $product->category->category_name }}</td>
                                            <td>{{ $product->qty==null?0:$product->qty }}</td>
                                            <td>{!! $product->is_variant==0?'<span class="badge badge-danger">No</span>':'<span style="cursor:pointer;" class="badge badge-success">Yes</span>' !!}</td>
                                            <td>{{ $product->price==null?0:$product->price }}</td>
                                            <td>{{ $product->cost==null?0:$product->cost }}</td>
                                            <td>{{ $product->cartoon_size==null?0:$product->cartoon_size }}</td>
                                            <td></td>
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
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>

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
            dom: 'Blfrtip',
            select: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'excel', 'pdf','print'
            ],
            columnDefs: [{
                width: 20,
                targets: 0
            }, {
                width: 250,
                targets: 1
            }, {
                width: 60,
                targets: 3
            },{
                width: 60,
                targets: 5
            },{
                width: 60,
                targets: 8
            }
            ],
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
