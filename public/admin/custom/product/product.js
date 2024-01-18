var firstVariantRow = [];
var combinedVariantRow = [];
$(document).ready(function () {
    // $('.type-variant').tagsInput();
    $('#combo').hide();
    $('#attatchment_div').hide();
    $('#variant_option_row').hide();
    $('#variant_option_table').hide();
    $('#warehouse_price_table').hide();
    $('#add_promotional_price_row').hide();
    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });
    $("form").validate({
        rules: {
            field: {
              required: true,
              date: true,
              dateFormat: true
            }
          }
    })
})

$('#add_product_form select[name="product_unit"]').change(function () {
    $.ajax({
        type: "GET",
        url: 'get-unit/' + $(this).val(),
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            $('#sale_unit').empty().append('<option value="' + data.unit_id + '">' + data.unit_name + '</option>');
            $('#purchase_unit').empty().append('<option value="' + data.unit_id + '">' + data.unit_name + '</option>');
            $('#sale_unit').trigger('change');
            $('#purchase_unit').trigger('change');
        },
        error: function () {

        }
    })
})

$('#product_type').change(function () {
    let product_type = $(this).val();
    if (product_type == 'standard') {
        $('#visible_unit').fadeIn(300);
        $('#product_cost_div').fadeIn(500);
        $('#alert_quantity_div').fadeIn(500);
        $('#brand_div').fadeIn(500);
        $('#category_div').fadeIn(500);
        $('#combo').fadeOut(300);
        $('#attatchment_div').fadeOut(300);

        $('#variant_row').show(300).find('div input').prop('checked', false);
        $('#warehouse_price_row').show(300).find('div input').prop('checked', false);
        $('#batch_expire_date_row').show(300).find('div input').prop('checked', false);

    } else if (product_type == 'combo') {
        $('#combo').fadeIn(500);
        $('#visible_unit').fadeOut(300);
        $('#attatchment_div').fadeOut(300);
        $('#product_cost_div').fadeOut(300);
        $('#alert_quantity_div').fadeOut(300);

        $('#variant_row').hide(300);
        $('#variant_option_row').hide(300);
        $('#variant_option_table').hide(300);

        $('#warehouse_price_row').hide(300);
        $('#warehouse_price_table').hide(300);

        $('#batch_expire_date_row').show(300).find('div input').prop('checked', false);
        $('#imei_row').show(300).find('div input').prop('checked', false);
        // $('#warehouse_price_row').show(300).find('div input').prop('checked',false);
        // $('#variant_option_table').hide(300);
        // $('#brand_div').fadeOut(300);
        // $('#category_div').fadeOut(300);
    } else if (product_type == 'digital') {
        $('#attatchment_div').fadeIn(500);
        $('#brand_div').fadeIn(500);
        $('#category_div').fadeIn(500);
        $('#combo').fadeOut(300);
        $('#visible_unit').fadeOut(300);
        $('#product_cost_div').fadeOut(300);
        $('#alert_quantity_div').fadeOut(300);

        $('#variant_row').hide(300);
        $('#variant_option_row').hide(300);
        $('#variant_option_table').hide(300);

        $('#warehouse_price_row').hide(300);
        $('#warehouse_price_table').hide(300);

        $('#batch_expire_date_row').hide(300);
        $('#imei_row').show(300).find('div input').prop('checked', false);
    } else if (product_type == 'service') {
        $('#brand_div').fadeIn(500);
        $('#category_div').fadeIn(500);
        $('#visible_unit').fadeOut(300);
        $('#attatchment_div').fadeOut(300);
        $('#combo').fadeOut(300);
        $('#product_cost_div').fadeOut(300);
        $('#alert_quantity_div').fadeOut(300);

        $('#variant_row').hide(300).find('div input').prop('checked', false);
        $('#warehouse_price_row').hide(300).find('div input').prop('checked', false);
        $('#batch_expire_date_row').hide(300).find('div input').prop('checked', false);
        $('#imei_row').hide(300).find('div input').prop('checked', false);
    }
});

