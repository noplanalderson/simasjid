    // Initialize Datetime Range Picker 
    $('#range').daterangepicker({
        timePicker:true,
        "locale": {
            "cancelLabel": 'Clear',
            "format": "YYYY-MM-DD HH:mm:ss",
        }
    });

    var title = $('.card-title').text();
    var nama_masjid = $('.subtitle').text();
    var periode = '-';

    $('#tblLogKas').DataTable({
        "language": {
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "emptyTable": "Tentukan rentang waktu untuk melihat data.",
                "lengthMenu": "_MENU_ &nbsp; data/halaman",
                "search": "Cari: ",
                "zeroRecords": "Tidak ditemukan data yang cocok.",
                "paginate": {
                  "previous": "<i class='fas fa-chevron-left'></i>",
                  "next": "<i class='fas fa-chevron-right'></i>",
                },
            },
    });

    var tableCfg = {
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
            "order": [[ 0, "desc" ]],
            'columnDefs': [ 
                {
                    'targets': [1,2,3,4],
                    'orderable': false,
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
                messageTop: 'Periode: '+periode,
                exportOptions: {
                    columns: [':visible']
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
                        },
                        {
                            text: "Periode: " + periode + "\n\n\n",
                            fontSize: 10,
                            alignment: 'left'
                        }]
                    });

                    doc.content[1].margin = [ 10, 0, 10, 0 ];
                },
                exportOptions: {
                    columns: [':visible']
                }
            },
            {
                extend: 'colvis',
                text: 'Sembunyikan Kolom'
            }],

            initComplete: function() {
                this.api().columns().every( function (i) {
                if(i == 1 || i == 2 || i == 4 || i == 5 || i == 6 || i == 7)
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
        }

    $('#range').on('change', function (e) {

        e.preventDefault();

        var range = $('#range').val().split(' - ');
        var min = new Date(range[0]);
        var max = new Date(range[1]);
        
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour:'numeric', 
            minute:'numeric', 
            second:'numeric'
        };
        var minPeriod = min.toLocaleDateString('id-ID', options);  
        var maxPeriod = max.toLocaleDateString('id-ID', options);

        periode = minPeriod + ' - ' + maxPeriod;
        
        $('.daterange').text('Periode: '+periode);
        var url = $('#formPeriode').attr('action');

        $.ajax({
            url: url,
            cache: false,
            data: {
                    start: range[0],
                    end: range[1], 
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
                
                var logKas = data.response;               
                if ( $.fn.DataTable.isDataTable('#tblLogKas') ) {
                     $('#tblLogKas').DataTable().destroy();
                }

                var table = '';
                    table += '<thead>';
                    table += '<tr>';
                    table += '<th>Waktu Log</th>';
                    table += '<th>Kode Transaksi</th>';
                    table += '<th>Aksi</th>';
                    table += '<th>Tanggal Transaksi</th>';
                    table += '<th>Petugas</th>';
                    table += '<th>Kategori</th>';
                    table += '<th>Pemasukan</th>';
                    table += '<th>Pengeluaran</th>';
                    table += '<th>Keterangan</th>';
                    table += '</tr>';
                    table += '</thead>';
                    table += '<tbody>';
                    for (var i = 0; i < logKas.length; i++) {
                        var timestamp = new Date(logKas[i].timestamp);
        
                        const options = { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric', 
                            hour:'numeric', 
                            minute:'numeric', 
                            second:'numeric'
                        };
                        var datetime = timestamp.toLocaleDateString('id-ID', options); 
                        table += '<tr>';
                        table += '<td>'+datetime+'</td>';
                        table += '<td>'+logKas[i].kode_transaksi+'</td>';
                        table += '<td>'+logKas[i].aksi+'</td>';
                        table += '<td>'+logKas[i].date+'</td>';
                        table += '<td>'+logKas[i].real_name+'</td>';
                        table += '<td>'+logKas[i].kategori+'</td>';
                        table += '<td>'+rupiah(logKas[i].pemasukan)+'</td>';
                        table += '<td>'+rupiah(logKas[i].pengeluaran)+'</td>';
                        table += '<td>'+logKas[i].keterangan+'</td>';
                        table += '</tr>'
                    }
                    table += '</tbody>';
                    table += '<tfoot>';
                    table += '<tr>';
                    table += '<th>Waktu Log</th>';
                    table += '<th>Kode Transaksi</th>';
                    table += '<th>Aksi</th>';
                    table += '<th>Tanggal Transaksi</th>';
                    table += '<th>Petugas</th>';
                    table += '<th>Kategori</th>';
                    table += '<th>Pemasukan</th>';
                    table += '<th>Pengeluaran</th>';
                    table += '<th>Keterangan</th>';
                    table += '</tr>';
                    table += '</tfoot>';

                $('#tblLogKas').html(table);
                $('#tblLogKas').DataTable(tableCfg);
            }
        })
    });
    
    function rupiah(numb){
        return 'Rp. ' + (Number(numb) ).toLocaleString('id-ID', { style: 'decimal', maximumFractionDigits : 2, minimumFractionDigits : 2 });
    }