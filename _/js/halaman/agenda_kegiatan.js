    // Initialize Datetime Range Picker 
    $('#range').daterangepicker({
        timePicker: false,
        "locale": {
            "cancelLabel": 'Clear',
            "format": "YYYY-MM-DD",
        }
    });

    $('#jam_mulai').datetimepicker({
        pickDate: false,
        minuteStep: 15,
        pickerPosition: 'bottom-right',
        format: 'hh:ii',
        autoclose: true,
        showMeridian: false,
        startView: 1,
        maxView: 1,
    })

    $('#jam_selesai').datetimepicker({
        pickDate: false,
        minuteStep: 15,
        pickerPosition: 'bottom-right',
        format: 'hh:ii',
        autoclose: true,
        showMeridian: false,
        startView: 1,
        maxView: 1,
    })

    $(".datetimepicker").find('thead th').remove();
    $(".datetimepicker").find('thead').append($('<th class="switch">').text('Pilih Jam'));
    $('.switch').css('width','190px');

    $(document).ready(function(){
        'use strict';

        $('.daterange').text('Periode: -');

        var title = $('.card-title').text();
        var nama_masjid = $('.subtitle').text();

        var table = $('#tblAgenda').DataTable({
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
                    'targets': [1,2,3,4,5,6],
                    'orderable': false,
                },
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": true
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
                    doc.content[1].margin = [ 10, 0, 10, 0 ];
                    doc.content[1].table.widths = [100,100,150,150,150,100];
                },
                exportOptions: {
                    columns: [1,2,3,4,5,6]
                }
            }],

            initComplete: function() {
                this.api().columns().every( function (i) {
                if(i == 2 || i == 5)
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

    var $fileinput = $('.dokumentasi'), initPlugin = function() {
        $el4.fileinput({previewClass:''});
    };

    $(function(){
        $('.tambah-agenda').on('click', function() {
            $('.modal-title').html('Tambah Agenda');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-agenda');
            
            $('#id_kegiatan').val();
            $('#id_jenis').val();
            $('#date').val('');
            $('#judul_kegiatan').val('');
            $('#narasumber').val('');
            $('#jam_mulai').val('');
            $('#jam_selesai').val('');
            $('#keterangan').val('');
        });
        $("#tblAgenda").on('click', '.edit-agenda', function(){
            $('.modal-title').html('Edit Agenda');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-body form').attr('action', baseURI + '/edit-agenda');

            const hash = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-agenda',
                data: {
                        id_kegiatan: hash, 
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

                    $('#id_kegiatan').val(hash);
                    $('#id_jenis').val(data.id_jenis);
                    $('#date').val(data.tanggal);
                    $('#judul_kegiatan').val(data.judul_kegiatan);
                    $('#narasumber').val(data.narasumber);
                    $('#jam_mulai').val(data.jam_mulai);
                    $('#jam_selesai').val(data.jam_selesai);
                    $('#keterangan').val(data.keterangan);
                }
            });
        });
        $("#tblAgenda").on('click', '.unggah-foto', function(e){

            e.preventDefault();

            $('.modal-title').html('Unggah Foto');

            const hash  = $(this).data('hash');
            const id    = $(this).data('id');

            if ($fileinput.data('fileinput')) {
                $fileinput.fileinput('destroy');
            }
            
            $.ajax({
                url: baseURI + '/get-foto',
                data: {
                        id_kegiatan: hash, 
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

                    var dataJSON = JSON.parse(data.json);
                    var dataUploads = data.array;

                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
                    $('#kegiatan').val(id);

                    var $el1 = $(".dokumentasi");

                    $el1.fileinput({
                        theme: "fas",
                        uploadUrl: baseURI + '/unggah-foto',
                        uploadAsync: true,
                        showRemove: false,
                        showUpload: false,
                        fileActionSettings: {
                            showZoom: false,
                            showDrag: false
                        },
                        showBrowse: false,
                        showUploadStats: true,
                        browseOnZoneClick: true,
                        showCancel: true,
                        autoReplace: false,
                        maxFileCount: 10,
                        append: true,
                        autoOrientImage: true,
                        initialPreviewAsData: true,
                        uploadExtraData: function() {
                          return { 
                            id: id,
                            simasjid_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                          };
                        },
                        initialPreview: dataUploads,
                        initialPreviewConfig: dataJSON
                    }).on("filebatchselected", function(event, files) {
                            $el1.fileinput("upload");
                    }).on('fileuploaderror', function(event, data, msg) {
                        var form = data.form, files = data.files, extra = data.extra,
                        response = data.response, reader = data.reader;

                        $('.kv-fileinput-error').remove();
                        
                        if(data.jqXHR.status !== 200)
                        {
                            Toast.fire({
                                 type : 'error',
                                 icon: 'error',
                                 title: 'Terjadi kesalahan!',
                                 text: 'Error code:'+data.jqXHR.status,
                            });
                        }
                        else
                        {
                            $('.csrf_token').val(response.token);
                            $('meta[name="X-CSRF-TOKEN"]').attr('content', response.token);
                            Toast.fire({
                                type : 'error',
                                icon: 'error',
                                title: '',
                                text: response.msg.replace( /(<([^>]+)>)/ig, ''),
                            });
                        }

                    }).on('fileuploaded', function(event, data) {
                        $('.csrf_token').val(data.response.token);
                        $('meta[name="X-CSRF-TOKEN"]').attr('content', data.response.token);
                        Toast.fire({
                             type : 'success',
                             icon: 'success',
                             title: '',
                             text: 'Foto berhasil diunggah!',
                        });
                    }).on('filedeleteerror', function(event, data, msg) {
                        var form = data.form, files = data.files, extra = data.extra,
                        response = data.response, reader = data.reader;

                        $('.kv-fileinput-error').remove();
                        
                        if(data.jqXHR.status !== 200)
                        {
                            Toast.fire({
                                 type : 'error',
                                 icon: 'error',
                                 title: 'Terjadi kesalahan!',
                                 text: 'Error code: '+data.jqXHR.status,
                            });
                        }
                        else
                        {
                            $('.csrf_token').val(response.token);
                            $('meta[name="X-CSRF-TOKEN"]').attr('content', response.token);
                            Toast.fire({
                                type : 'error',
                                icon: 'error',
                                title: '',
                                text: response.msg,
                            });
                        }
                    }).on('filedeleted', function(event, key, jqXHR) {
                        Toast.fire({
                             type : 'success',
                             icon: 'success',
                             title: '',
                             text: 'Foto berhasil dihapus.',
                        });
                    });

                    $('.dokumentasi')
                }
            });
        });
    });

    $("#agendaForm").on('submit', function() {
        var formAction = $("#agendaForm").attr('action');
        var dataAgenda = {
            id_kegiatan : $('#id_kegiatan').val(),
            id_jenis: $('#id_jenis').val(),
            tanggal : $('#date').val(),
            judul_kegiatan : $('#judul_kegiatan').val(),
            narasumber : $('#narasumber').val(),
            jam_mulai : $('#jam_mulai').val(),
            jam_selesai : $('#jam_selesai').val(),
            keterangan : $('#keterangan').val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: dataAgenda,
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

    $("#tblAgenda").on('click', '.delete-agenda', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus agenda ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const hash = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-agenda',
                data: { 
                    id_kegiatan: hash,
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

  $("#formUnggah").on('submit', function(e) {
    e.preventDefault();

    var formAction = $("#formUnggah").attr('action');
    Swal.fire({
        title: 'Tunggu!',
        text: 'Mengunggah dokumentasi...',
        showConfirmButton: false,
        type: 'info'
    }).then(setTimeout(() =>
      
      $.ajax({
          type: "POST",
          data: new FormData(this),
          processData: false,
          contentType: false,
          cache: false,
          timeout: 800000,
          url: formAction,
          dataType: 'json',
          error: function(xhr, status, error) {
          var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Swal.fire('Terjadi kesalahan!', data, 'error');
          },
          success: function(data) {
              $('.csrf_token').val(data.token);
              $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            
            if (data.error == null) {
                Swal.fire('Berhasil!', data.msg, 'success');
            } else {
                Swal.fire('Gagal!', data.msg, 'error');
            }
          }
      })
    ,1000));

    return false;
  });