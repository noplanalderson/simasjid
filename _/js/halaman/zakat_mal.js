    // Initialize Datetime Range Picker 
    $('#range').daterangepicker({
        timePicker: false,
        "locale": {
            "cancelLabel": 'Clear',
            "format": "YYYY-MM-DD",
        }
    });

    $(document).ready(function(){
        'use strict';

        $('.daterange').text('Periode: -');

        var nama_masjid = $('.subtitle').text();
        var title = $('.card-title').text();
        var dtOptions = {
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
                    'targets': [0,,3,4,5,6,7,8],
                    'orderable': false,
                },
            ],
            dom: '<"left"l><"right"fr>Btip',
            buttons: [
            {
                extend: 'excelHtml5',
                className: 'btn btn-success',
                pageSize: 'Legal',
                orientation: 'landscape',
                title: title + " " + nama_masjid,
                exportOptions: {
                    columns: ':visible',
                },
                action: function(e, dt, button, config) {
                    responsiveToggle(dt);
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(dt.button(button), e, dt, button, config);
                    responsiveToggle(dt);
                },
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
                    doc.content[1].table.widths = [80,80,100,150,80,80,100,100,10];
                },
                exportOptions: {
                    columns: [":visible:not(.not-export-col):not(.hidden)"]
                }
            },
            {
                extend: 'colvis',
                text: 'Sembunyikan Kolom'
            }],

            initComplete: function() {
                this.api().columns().every( function (i) {
                if(i == 1 || i == 5)
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
            }        
        };

        var table = $('#tblZakatMal').DataTable(dtOptions);
        
        $('.applyBtn').on('click', function () {

            // Custom filtering function which will search data in column four between two values
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var range = $('#range').val().split(' - ');
                    var min = new Date(range[0]);
                    var max = new Date(range[1]);
                    var date = new Date(data[1]);
                    
                    const options = { year: 'numeric', month: 'long', day: 'numeric' };
                    var minPeriod = min.toLocaleDateString('id-ID', options);  
                    var maxPeriod = max.toLocaleDateString('id-ID', options);
                    var tgl = date.toLocaleDateString('id-ID', options);

                    var period = minPeriod + ' - ' + maxPeriod;
                    if (
                        ( min === null && max === null ) ||
                        ( min === null && date <= max ) ||
                        ( min <= date  && max === null ) ||
                        ( min <= date  && date <= max )
                    ) {
                        $('.daterange').text('Periode: ' + period);
                        return true;
                    }
                    return false;
                }
            );
            
            // Refilter the table
            $('#range').on('change', function () {
                table.draw();
            });
        })
    });

    $(function(){
        $('.tambah-muzakki').on('click', function() {
        	$('.modal-title').html('Tambah Data');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-zakat-mal');
            
            $('#kode_transaksi').val();
            $('#status').val('masuk');
            $('#date').val('');
            $('#atas_nama').val('');
            $('#alamat').val('');
            $('#no_telepon').val('');
            $('#bentuk_zakat').val('');
            $('#satuan_zakat').val('');
            $('#jumlah_zakat').val('');
            $('#jumlah_jiwa').val('');
            $('#status').val('masuk');
        });
        $('.tambah-mustahik').on('click', function() {
            $('.modal-title').html('Tambah Data');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-zakat-mal');
            
            $('#kode_transaksi').val();
            $('#status').val('masuk');
            $('#date').val('');
            $('#atas_nama').val('');
            $('#alamat').val('');
            $('#no_telepon').val('');
            $('#bentuk_zakat').val('');
            $('#satuan_zakat').val('');
            $('#jumlah_zakat').val('');
            $('#jumlah_jiwa').val('');
            $('#status').val('keluar');
        });
        $("#tblZakatMal").on('click', '.edit-zakat', function(){
            $('.modal-title').html('Edit Data');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-body form').attr('action', baseURI + '/edit-zakat-mal');

            const hash = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-zakat-mal',
                data: {
                        kode_transaksi: hash, 
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

                    $('#kode_transaksi').val(hash);
                    $('#status').val(data.status);
                    $('#date').val(data.date);
                    $('#atas_nama').val(data.atas_nama);
                    $('#alamat').val(data.alamat);
                    $('#no_telepon').val(data.no_telepon);
                    $('#bentuk_zakat').val(data.bentuk_zakat);
                    $('#satuan_zakat').val(data.satuan_zakat);
                    $('#jumlah_zakat').val(data.jumlah_zakat);
                    $('#jumlah_jiwa').val(data.jumlah_jiwa);
                }
            });
        });
        $("#tblZakatMal").on('click', '.log-zakat', function(){
            $('.modal-title').html('Log Zakat Fitrah');

            const hash = $(this).data('id');
            $.ajax({
                url: baseURI + '/log-zakat-mal',
                data: {
                        kode_transaksi: hash, 
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
                    
                    var dataTimeline = [];
                    $.each(data.log, function(index, value){
                        dataTimeline.push('<div class="timeline__item"><div class="timeline__content"><h1 class="mb-2">'+value.aksi+'</h1><p>Tanggal Log: '+value.timestamp+'</p><p>Petugas : '+value.real_name+'</p><p>Status : '+value.status+'</p><p>Tanggal Transaksi: '+value.date+'</p><p>Atas Nama : '+value.atas_nama+'</p><p>Satuan Zakat : '+value.satuan_zakat+'</p><p>Jumlah Jiwa : '+value.jumlah_jiwa+'</p><p>Jumlah Zakat : '+value.jumlah_zakat+'</p></div></div>');
                        $('.timeline__items').html(dataTimeline);
                    });
                    $('.timeline').timeline();
                }
            });
        });
    });

    $("#tblZakatMal").on('click', '.delete-btn', function(e){
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
                url: baseURI + '/hapus-zakat-mal',
                data: { 
                    kode_transaksi: hash,
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

    $("#zakatForm").on('submit', function() {
        var formAction = $("#zakatForm").attr('action');
        var dataZakat = {
            kode_transaksi: $('#kode_transaksi').val(),
            status: $('#status').val(),
            date: $('#date').val(),
            atas_nama: $('#atas_nama').val(),
            alamat: $('#alamat').val(),
            no_telepon: $('#no_telepon').val(),
            bentuk_zakat: $('#bentuk_zakat').val(),
            satuan_zakat: $('#satuan_zakat').val(),
            jumlah_zakat: $('#jumlah_zakat').val(),
            jumlah_jiwa: $('#jumlah_jiwa').val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: dataZakat,
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