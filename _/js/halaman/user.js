$(".show-btn-password").click(function() {
  var showBtn = $('.show-btn-password');
  var formPassword = $('#user_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-password d-flex hide-btn');
      $('.password').attr('class', 'fa fa-eye-slash password');
      $('#user_password').attr('type', 'text');
    }else{
      $('.password').attr('class', 'fa fa-eye password');
      $('#user_password').attr('type', 'password');
      showBtn.attr('class', 'input-group-text show-btn-password d-flex');
    }
});

$(".show-btn-repeat").click(function() {
  var showBtn = $('.show-btn-repeat');
  var formPassword = $('#repeat_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex hide-btn');
      $('.repeat').attr('class', 'fa fa-eye-slash repeat');
      $('#repeat_password').attr('type', 'text');
    }else{
      $('#repeat_password').attr('type', 'password');
      $('.repeat').attr('class', 'fa fa-eye repeat');
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex');
    }
});

    $(document).ready(function(){
        'use strict';

        $('#tblUser').DataTable({
            responsive: true,
            "language": {
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "emptyTable": "Tidak ada user.",
                "lengthMenu": "_MENU_ &nbsp; user/halaman",
                "search": "Cari: ",
                "zeroRecords": "User tidak ditemukan.",
                "paginate": {
                  "previous": "<i class='fas fa-chevron-left'></i>",
                  "next": "<i class='fas fa-chevron-right'></i>",
                },
            },
            ordering: true,
            dom: '<"left"l><"right"fr>',
        });
     });

    $(function(){
        $('.tambah-user').on('click', function() {
        	$('.modal-title').html('Tambah User');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-user');
            // $('#is_active_box').attr('class', 'col-md-6 d-none');
            
            $('#id_user').val('');
            $('#user_name').val('');
            $('#user_email').val('');
            $('#real_name').val('');
            $('#id_jabatan').val('');
        });
        $("#tblUser").on('click', '.edit-user', function(){
            $('.modal-title').html('Edit User');
            $('.modal-footer button[type=submit]').html('Edit User');
            $('.modal-body form').attr('action', baseURI + '/edit-user');
            // $('#is_active_box').attr('class', 'col-md-6');

            const id_user = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-user',
                data: {
                        id: id_user, 
                        simasjid_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: data,
                        showConfirmButton: false,
                        type: 'error'
                    })
                },
                success: function(data){
                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
                    $('#id_user').val(id_user)
                    $('#user_name').val(data.user_name);
                    $('#user_email').val(data.user_email);
                    $('#real_name').val(data.real_name);
                    $('#id_jabatan').val(data.id_jabatan);
                    if(data.is_active == '1') {
                        $('#is_active').prop('checked', true);
                    } else {
                        $('#is_active').prop('checked', false);
                    }
                }
            });
        });
    });

    $("#tblUser").on('click', '.delete-btn', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus user ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const id_user = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-user',
                data: { 
                id: id_user,
                simasjid_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: data,
                        showConfirmButton: false,
                        type: 'error'
                    })
                },
                success: function(data) {

                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                    if (data.result == 1) {
                      Swal.fire('Berhasil!', data.msg, 'success');
                      setTimeout(location.reload.bind(location), 1000);
                    } 
                    else {
                      Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            });
        }
        })
    });

    $("#userForm").on('submit', function() {
        var formAction = $("#userForm").attr('action');
        var dataUser = {
            id_user : $('#id_user').val(),
            user_name : $('#user_name').val(),
            user_email : $('#user_email').val(),
            real_name : $('#real_name').val(),
            id_jabatan : $('#id_jabatan').val(),
            user_password : $('#user_password').val(),
            repeat_password : $('#repeat_password').val(),
            is_active : ($('#is_active').is(":checked")) ? '1' : '0',
            simasjid_token : $('.csrf_token').val()
        };

        Swal.fire({
            title: 'Tunggu!',
            text: 'Membuat profil user...',
            showConfirmButton: false,
            type: 'info'
        }).then(setTimeout(() =>
            $.ajax({
                type: "POST",
                url: formAction,
                data: dataUser,
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: data,
                        showConfirmButton: false,
                        type: 'error'
                    })
                },
                success: function(data) {
                    
                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                    if (data.result == 1) {
                        Swal.fire('Berhasil!', data.msg, 'success');
                        setTimeout(location.reload.bind(location), 1000);
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,1000))
        return false;
    });