$('#batch_expire_date').change(function () {
    if ($(this).is(':checked')) {
        if ($('#product_type').val() != 'combo') {
            $('#variant_row').hide(300);
            $('#variant_option_row').hide(300);
            $('.append_variant_option_row').hide(300);
        }
    } else {
        if ($('#product_type').val() != 'combo') {
            $('#variant_row').show(300);
        }
    }
})

$('#variant').change(function () {
    if ($(this).is(':checked')) {
        $('#batch_expire_date_row').hide(300);
        $('#variant_option_row').show(300);
        $('.append_variant_option_row').show(300);
        $('#variant_option_table').show(300);
        $('#variant_option_table table tbody').empty();
    } else {
        $('#variant_option_row').hide(300);
        $('#batch_expire_date_row').show(300);
        $('.variant_option_row').hide(300);
        $('#variant_option_table').hide(300);
    }
})

$('#warehouse_price').change(function () {
    if ($(this).is(':checked')) {
        $('#warehouse_price_table').show(300);
    } else {
        $('#warehouse_price_table').hide(300);
    }
})

$('#add_promotional_price').change(function () {
    if ($(this).is(':checked')) {
        $('#add_promotional_price_row').show(300);
    } else {
        $('#add_promotional_price_row').hide(300);
    }
})

$('#add_new_variant').click(function () {
    // $('<div class="row append_variant_option_row"><div class="form-group col-md-5"><label for="variant_option">Option</label><input type="text" class="form-control" name="variant_option[]" id="variant_option" > </div><div class="form-group col-md-5"> <label for="variant_value">Value</label><input type="text" class="form-control variant_value" name="variant_value[]" id="variant_value" data-role="tagsinput"></div></div>').insertAfter("div").hide().show(300);

    $('#variant_option_row').next('div').append(`<div class="row variant_option_row">
    <div class="form-group col-md-5">
    <label for="variant_option">Option *</label>
    <input type="text" class="form-control" name="variant_option[]" id="variant_option" required> </div>
    <span class="text-danger err-mgs"></span>
    <div class="form-group col-md-5">
    <label for="variant_value">Value *</label>
    <input type="text" class="form-control variant_value" name="variant_value[]" id="variant_value" data-role="tagsinput" required>
    </div>
    <div class="form-group col-md-2" style="line-height: 100px;"><button type="button" class="btn btn-danger py-2 px-2" id="remove_varient_div"><i class="fa fa-trash"></i></button></div></div>`);
    

    $(".variant_value").tagsinput();
})


$(document).on('change', '.variant_option_row .variant_value', function (e) {
    // alert(e.keyCode)
    e.preventDefault();
    combinedVariantRow = [];
    firstVariantRow = [];
    firstVariantRow.splice(0, firstVariantRow.length);
    let product_code = $('#product_code').val();
    $('.variant_option_row').each(function (id, v) {
        var second_var_val = $(this).find('.variant_value').val().split(',');
        if (firstVariantRow.length > 0) {
            $.each(firstVariantRow, function (id, val) {
                $.each(second_var_val, function (id2, val2) {
                    if (val != '' && val2 != '') {
                        combinedVariantRow = combinedVariantRow.concat(val + val2 + "/".toLowerCase())
                    }
                    else if (val == '' && val2 != '') {
                        combinedVariantRow = combinedVariantRow.concat(val2 + "/".toLowerCase())
                    } else if (val != '' && val2 == '') {
                        combinedVariantRow = combinedVariantRow.concat(val.toLowerCase())
                    }
                })
            })
        } else {
            $.each(second_var_val, function (id, val) {
                if (val != '') {
                    combinedVariantRow = combinedVariantRow.concat(val + "/".toLowerCase())
                }
            })
        }
        firstVariantRow = combinedVariantRow;
        combinedVariantRow = [];
    });
    $('#variant_option_table table tbody').empty();
    $.each(firstVariantRow, function (rid, value) {
        let split_value = value.split('/');
        let expected_value = split_value.slice(0, split_value.length-1).join('/') + '-'+product_code + split_value[split_value.length-1];
        $('#variant_option_table table tbody').append('<tr><td>' + expected_value + '</td><td><input type="text" name="variant_item_code[]" class="form-control" value="' + expected_value + '" disabled></td> <td><input type="text" name="variant_additional_cost[]" class="form-control" value=""></td><td class="text-center"><input type="text" class="form-control"  name="variant_additional_price[]"></td></tr>');
    });

})

