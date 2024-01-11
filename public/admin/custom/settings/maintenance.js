$('#turn_on_btn').click(function () {
    var maintenance_code = Math.floor(100000 + Math.random() * 900000) + '-' + Math.floor(100000 + Math.random() * 900000) + '-' + Math.floor(100000 + Math.random() * 900000) + '-' + Math.floor(100000 + Math.random() * 900000);
    $('#turn_on_form #secret_code').val(maintenance_code);
});


$('#turn_on_form').on("submit", function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after + '....');
    $('button[type=submit]', this).addClass('disabled');
    swal({
        title: confirm_swal_title,
        text: confirm_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "post",
                url: form_url_on,
                data: $(this).serialize(),
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        $('#turn_on_form .err-mgs').each(function(id,val){
                            $(this).prev('input').removeClass('border-danger is-invalid')
                            $(this).prev('textarea').removeClass('border-danger is-invalid')
                            $(this).empty();
                        })
                        window.location.reload();
                    });
                },
                error: function (err) {
                    $('button[type=submit]', '#turn_on_form').html('Submit');
                    $('button[type=submit]', '#turn_on_form').removeClass('disabled');
                    $('#turn_on_form .err-mgs').each(function (id, val) {
                        $(this).prev('input').removeClass('border-danger is-invalid')
                        $(this).prev('textarea').removeClass('border-danger is-invalid')
                        $(this).empty();
                    })
                    $.each(err.responseJSON.errors, function (idx, val) {
                        $('#turn_on_form #' + idx).addClass('border-danger is-invalid')
                        $('#turn_on_form #' + idx).next('.err-mgs').empty().append(val);
                    })
                }
            });

        } else {
            swal(confirm_swal_cancel_text).then(function () {
                $('button[type=submit]', '#turn_on_form').html(submit_btn_before);
                $('button[type=submit]', '#turn_on_form').removeClass('disabled');
            });
        }
    })
    // $.ajax({
    //     type: 'POST',
    //     url: 'update-password',
    //     data: $(this).serialize(),
    //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    //     dataType: 'JSON',
    //     success: function (data) {
    //         $('button[type=submit]', '#turn_on_form').html(submit_btn_before);
    //         $('button[type=submit]', '#turn_on_form').removeClass('disabled');
    //         swal({
    //             icon: "success",
    //             title: "Congratulations !",
    //             text: 'Password changed successfully',
    //             confirmButtonText: "Ok",
    //         }).then(() => {
    //             $("#turn_on_form").trigger("reset");
    //         })
    //     },
    //     error: function (err) {
    //         $('button[type=submit]', '#turn_on_form').html(submit_btn_before);
    //         $('button[type=submit]', '#turn_on_form').removeClass('disabled');
    //         var err_message = err.responseJSON.message.split("(");
    //         swal({
    //             icon: "warning",
    //             title: "Warning !",
    //             text: err_message[0],
    //             confirmButtonText: "Ok",
    //         });
    //     }
    // })
});


