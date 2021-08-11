    (function($) {
      'use strict';
      $(function() {
        $('.cari-foto').on('click', function() {
          var file = $(this).parent().parent().parent().find('#dokumentasi_barang');
          file.trigger('click');
        });
        $('#dokumentasi_barang').on('change', function() {
          $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });
      });
    })(jQuery);

    $(function(){
        $('.tambah-barang').on('click', function() {
            $('.modal-title').html('Tambah Barang Masuk');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/input-barang-keluar');
            
            $('#hash').val('');
            $('#date').val('');
            $('#nama_barang').val('');
            $('#kuantitas_masuk').val('');
            $('#satuan').val('');
            $('#keterangan').val('');
            $('#stok_barang').val('');
            $('#dokumentasi_old').val('');
            $('.bukti-dokumentasi').hide();
        });
        $("#tblBarang").on('click', '.edit-barang', function(){
            $('.modal-title').html('Edit Barang');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-body form').attr('action', baseURI + '/edit-barang/keluar');

            const hash = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-barang',
                data: {
                        kode_barang: hash, 
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

                    $('#hash').val(hash);
                    $('#nama_barang').val(data.nama_barang);
                    const stok = $('#nama_barang option:selected').data('stok'); // Get data value
                    $('#date').val(data.tgl_pendataan);
                    $('#keterangan').val(data.keterangan);
                    $('#stok_barang').val(parseFloat(stok) + parseFloat(data.kuantitas_keluar));
                    $('#kuantitas_keluar').val(data.kuantitas_keluar);
                    $('#satuan').val(data.satuan);
                    $('#dokumentasi_old').val(data.dokumentasi);
                    $('.bukti-dokumentasi').show();
                    $('#bukti_dokumentasi').attr('src', baseURI + '/_/uploads/dokumentasi/' + data.month+'/'+data.dokumentasi);
                }
            });
        });
    });

    $("#brgForm").on('submit', function() {
        var formAction = $("#brgForm").attr('action');
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

    $("#nama_barang").change(function() {
        const $this = $(this);
        const stok = $this.find(':selected').data('stok'); // Get data value
        $('#stok_barang').val(stok);
    });