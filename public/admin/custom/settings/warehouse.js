//add form data
$('#add_warehouse_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after);
    $('button[type=submit]', this).addClass('disabled');
    $.ajax({
        type: "POST",
        url: form_url,
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (rdata) {
            $('button[type=submit]', '#add_warehouse_form').html(submit_btn_before);
            $('button[type=submit]', '#add_warehouse_form').removeClass('disabled');
            let data = rdata.warehouse;
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.title,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                let status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if(rdata.hasEditPermission){
                    status_btn = `<span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input
                    data-status="${data.status==0?1:0}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" ${data.status==1?'checked':''} />`;
                }
                if(rdata.hasAnyPermission){
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if(rdata.hasEditPermission){
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-warehouse-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if(rdata.hasDeletePermission){
                        action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }
                $('#basic-1 tbody').append(`<tr id="trid-${data.id}" data-id="${data.id}"><td>${data.name}</td><td>${data.phone}</td><td>${data.email?data.email:'N/A'}</td><td>${data.address?data.address:'N/A'}</td><td></td><td></td>
                <td class="text-center">${status_btn}
                </td><td>  ${action_option}</td></tr>`);

                new Switchery($('#trid-'+data.id).find('input')[0], $('#trid-'+data.id).find('input').data());
                $('#add_warehouse_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_warehouse_form').trigger('reset');
                $('button[type=button]','#add_warehouse_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_warehouse_form').html(submit_btn_before);
            $('button[type=submit]', '#add_warehouse_form').removeClass('disabled');
            $('#add_warehouse_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_warehouse_form #'+idx).addClass('border-danger is-invalid')
                $('#add_warehouse_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    
    let warehouse = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'warehouse/' + warehouse + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_warehouse_form').trigger('reset');
            $('#edit_warehouse_form #warehouse_id').val(data.id);
            $('#edit_warehouse_form #warehouse_name').val(data.name);
            $('#edit_warehouse_form #warehouse_phone').val(data.phone);
            $('#edit_warehouse_form #warehouse_email').val(data.email);
            $('#edit_warehouse_form #warehouse_address').val(data.address);
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

//update data
$('#edit_warehouse_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'...');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#warehouse_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'warehouse/' + $('#warehouse_id',this).val(),
        data: formData,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        cache: false,
        processData: false,
        success: function (rdata) {
            let data = rdata.warehouse;
            $('button[type=submit]', '#edit_warehouse_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_warehouse_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.name);
            $('td:nth-child(2)',trid).html(data.phone);
            $('td:nth-child(3)',trid).html(data.email?data.email:'N/A');
            $('td:nth-child(4)',trid).html(data.address?data.address:'N/A');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function () {
                $('#edit_warehouse_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_warehouse_form').trigger('reset');
                $('button[type=button]', '#edit_warehouse_form').click();

            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_warehouse_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_warehouse_form').removeClass('disabled');
            $('#edit_warehouse_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_warehouse_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_warehouse_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var u_td = $(this).parent();
    u_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'warehouse/update/status/'+update_id+"/"+status,
        success: function (data) {
            u_td.empty().append(`<span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input data-status="${data.status==0?1:0}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.status==1?'checked':''} />`);
            new Switchery(u_td.find('input')[0], u_td.find('input').data());
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


//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
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
                url: 'warehouse/'+delete_id,
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
                        $('#trid-'+delete_id).hide();
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