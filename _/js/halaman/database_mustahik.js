    $(document).ready(function(){
        'use strict';

        var title = $('.card-title').text();
        var nama_masjid = $('.subtitle').text();

        var table = $('#tblMustahik').DataTable({
            responsive: true,
            "language": {
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "emptyTable": "Tidak ada data",
                "lengthMenu": "_MENU_ &nbsp; data/halaman",
                "search": "Cari: ",
                "zeroRecords": "Tidak ditemukan data yang cocok.",
                "paginate": {
                  "previous": "<i class='fas fa-chevron-left'></i>",
                  "next": "<i class='fas fa-chevron-right'></i>",
                },
            },
            "order": [[ 1, "desc" ]],
            'columnDefs': [ 
                {
                    'targets': [2,3,4,5],
                    'orderable': false,
                }
            ],
            dom: '<"left"l><"center"fr>Btip',
            buttons: [
            {
                extend: 'excelHtml5',
                className: 'btn btn-success',
                pageSize: 'Legal',
                orientation: 'landscape',
                title: title + " " + nama_masjid,
                exportOptions: {
                    columns: [0,1,2,3,4]
                },
                action: function(e, dt, button, config) {
                    responsiveToggle(dt);
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(dt.button(button), e, dt, button, config);
                    responsiveToggle(dt);
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-danger',
                pageSize: 'Legal',
                orientation: 'landscape',
                title: title + " " + nama_masjid,
                action: function(e, dt, button, config) {
                    responsiveToggle(dt);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(dt.button(button), e, dt, button, config);
                    responsiveToggle(dt);
                },
                customize : function(doc) {
                    doc.content.splice(0, 1, {
                        text: [{
                            text: title + "\n" + nama_masjid + "\n\n\n",
                            fontSize: 14,
                            alignment: 'center'
                        }]
                    });

                    doc.content[1].margin = [ 10, 0, 10, 0 ];
                    doc.content[1].table.widths = [150,100,200,100,100];
                },
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            }],

            initComplete: function() {
                this.api().columns().every( function (i) {
                if(i == 1)
                {
                    var column = this;
                    var select = $('<select class="text-white"><option value="">Filter</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^'+val+'$' : '', true, false).draw();
                        })

                    column.data().unique().sort().each(function (d,j) {
                        if(column.search() === '^'+d+'$') {
                            select.append('<option value="'+d+'" selected="selected">'+d+'</option>')
                        }
                        else
                        {
                            select.append('<option value="'+d+'">'+d+'</option>');
                        }
                    });
                }
                });
            },
        });
    });

    $(function(){
        $('.tambah-mustahik').on('click', function() {
            $('.modal-title').html('Tambah Data');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-data-mustahik');
            
            $('#id_mustahik').val('');
            $('#nama').val('');
            $('#alamat').val('');
            $('#telepon').val('');
            $('#kategori').val('');
        });
        $("#tblMustahik").on('click', '.edit-mustahik', function(){
            $('.modal-title').html('Edit Data');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-body form').attr('action', baseURI + '/edit-data-mustahik');

            const hash = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-data-mustahik',
                data: {
                        id_mustahik: hash, 
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

                    $('#id_mustahik').val(hash);
                    $('#nama').val(data.nama);
                    $('#kategori').val(data.kategori);
                    $('#alamat').val(data.alamat);
                    $('#telepon').val(data.telepon);
                }
            });
        });
    });

    $("#mustahikForm").on('submit', function() {
        var formAction = $("#mustahikForm").attr('action');
        var dataMustahik = {
            id_mustahik: $('#id_mustahik').val(),
            nama : $('#nama').val(),
            alamat : $('#alamat').val(),
            telepon: $('#telepon').val(),
            kategori : $('#kategori').val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: dataMustahik,
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
        return false;
    });

    $("#tblMustahik").on('click', '.delete-btn', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus data ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const hash = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-data-mustahik',
                data: { 
                    id_mustahik: hash,
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