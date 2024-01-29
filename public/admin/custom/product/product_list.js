function printDiv() 
{
    var printContents = document.getElementById('DivIdToPrint').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
//view products
function productDetails(x){
    if(x=='more'){
        $('#read_more_id').addClass('d-none');
        $('#read_less_id').removeClass('d-none');
    }else{
        $('#read_less_id').addClass('d-none');
        $('#read_more_id').removeClass('d-none');
    }
}
$(document).on('click','#basic-1 #product_row',function(){ 
    let product_id = $(this).closest('tr').data('id');
    // alert(product_id);
    $.ajax({
        type: "get",
        url: 'product/'+product_id,
        success: function (data) {
            $('#slider_body').empty();
            $('#warehouse_details').empty();
            $('#variant_details').empty();
            let product = data.product;
            if(product.image!=''){
                let image = product.image.split(',');
                let cursor_image = '';
                $.each(image,function(imgid,img){
                    cursor_image = cursor_image + `<div class="item"><img src="/${img}" alt=""></div>`;
                })
               
                $('#slider_body').empty().append(`<div class="owl-carousel owl-theme" id="owl-carousel-13">${cursor_image}</div>`);
    
                $("#owl-carousel-13").owlCarousel({
                    items: image.length,
                    loop: true,
                    margin: 10,
                    autoplay: image.length>1?true:false,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    nav: false,
                    navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                    responsive: {
                        320: {
                        items: 1,
                        mergeFit: true,
                        },
                    
                    },
                });
            }else{
                $('#slider_body').empty().append(`<div class="text-center">No File</div>`);
            }
            
            let read_more = `onclick="productDetails('more')"`;
            let read_less = `onclick="productDetails('less')"`;
            $('#product_details').empty().append(`
                <h4 class="my-3">Product Details</h4>
                <table class="table table-bordered">
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Name</th>
                        <td class="py-1">${product.name}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Code</th>
                        <td class="py-1">${product.code}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Type</th>
                        <td class="py-1">${product.type}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Barcode </th>
                        <td class="py-1">${product.barcode_symbology}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Brand</th>
                        <td class="py-1">${product.brand?product.brand.brand_name:'N/A'}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Category</th>
                        <td class="py-1">${product.category?product.category.category_name:'N/A'}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Unit</th>
                        <td class="py-1">${product.unit?product.unit.unit_code:'N/A'}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Unit Size</th>
                        <td class="py-1">${product.unit_size}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Cartoon Size</th>
                        <td class="py-1">${product.cartoon_size}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Quantity</th>
                        <td class="py-1">${product.qty?product.qty:0}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Cost</th>
                        <td class="py-1">${product.cost?product.cost:0}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Price</th>
                        <td class="py-1">${product.price?product.price:0} /-</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Alert Quantity</th>
                        <td class="py-1">${product.alert_quantity?product.alert_quantity:0}</td>
                    </tr>
                    <tr>
                        <th style="width:30%;background-color:azure;" class="py-1">Details</th>
                        <td class="py-1">${product.product_details?(product.product_details.length>40?"<div id='read_more_id' class=''>"+product.product_details.substring(0,40)+"<a style='color:red;cursor:pointer' "+read_more+">...Read More</a></div><div id='read_less_id' class='d-none'>"+product.product_details+"<a "+read_less+" style='color:red;cursor:pointer'>...Read Less</a></div>":product.product_details):'N/A'}</td>
                    </tr>
                </table>
            `);
            if(product.is_diffPrice==1){ 
                let war_price = ``;
                $.each(product.warehouse_price,function(pid,pval){
                    war_price = war_price + `<tr><td>${pval.warehouse_name}</td><td>${pval.quantity}</td><td>${pval.price}/-</td></tr>`;
                });
                $('#warehouse_details').empty().append(`
                    <h5 class="my-3 text-center">Warehouse Prices</h5>
                    <table class="table table-bordered">
                        <tr style="background-color:azure;">
                            <th style="width:40%">Warehouse</th>
                            <th>Stock</th>
                            <th>Price</th>
                        </tr>
                        ${war_price}
                    </table>
                `);
            }

            if(product.is_variant==1){
                // let var_array = product.variant_option.split('|');
                let var_option = ``;
                $.each(product.product_variant,function(idv,variant){
                    var_option = var_option + `<tr><td>${variant.item_code.toUpperCase()}</td><td>${variant.additional_cost?variant.additional_cost:0} /-</td><td>${variant.additional_price?variant.additional_price:0} /-</td><td>${variant.qty?variant.qty:0}</td></tr>`;
                });

                $('#variant_details').empty().append(`
                    <h5 class="my-3 text-center">Variant Details</h5>
                    <table class="table table-bordered">
                        <tr style="background-color:azure;">
                            <th>Variant Code</th>
                            <th>Additional Cost</th>
                            <th>Additional Price</th>
                            <th>Additional Quantity</th>
                        </tr>
                        ${var_option}
                    </table>
                `);
            }
            
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
})

//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    var tblrow = $(this).closest('tr');
    swal({
        title: delete_swal_title,
        text: delete_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => { 
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'product/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (rdata) {
                    swal({
                        icon: "success",
                        title: rdata.title,
                        text: rdata.text,
                        confirmButtonText: rdata.confirmButtonText,
                    }).then(function () {
                        tblrow.remove();
                    });
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
           
        } else {
            swal(delete_swal_cancel_text);
        }
    })
});

