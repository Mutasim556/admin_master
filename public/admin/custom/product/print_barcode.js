var pid_array = [];
var pname_array = [];
var pprice_array = [];
var pcode_array = [];
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
                        url: '/admin/product/get-variant/' + pid,
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            console.log(pcode_array);
                            pname_array.push(data.product.name);
                            pprice_array.push(data.product.price);
                            pcode_array.push(data.product.code);
                            $('#combo_product_table tbody').append(`
                                <tr data-id="${data.product.id}" >
                                    <td style="width:50%">${data.product.name}<input type="hidden" name="product_id[]" value="${data.product.id}"></td>
                                    <td>${data.product.code}</td>
                                    <td>${data.product.price} BDT</td>
                                    <td class="text-center"><button type="button"
                                            class="btn btn-danger btn-sm px-2 py-2" id="delete_combo_button"><i
                                                class="fa fa-trash"
                                                style="font-size: 17px"></i></button></td>
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


$('#print_barcode_form').on('submit',function(e){
    e.preventDefault();
    if($('#combo_product_table tbody').find('tr').length>0){
        $('#print-barcode-modal .modal-body .row').empty();
        $.ajax({
            type: 'POST',
            url: '/admin/product/generate/barcode',
            data: $(this).serialize(),
            dataType: 'JSON',
            
            success: function (data) {
                
                $.each(data.barcode_details,function(id,value){
                    let barcode_style = ``;
                    if(value.paper_size==18){
                        barcode_style = `style="width:150px;height:70px;"`;
                    }else if(value.paper_size==24){
                        barcode_style = `style="width:164px;height:80px;"`;
                    }else if(value.paper_size==36){
                        barcode_style = `style="width:164px;height:90px"`;
                    }
                    
                    $('#print-barcode-modal .modal-body .row').append(`<div style="text-align:center;margin-bottom:20px;width:33%;float:left;"><span>${value.name_show==1?value.name:''}</span><br><img ${barcode_style} src="data:image/png;base64,${value.barcode}"><br><span>${value.code_show==1?value.code:''}</span><br><span>${value.price_show==1?'Price : '+value.price+' BDT':''}</span><div>`);
                    printDiv();
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

function printDiv() 
{
    // var printContents = document.getElementById('printArea').innerHTML;
    // var originalContents = document.body.innerHTML;

    // document.body.innerHTML = printContents;

    // window.print();

    // document.body.innerHTML = originalContents;

    var divToPrint=document.getElementById('printArea');
    var newWin=window.open('','Print-Window');
    newWin.document.open();
    newWin.document.write('<style type="text/css">@media print { #modal_header { display: none } #print-btn { display: none } #close-btn { display: none } } table.barcodelist { page-break-inside:auto } table.barcodelist tr { page-break-inside:avoid; page-break-after:auto }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
    newWin.document.close();
    setTimeout(function(){newWin.close();},10);
}