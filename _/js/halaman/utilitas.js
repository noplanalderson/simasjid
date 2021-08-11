    $('#kategoriTbl').DataTable( {
        'info': false,
        'searchable':true,
        'responsive': false,
        'lengthMenu': [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "language": {
          "zeroRecords": "Kategori tidak ditemukan"
        },
        "order": [[ 0, "asc" ]],
        'columnDefs': [ 
            {
                'targets': [1],
                'orderable': false,
            }
        ],
        "dom": '<"left"l>rtip',
    });

    $('#jabatanTbl').DataTable( {
        'info': false,
        'searchable':true,
        'responsive': false,
        'lengthMenu': [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "language": {
          "zeroRecords": "Jabatan tidak ditemukan"
        },
        "order": [[ 0, "asc" ]],
        'columnDefs': [ 
            {
                'targets': [1,2],
                'orderable': false,
            }
        ],
        "dom": '<"left"l>rtip',
    });

    $('#jenisKegiatanTbl').DataTable( {
        'info': false,
        'searchable':true,
        'responsive': false,
        'lengthMenu': [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "language": {
          "zeroRecords": "Jenis kegiatan tidak ditemukan"
        },
        "order": [[ 0, "asc" ]],
        'columnDefs': [ 
            {
                'targets': [1],
                'orderable': false,
            }
        ],
        "dom": '<"left"l>rtip',
    });

    $(function(){
        $('.tambah-kategori').on('click', function() {
            $('.modal-title').html('Tambah Kategori');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-utilitas/kategori');
            
            $('#id_kategori').val('');
            $('#kategori').val('');
        });
        $("#kategoriTbl").on('click', '.edit-kategori', function(){
            $('.modal-title').html('Edit Kategori');
            $('.modal-footer button[type=submit]').html('Edit Kategori');
            $('.modal-body form').attr('action', baseURI + '/edit-utilitas/kategori');

            const id_kategori = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-utilitas/kategori',
                data: {
                        id: id_kategori, 
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
                    $('#id_kategori').val(id_kategori);
                    $('#kategori').val(data.kategori);
                }
            });
        });
    });

    $(function(){
        $('.tambah-jabatan').on('click', function() {
            $('.modal-title').html('Tambah Kategori');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-utilitas/jabatan');
            
            $('#id_jabatan').val('');
            $('#nama_jabatan').val('');
            $('#type_id').val('');
        });
        $("#jabatanTbl").on('click', '.edit-jabatan', function(){
            $('.modal-title').html('Edit Jabatan');
            $('.modal-footer button[type=submit]').html('Edit Jabatan');
            $('.modal-body form').attr('action', baseURI + '/edit-utilitas/jabatan');

            const id_jabatan = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-utilitas/jabatan',
                data: {
                        id: id_jabatan, 
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
                    $('#id_jabatan').val(id_jabatan);
                    $('#nama_jabatan').val(data.nama_jabatan);
                    $('#type_id').val(data.type_id);
                }
            });
        });
    });

    $(function(){
        $('.tambah-jenis').on('click', function() {
            $('.modal-title').html('Tambah Jenis Kegiatan');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-utilitas/jenis-kegiatan');
            
            $('#id_jenis').val('');
            $('#jenis_kegiatan').val('');
        });
        $("#jenisKegiatanTbl").on('click', '.edit-jenis', function(){
            $('.modal-title').html('Edit Jenis Kegiatan');
            $('.modal-footer button[type=submit]').html('Edit Jenis Kegiatan');
            $('.modal-body form').attr('action', baseURI + '/edit-utilitas/jenis-kegiatan');

            const id_jenis = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-utilitas/jenis-kegiatan',
                data: {
                        id: id_jenis, 
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
                    $('#id_jenis').val(id_jenis);
                    $('#jenis_kegiatan').val(data.jenis_kegiatan);
                }
            });
        });
    });

    $("#kategoriForm").on('submit', function() {
        var formAction = $("#kategoriForm").attr('action');
        var kategoriData = {
            id_kategori: $('#id_kategori').val(),
            kategori: $('#kategori').val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: kategoriData,
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

    $("#jabatanForm").on('submit', function() {
        var formAction = $("#jabatanForm").attr('action');
        var jabatanData = {
            id_jabatan: $('#id_jabatan').val(),
            nama_jabatan: $('#nama_jabatan').val(),
            type_id: $('#type_id').val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: jabatanData,
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
        });
        return false;
    });

    $("#jenisKegiatanForm").on('submit', function() {
        var formAction = $("#jenisKegiatanForm").attr('action');
        var jenisKegiatan = {
            id_jenis: $('#id_jenis').val(),
            jenis_kegiatan: $('#jenis_kegiatan').val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: jenisKegiatan,
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

    $("#kategoriTbl").on('click', '.delete-kategori', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus kategori ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const id_kategori = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-utilitas/kategori',
                data: { 
                id: id_kategori,
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

    $("#jabatanTbl").on('click', '.delete-jabatan', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus jabatan ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const id_jabatan = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-utilitas/jabatan',
                data: { 
                id: id_jabatan,
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

    $("#jenisKegiatanTbl").on('click', '.delete-jenis', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus jenis kegiatan ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const id_kategori = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-utilitas/jenis-kegiatan',
                data: { 
                id: id_kategori,
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