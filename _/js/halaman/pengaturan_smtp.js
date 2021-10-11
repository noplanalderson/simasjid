    $("#formSmtp").on('submit', function() {
        var formAction = $("#formSmtp").attr('action');
        var dataUser = {
            protokol : $('#protokol').val(),
            smtp_host : $('#smtp_host').val(),
            smtp_user : $('#smtp_user').val(),
            smtp_port : $('#smtp_port').val(),
            smtp_password : $('#smtp_password').val(),
            smtp_crypto : $('#mode_enkripsi').val(),
            simasjid_token : $('.csrf_token').val()
        };

        Swal.fire({
            title: 'Tunggu!',
            text: 'Membuat konfigurasi smtp...',
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
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,2000))
        return false;
    });