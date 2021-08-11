
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
        $('.tambah-kas').on('click', function() {
        	$('.modal-title').html('Tambah Pengeluaran');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/input-pengeluaran');
            
            $('#kode_transaksi').val('');
            $('#id_kategori').val('');
            $('#date').val('');
            $('#keterangan').val('');
            $('#saldo').val('');
            $('#pengeluaran').val('');
            $('.bukti-dokumentasi').hide();
        });
        $("#tblKeuangan").on('click', '.edit-kas', function(){
            $('.modal-title').html('Pengeluaran');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-body form').attr('action', baseURI + '/edit-kas/keluar');

            const hash = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-kas',
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
                    $('#id_kategori').val(data.id_kategori);
                    const saldo = $('#id_kategori option:selected').data('saldo'); // Get data value
                    $('#date').val(data.date);
                    $('#keterangan').val(data.keterangan);
                    $('#saldo').val(parseFloat(saldo) + parseFloat(data.pengeluaran));
                    $('#pengeluaran').val(data.pengeluaran);
                    $('#dokumentasi_old').val(data.dokumentasi);
                    $('.bukti-dokumentasi').show();
                    $('#bukti_dokumentasi').attr('src', baseURI + '/_/uploads/dokumentasi/' + data.lokasi_file);
                }
            });
        });
    });

    $("#kasForm").on('submit', function() {
        var formAction = $("#kasForm").attr('action');

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

    $("#id_kategori").change(function() {
        const $this = $(this);
        const saldo = $this.find(':selected').data('saldo'); // Get data value
        $('#saldo').val(saldo);
    });