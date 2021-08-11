    (function($) {
      'use strict';
      $(function() {
        $('.file-upload-browse').on('click', function() {
          var file = $(this).parent().parent().parent().find('.file-upload-default');
          file.trigger('click');
        });
        $('.file-upload-default').on('change', function() {
          $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });
      });
    })(jQuery);

    $("#formAdmin").on('submit', function() {
        var formAction = $("#formAdmin").attr('action');
        var dataUser = {
            user_name : $('#user_name').val(),
            user_email : $('#user_email').val(),
            real_name : $('#real_name').val(),
            user_password : $('#user_password').val(),
            repeat_password : $('#repeat_password').val(),
            simasjid_token : $('.csrf_token').val()
        };

        Swal.fire({
            title: 'Tunggu!',
            text: 'Membuat profil admin...',
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
                        setTimeout(function () { window.location.href = baseURI + '/konfigurasi-smtp';}, 2000);
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,1000))
        return false;
    });