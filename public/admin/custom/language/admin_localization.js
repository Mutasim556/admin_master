$(document).on('click','#edit_button',function(){
    let Skey = $(this).data('key');
    let Svalue = $(this).data('value');
    let SfileName = $(this).data('filename');
    let SlangCode = $(this).data('lang_code');
    $('#edit_string_form').trigger('reset');
    $('#edit_string_form #lang_code').val(SlangCode);
    $('#edit_string_form #file_name').val(SfileName);
    $('#edit_string_form #string').val(Skey);
    $('#edit_string_form #translation').val(Svalue);
    $('#edit_string_form #trid').val($(this).closest('tr').attr('id'));
});

//update data
$('#edit_string_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = $('#edit_string_form #trid').val();
    $.ajax({
        type: "post",
        url: 'update-admin-localization-string',
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
            $('button[type=submit]', '#edit_string_form').html('Submit');
            $('button[type=submit]', '#edit_string_form').removeClass('disabled');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'Localization data updated suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('td:nth-child(3) #edit_button','#'+trid).data('value',data.value)
                $('td:nth-child(2)','#'+trid).html(data.value);

                $('#edit_string_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('button[type=button]', '#edit_string_form').click();
            });
        },
        error: function (err) {
            // console.log(err);
            $('button[type=submit]', '#edit_string_form').html('Submit');
            $('button[type=submit]', '#edit_string_form').removeClass('disabled');
            $('#edit_string_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_string_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_string_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});
