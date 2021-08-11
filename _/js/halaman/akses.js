    $('#access_lists').DataTable( {
        'info': false,
        'responsive': true,
        "order": [[ 0, "asc" ]],
        'columnDefs': [ 
            {
                'targets': [1,2],
                'orderable': false,
            },
            { "width": "50%", "targets": 1 }
        ],
        "dom": '<"left"l>rtip',
    });

    $(function(){
        $('.add-access').on('click', function() {
        	$('.modal-title').html('Tambah Tipe Akses');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-role');

            $('#type_id').val('');
            $('#type_code').val('');
            $('#menu_id').select2({
                width: '100%',
                dropdownParent: $('#accessModal'),
                minimumResultsForSearch: Infinity,
                placeholder: 'Pilih Role'
            }).val('').trigger('change');
        });
        $("#access_lists").on('click', '.edit-access', function() {
            $('.modal-title').html('Edit Tipe Akses');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-body form').attr('action', baseURI + '/edit-role');

            const type_id = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-role',
                data: {
                        id: type_id, 
                        simasjid_token: $('.csrf_token').attr('value')
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
                    $('#type_id').val(type_id);
                    $('#type_code').val(data.type_name);

                    var priv = data.priv;

                    if (priv) {
                        var arrayRoles = priv.split(',');
                        $('#menu_id').select2({
                            width: '100%',
                            dropdownParent: $('#accessModal'),
                            minimumResultsForSearch: Infinity,
                            placeholder: 'Choose Privileges'
                        }).val(arrayRoles).trigger('change');
                    }
                    else
                    {
                        $('#menu_id').select2({
                            width: '100%',
                            dropdownParent: $('#accessModal'),
                            minimumResultsForSearch: Infinity,
                            placeholder: 'Choose Privileges'
                        }).val('').trigger('change');
                    }
                }
            });
        });
    });

    $("#accessForm").on('submit', function() {
        var formAction = $("#accessForm").attr('action');
        var accessData = {
            type_id: $("#type_id").val(),
            type_code: $("#type_code").val(),
            menu_id: $("#menu_id").val(),
            simasjid_token: $('.csrf_token').attr('value')
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: accessData,
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
                    Swal.fire('Success!', data.msg, 'success');
                    setTimeout(location.reload.bind(location), 1000);
                } else {
                    Swal.fire('Failed!', data.msg, 'error');
                }
            }
        });
        return false;
    });

    $("#access_lists").on('click', '.delete-btn', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus tipe akses ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

            if (result.value == true) {

                const type_id = $(this).data('id');
                $.ajax({
                    url: baseURI + '/hapus-role',
                    data: {
                            id: type_id, 
                            simasjid_token: $('.csrf_token').attr('value')
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
                            Swal.fire('Success!', data.msg, 'success');
                            setTimeout(location.reload.bind(location), 1000);
                        } else {
                            Swal.fire('Failed!', data.msg, 'error');
                        }
                    }
                });
            }
        })
    });

    $("#access_lists").on('change', '.index_page', function(){
        
        const type_id = $(this).data('id');
        var index_page = $('select[data-id="'+type_id+'"]').val();

        $.ajax({
            url: baseURI + '/update-index',
            data: { 
                id: type_id,
                index_page: index_page,
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

                if(data.result == 0) {
                    $('.index_page option').prop('selected', function() {
                        return this.defaultSelected;
                    });;
                }
            }
        });
    });