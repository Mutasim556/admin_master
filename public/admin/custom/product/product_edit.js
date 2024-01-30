var firstVariantRow = [];
var combinedVariantRow = [];
$(document).ready(function () {
    // $('.type-variant').tagsInput();
    $('#combo').hide();
    $('#attatchment_div').hide();
    if($('#variant').is(":checked")){
        $('#variant_option_row').show();
        $('#variant_option_table').show();
        $('#batch_expire_date_row').hide(300);
    }else{
        $('#variant_option_row').hide();
        $('#variant_option_table').hide();
    }
    if($('#warehouse_price').is(":checked")){
        $('#warehouse_price_table').show();
    }else{
        $('#warehouse_price_table').hide();
    }
    if($('#add_promotional_price').is(":checked")){
        $('#add_promotional_price_row').show();
    }else{
        $('#add_promotional_price_row').hide();
    }
    
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
function product_type_standard(){
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
    $('#imei_row').show(300).find('div input').prop('checked', false);
}
function product_type_combo(){
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
}
function product_type_digital(){
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
}
function product_type_service(){
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
$('#product_type').change(function () {
    let product_type = $(this).val();
    if (product_type == 'standard') {
        product_type_standard();
    } else if (product_type == 'combo') {
        product_type_combo();
        // $('#warehouse_price_row').show(300).find('div input').prop('checked',false);
        // $('#variant_option_table').hide(300);
        // $('#brand_div').fadeOut(300);
        // $('#category_div').fadeOut(300);
    } else if (product_type == 'digital') {
        product_type_digital();
    } else if (product_type == 'service') {
        product_type_service();
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
        $('#variant_option_row #variant_option').val('');
        $('#variant_option_row #variant_value_label').empty().append(`<label for="variant_value" >Value *</label>
        <input type="text" class="form-control variant_value" name="variant_value[]" id="variant_value" data-role="tagsinput">
            <span class="text-danger err-mgs"></span>`);
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
   

    $('#variant_option_row').next('div').append('<div class="row variant_option_row"><div class="form-group col-md-5"><label for="variant_option">Option *</label><input type="text" class="form-control" name="variant_option[]" id="variant_option"> </div><div class="form-group col-md-5"> <label for="variant_value">Value *</label><input type="text" class="form-control variant_value" name="variant_value[]" id="variant_value" data-role="tagsinput"></div><div class="form-group col-md-2" style="line-height: 100px;"><button type="button" class="btn btn-danger py-2 px-2" id="remove_varient_div"><i class="fa fa-trash"></i></button></div></div>');
    

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
        $('#variant_option_table table tbody').append('<tr><td>' + expected_value + '</td><td><input type="text" name="variant_item_code[]" class="form-control" value="' + expected_value + '" readonly></td> <td><input type="text" name="variant_additional_cost[]" class="form-control" value=""></td><td class="text-center"><input type="text" class="form-control"  name="variant_additional_price[]"></td></tr>'); 
    });

})

$(document).on('click','#remove_varient_div',function(){
    $(this).closest('.variant_option_row').hide(300,function(){
        $(this).remove();
    });
})