var pid_array = [];
var pname_array = [];
var pprice_array = [];
var pcode_array = [];
var products = [];
var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
    var matches, substringRegex;
    matches = [];
    substrRegex = new RegExp(q, 'i');
    $.each(strs, function(i, str) {
        if (substrRegex.test(str)) {
        matches.push(str);
        }
    });
    cb(matches);
    };
};

$('#warehouse').change(function(){
    if($(this).val()){
        $.ajax({
            type: 'GET',
            url: '/admin/product/warehouse/product/'+$(this).val(),
            dataType: 'JSON',
            success: function (data) {
                products = [];
                pid_array = [];
                pname_array = [];
                pprice_array = [];
                pcode_array = [];
                $('#combo_product_table tbody').empty();
                $('#add_combo_product').val(null);
                $.each(data.product_name,function(id,val){
                    products.push(`${val}`);
                });
                $("#the-basics .form-control").typeahead("destroy");
                $('#the-basics .form-control').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'products',
                    source: substringMatcher(products)
                });
            },
            error: function(err){
    
            }
        })
    }
});



$('#add_combo_product').on('keypress',function(e){
    if(e.which==13){
        e.preventDefault();
        let pid = $('#add_combo_product').val().split("@")[0];
        let pname = $('#add_combo_product').val().split("@")[1];
        // pid_array.push(pid);
        
        if(jQuery.inArray(pid, pid_array) != -1){
            swal({
                icon: "warning",
                title: "Warning !",
                text: 'Duplicate product not allowed',
                confirmButtonText: "Ok",
            }).then(function(){
                $('#add_combo_product').val(null);
                $('#add_combo_product')[0].focus(); 
            });
        }else{
            if($('#add_combo_product').val()==''){
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: 'Please select product',
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('#add_combo_product').val(null);
                    $('#add_combo_product')[0].focus(); 
                });
            }else{
                if(jQuery.inArray($('#add_combo_product').val(), products) != -1){
                    pid_array.push(pid);

                    $.ajax({
                        type: "get",
                        url: '/admin/product/get/product/' + pid +'/'+$('#warehouse').val(),
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            // console.log(pcode_array);
                            pname_array.push(data.product.name);
                            pprice_array.push(data.product.price);
                            pcode_array.push(data.product.code);
                            $('#combo_product_table tbody').append(`
                                <tr data-id="${data.product.id}" >
                                    <td>${data.product.name}<input type="hidden" name="product_id[]" value="${data.product.id}"></td>
                                    <td>${data.product.code}</td>
                                    <td>${data.product.price} BDT</td>
                                    <td><input type="number" class="form-control" min="0" max="${data.warehouse_price.quantity}" name="product_quantity[]" value="0" required></td>
                                    <td class="text-center">
                                    <select class="form-control" name="action[]">
                                        <option value="-">Subtraction</option>
                                        <option value="+">Addition</option>
                                    </select>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm px-2 py-2" id="delete_combo_button"><i class="fa fa-trash" style="font-size: 17px"></ i></button></td>
                                </tr>
                            `);
                        },
                        error: function (err) {
                            var err_message = err.responseJSON.message.split("(");
                            swal({
                                icon: "warning",
                                title: "Warning !",
                                text: err_message[0],
                                confirmButtonText: "Ok",
                            });
                        }
                    });
                    
                    $(this).val('');
                }else{
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: 'Invalid Product',
                        confirmButtonText: "Ok",
                    }).then(function(){
                        $('#add_combo_product').val('');
                        $('#add_combo_product')[0].focus(); 
                    });
                }
                
            }
           
        }
    }
})

$(document).on("click",'#delete_combo_button',function(){
    pid_array.splice($.inArray($(this).closest('tr').data('id').toString(), pid_array), 1);
    pname_array.splice($.inArray($(this).closest('tr').data('id').toString(), pname_array), 1);
    pprice_array.splice($.inArray($(this).closest('tr').data('id').toString(), pprice_array), 1);
    pcode_array.splice($.inArray($(this).closest('tr').data('id').toString(), pcode_array), 1);
    $(this).closest('tr').remove();
})



// var products = [{!! "'" . implode ( "', '", $product_name ) . "'" !!}];




$('#add_adjustment_form').on('submit',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    if($('#combo_product_table tbody').find('tr').length>0){
        $('button[type=submit]', this).html(submit_btn_after+'...');
        $.ajax({
            type: 'POST',
            url: form_url,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                swal({
                    icon: "success",
                    title: data.title,
                    text: data.text,
                    confirmButtonText: data.confirmButtonText,
                }).then(function(){
                    $('button[type=submit]', '#add_adjustment_form').html(submit_btn_before);
                    $("#warehouse").val('').trigger('change');
                    $('#combo_product_table tbody').empty();
                    $('#add_adjustment_form').trigger('reset');
                })
            },
            error: function(err){

            }
        })
    }else{
        
        swal({
            icon: "warning",
            title: "Warning !",
            text: 'Select Product First',
            confirmButtonText: "Ok",
        })
    }
});