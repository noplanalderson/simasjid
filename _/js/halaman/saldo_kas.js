        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#range span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            }

            $('#range').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                   '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                   '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                   'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                   'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });

        jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                }

                return a + b;
            }, 0 );
        } );

        function rupiah(numb){
            return 'Rp. ' + (Number(numb) ).toLocaleString('id-ID', { style: 'decimal', maximumFractionDigits : 2, minimumFractionDigits : 2 });
        }

        var title = $('.card-title').text();
        var nama_masjid = $('.subtitle').text();

        var table = $('#tblSaldo').DataTable({
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
            "order": [],
            "columnDefs": [
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
                footer: true,
                title: title + " " + nama_masjid,
                exportOptions: {
                    columns: [0,1,2,3]
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
                footer: true,
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
                        doc.content[1].table.body[i][1].alignment = 'right';
                        doc.content[1].table.body[i][2].alignment = 'right';
                        doc.content[1].table.body[i][3].alignment = 'right';
                    };
                    doc.content[1].margin = [ 10, 0, 10, 0 ];
                    doc.content[1].table.widths = [200,200,200,200];
                },
                exportOptions: {
                    columns: [0,1,2,3]
                }
            }]
        });

        var totalMasuk = table.column( 2 ).data().sum();
        var totalKeluar = table.column( 3 ).data().sum();
        var totalSaldo = table.column( 4 ).data().sum();

        $('.total_pemasukan').text(rupiah(totalMasuk));
        $('.total_pengeluaran').text(rupiah(totalKeluar));
        $('.total_saldo').text(rupiah(totalSaldo));

        $('#range').on('change', function () {

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
                        return true;
                    }
                    $('.daterange').text('Periode: ' + period);
                    return false;
                }
            );
            
            // Refilter the table
            $('#range').on('change', function () {
                table.draw();
            });
        })