$(document).on('click','#remove_varient_div',function(){
    $(this).closest('.variant_option_row').hide(300,function(){
        $(this).remove();
    });
})
//dropzone

Dropzone.autoDiscover = false;
let token = $('meta[name="csrf-token"]').attr('content');
var myDropzone = new Dropzone("div#dropzoneDragArea", {
    addRemoveLinks: true,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    dictRemoveFile: 'Remove',
    maxFilesize: 12,
    paramName: 'image',
    clickable: true,
    method: 'POST',
    url: form_url,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    renameFile: function (file) {
        var dt = new Date();
        var time = dt.getTime();
        var file_ext = file.name.split('.');
        return 'PRODUCT-'+time+'.'+file_ext[file_ext.length-1];
    },
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    init: function (file) {
        var myDropzone = this;
        $('#add_product_form').on("submit", function (e) {
            e.preventDefault();
            // e.stopPropagation();
            // console.log(myDropzone.getQueuedFiles().length);
            if (myDropzone.getQueuedFiles().length > 0)
            {                        
                myDropzone.processQueue();  
            } else {    
                    let fData =  new FormData(this);
                    fData.append('_token',$('#csrf_token').val());            
                    $.ajax({
                        type: 'POST',
                        url: form_url,
                        data: fData,
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            console.log(data);
                        },
                        error: function (err) {
                            // var err_message = err.responseJSON.message.split("(");
                            // swal({
                            //     icon: "warning",
                            //     title: "Warning !",
                            //     text: err_message[0],
                            //     confirmButtonText: "Ok",
                            // });
                            $('#add_product_form').find(" :input").each(function(){
                                $(this).removeClass('border-danger is-invalid')
                            })
                            $('#add_product_form .text-danger').each(function(id,val){
                                $(this).empty();
                            })
                           
                            $.each(err.responseJSON.errors,function(idx,val){
                                let splitVal = idx.split('.');
                                if(splitVal.length>1 ){
                                    if(splitVal[0]='variant_option'){
                                        $('#add_product_form #variant_error').removeClass('d-none');
                                    }else if(splitVal[0]='variant_value'){
                                        $('#add_product_form #variant_error').removeClass('d-none');
                                    }else{
                                        $('#add_product_form #variant_error').addClass('d-none');
                                    }
                                }else{
                                    $('#add_product_form #variant_error').addClass('d-none');
                                }
                                $('#add_product_form #'+idx).addClass('border-danger is-invalid')
                                $('#add_product_form .err-mgs-'+idx).empty().append(val);
                            })
                        },
                    });
            }   
        });
        this.on('sending', function (file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $("#add_product_form").serializeArray();
            $.each(data, function (key, el) {
                formData.append(el.name, el.value);
            });
        });
    },
    error: function (file, err) {
        this.removeAllFiles(true);

        $('#add_product_form').find(" :input").each(function(){
            $(this).removeClass('border-danger is-invalid')
        })
        $('#add_product_form .text-danger').each(function(id,val){
            $(this).empty();
        })
       
        $.each(err.errors,function(idx,val){
            $('#add_product_form #'+idx).addClass('border-danger is-invalid')
            $('#add_product_form .err-mgs-'+idx).empty().append(val);
        })
    },
    successmultiple: function (file, response) {
        // console.log(response);
        this.removeAllFiles(true);
    },
    completemultiple: function (file, response) {
        // console.log(file, response, "completemultiple");
    },
    reset: function () {
        // console.log("resetFiles");
        // this.removeAllFiles(true);
    }
});
