$(document).on("click",'#view_btn',function(){
    var adjustment_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: '/admin/product/get/adjustment/product/' + adjustment_id,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#view-adjustment-modal table tbody').empty();
            $.each(data,function(id,value){
                $('#view-adjustment-modal table tbody').append(`
                    <tr class="bg-warning text-center">
                        <td style="font-weight:700;color:black;width:30%">${value.name}</td>
                        <td style="font-weight:700;color:black;">${value.code}</td>
                        <td style="font-weight:700;color:black;">${value.adjust_qty}</td>
                        <td style="font-weight:700;color:black;">${value.action}</td>
                    </tr>
                `);
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
});