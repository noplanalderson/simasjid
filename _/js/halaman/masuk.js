    $("#formMasuk").on('submit', function(e) {
        e.preventDefault();
        
        var formAction = $("#formMasuk").attr('action');
        var dataLogin = {
        	submit: $("#submit").attr('name'),
            user_name: $("#user_name").val(),
            user_password: $("#user_password").val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: dataLogin,
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
                
                $("#alert").slideDown('fast');
                $("#alert").html('<small>' + data.msg + '</small>');

                if (data.result == 1) {
                    $('#alert').attr('class', 'alert alert-success pt-1 pb-1');
                    setTimeout(function () { window.location.href = baseURI + '/' + data.url;}, 2000);
                } else {
                    $('#alert').attr('class', 'alert alert-danger pt-1 pb-1');
                    $("#alert").alert().delay(3000).slideUp('fast');
                }
            }
        });
        return false;
    });

    $("#formLupa").on('submit', function(e) {
        e.preventDefault();
        
        var formAction = $("#formLupa").attr('action');
        var dataLogin = {
            submit: $("#submit").attr('name'),
            user_email: $('#user_email').val(),
            simasjid_token: $('.csrf_token').val() 
        };

        Swal.fire({
            title: 'Tunggu!',
            text: 'Membuat Link Reset Password...',
            showConfirmButton: false,
            type: 'info'
        }).then(setTimeout(() =>

            $.ajax({
                type: "POST",
                url: formAction,
                data: dataLogin,
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
                        setTimeout(function () { window.location.href = baseURI;}, 2000);
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,1000))
        return false;
    });

    $("#formAktivasi").on('submit', function(e) {
        e.preventDefault();
        
        var formAction = $("#formAktivasi").attr('action');
        var dataLogin = {
            submit: $("#submit").attr('name'),
            user_token: $('#user_token').val(),
            repeat_password: $("#repeat_password").val(),
            user_password: $("#user_password").val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: dataLogin,
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
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.msg,
                        showConfirmButton: false,
                        type: 'success'
                    })
                    setTimeout(function () { window.location.href = baseURI;}, 2000);
                } else {
                    Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        });
        return false;
    });