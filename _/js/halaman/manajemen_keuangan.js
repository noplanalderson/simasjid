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

        var title = $('.card-title').text();
        var nama_masjid = $('.subtitle').text();

        var table = $('#tblKeuangan').DataTable({
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
                    'targets': [0,2,3,4],
                    'orderable': false,
                },
                {
                    'targets': 0,
                    'visible': false,
                    'searchable': true
                }
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
                    columns: [1,2,3,4,5,6]
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

                    var rowCount = doc.content[1].table.body.length;
                    for (var i = 1; i < rowCount; i++) {
                        doc.content[1].table.body[i][5].alignment = 'right';
                    };
                    
                    doc.content[1].margin = [ 10, 0, 10, 0 ];
                    doc.content[1].table.widths = [80,100,100,100,200,100,100,80];
                },
                exportOptions: {
                    columns: [1,2,3,4,5,6]
                }
            }],

            initComplete: function() {
                this.api().columns().every( function (i) {
                if(i == 3 || i == 5)
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
        $('.applyBtn').on('click', function () {

            // Custom filtering function which will search data in column four between two values
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var range = $('#range').val().split(' - ');
                    var min = new Date(range[0]);
                    var max = new Date(range[1]);
                    var date = new Date(data[0]);
                    
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

    function rupiah(numb){
        return 'Rp. ' + (Number(numb) ).toLocaleString('id-ID', { style: 'decimal', maximumFractionDigits : 2, minimumFractionDigits : 2 });
    }

    $("#tblKeuangan").on('click', '.log-kas', function(){
        $('.modal-title').html('Log Kas');

        const hash = $(this).data('id');
        $.ajax({
            url: baseURI + '/log-kas',
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
                    dataTimeline.push('<div class="timeline__item"><div class="timeline__content"><h1 class="mb-2">'+value.aksi+'</h1><p>Tanggal Log: '+value.timestamp+'</p><p>Petugas : '+value.real_name+'</p><p>Kategori : '+value.kategori+'</p><p>Tanggal Transaksi: '+value.date+'</p><p>Keterangan : '+value.keterangan+'</p><p>Pemasukan : '+rupiah(value.pemasukan)+'</p><p>Pengeluaran : '+rupiah(value.pengeluaran)+'</p></div></div>');
                    $('.timeline__items').html(dataTimeline);
                });
                $('.timeline').timeline();
            }
        });
    });

    $("#tblKeuangan").on('click', '.delete-btn', function(e){
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
                url: baseURI + '/hapus-kas',
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
