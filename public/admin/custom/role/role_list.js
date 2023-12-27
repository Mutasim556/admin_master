//add role
$('#add_role_form').submit(function (e) {
    e.preventDefault();
    $('#add_role_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    
    $.ajax({
        type: "post",
        url: form_url,
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (datam) {

            $('button[type=submit]', '#add_role_form').html('Submit');
            $('button[type=submit]', '#add_role_form').removeClass('disabled');
            let data = datam.role;
            // console.log(data);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'role create suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#add_role_form').trigger('reset');
                $('#add_role_form #permission-switch').prop('checked',true).trigger('click');
                $('button[type=button]', '#add_role_form').click();
                let permission = [];
                $.each(datam.permissions,function(idx,val){
                    permission = permission+'<span class="badge badge-success">'+val.name+'</span>';
                });
                $('#basic-1 tbody').append(`<tr id="tr-${data.id}" data-id="${data.id}">
                    <td>${data.id}</td>
                    <td>${data.name}</td>
                    <td>
                        ${permission.length>0?permission:'<span class="badge badge-danger">no permission</span>'}
                    </td>
                    <td>
                        <button id="edit_button" data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-role-modal" class="btn btn-primary px-2 py-1"><i class="fa fa-pencil-square-o"></i></button>
                        <button id="delete_button" class="btn btn-danger px-2 py-1"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`)
                new Switchery($('#tr-'+data.id).find('input')[0], $('#tr-'+data.id).find('input').data());
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_role_form').html('Submit');
            $('button[type=submit]', '#add_role_form').removeClass('disabled');
            $('#add_role_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_role_form #'+idx).addClass('border-danger is-invalid')
                $('#add_role_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

$(document).on('click','#edit_button',function(){
    let edit_id = $(this).closest('tr').data('id');
    $.ajax({
        method : 'get',
        url : 'role/edit/'+edit_id,
        success :function(data){
            $('#edit_role_form #role_name').val(data.role.name);
            $('#edit_role_form #role_id').val(data.role.id);
            $('#edit_role_form #edit_permission').empty();
            $.each(data.permissions,function(group,permission){
                let permissionList =[];
                $.each(permission,function(idx,item){
                    let check = '';
                    if(data.rolePermissions.includes(item.name)){
                        check = 'checked';
                    }
                    permissionList = permissionList+`<input data-status="" id="permission-switch" type="checkbox" data-toggle="switchery" data-color="green" data-secondary-color="red" data-size="small" value="${item.name}" name="permissions[]" ${check}/>
                    <span class="mx-2">${item.name}</span>`;
                })
                $('#edit_role_form #edit_permission').append(`
                <div class="col-lg-12 mt-4">
                    <label for="user_permission">${group}</label><br>
                    ${permissionList}
                </div>
            `);
            })
            $('#edit_role_form [data-toggle="switchery"]').each(function(idx, obj) {
                new Switchery($(this)[0], $(this).data());
            });
        },
        error : function(err){
            $('button[type=submit]', '#edit_role_form').html('Submit');
            $('button[type=submit]', '#edit_role_form').removeClass('disabled');
            $('#edit_role_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_role_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_role_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

//update data
$('#edit_role_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#tr-'+$('#role_id', this).val();
    $.ajax({
        type: "put",
        url: 'role/update/' + $('#role_id', this).val(),
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#edit_role_form').html('Submit');
            $('button[type=submit]', '#edit_role_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.role.id);
            $('td:nth-child(2)',trid).html(data.role.name);
            let permission = [];
            $.each(data.rolePermissions,function(idx,val){
                permission = permission+'<span class="badge badge-success">'+val+'</span>';
            });

            $('td:nth-child(3)',trid).html(permission.length>0?permission:'<span class="badge badge-danger">no permission</span>');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'role data updated suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#edit_role_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_role_form').trigger('reset');
                $('button[type=button]', '#edit_role_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_role_form').html('Submit');
            $('button[type=submit]', '#edit_role_form').removeClass('disabled');
            $('#edit_role_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_role_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_role_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});


//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this role",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'role/delete/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmTextButton,
                    }).then(function () {
                        $('#tr-'+delete_id).hide(300,function(){$(this).remove()});
                    });
                },
                error: function (err) {
                    swal({
                        icon: err.responseJSON.status,
                        title:  err.responseJSON.title,
                        text:  err.responseJSON.text,
                        confirmButtonText:  err.responseJSON.confirmTextButton,
                    });
                }
            });
           
        } else {
            swal("Delete request canceld successfully");
        }
    })
});

