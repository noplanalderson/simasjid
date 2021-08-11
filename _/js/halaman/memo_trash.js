var tableCfg = {
    responsive: true,
    "language": {
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "emptyTable": "Tidak ada memo",
        "lengthMenu": "_MENU_ &nbsp; memo/halaman",
        "search": "Cari: ",
        "zeroRecords": "Tidak ditemukan memo yang cocok.",
        "paginate": {
          "previous": "<i class='fas fa-chevron-left'></i>",
          "next": "<i class='fas fa-chevron-right'></i>",
        },
    },
    "order": [[ 0, "desc" ]],
    'columnDefs': [ 
        {
            'targets': [1,2],
            'orderable': false,
        }
    ],
    dom: '<"left"l><"right"fr>tip',
};

$('#tblMemo').DataTable(tableCfg);

$('.memo-link').on('click', function () {
    const flow = $(this).data('href');
    $.ajax({
        url: baseURI + '/get-trash/' + flow,
        method: 'get',
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

            var trash = data.response;               
			if ( $.fn.DataTable.isDataTable('#tblMemo') ) {
				 $('#tblMemo').DataTable().destroy();
			}
            var column = ((flow === 'masuk') ? 'Dari' : 'Kepada');

			var table = "";
        		table += '<thead>';
				table += '<tr>';
				table += '<th width="30%">Tanggal</th>';
                table += '<th>'+column+'</th>';
				table += '<th width="50%">Judul Memo</th>';
				table += '<th>Aksi</th>';
				table += '</tr>';
           		table += '</thead>';
           		table += '<tbody>';
           		
           		for (var i = 0; i < trash.length; i++) {
					table += '<tr id="'+trash[i].hash+'">';
					table += '<td>'+trash[i].datetime+'</td>';
                    table += '<td>'+trash[i].real_name+'</td>';
					table += '<td>'+trash[i].judul_memo+'</td>';
					table += '<td>';
                    table += '<button type="button" class="btn btn-info btn-sm lihat-memo" data-href="'+flow+'" data-id="'+trash[i].hash+'" data-toggle="modal" data-target="#detailNotifModal"><i class="fas fa-eye"></i></button>';
                    table += '<button type="button" class="btn btn-warning btn-sm hapus-permanen ml-2" data-href="'+flow+'" data-id="'+trash[i].hash+'"><i class="fas fa-trash-alt"></i></button>';
                    table += '<button type="button" class="btn btn-success btn-sm pulihkan ml-2" data-href="'+flow+'" data-id="'+trash[i].hash+'"><i class="fas fa-undo-alt"></i></button>';
                    table += '</td>';
					table += '</tr>';
				}
				table += '</tbody>';

			$('#tblMemo').html(table);
            $('#tblMemo').DataTable(tableCfg);
            $('.memo-flow').text('Memo '+flow);
            $('#kosongkan-trash').html('<a class="btn btn-md btn-danger float-right kosongkan mt-4" data-href="'+flow+'" title="Kosongkan Trash"><i class="fas fa-trash-alt"></i>Kosongkan Trash</a>');
        }
    });
})

$("#tblMemo").on('click', '.lihat-memo', function(e) {
    e.preventDefault();

    const hash = $(this).data('id');
    $.ajax({
        url: baseURI + '/baca-notif',
        data: {
                memo_hash: hash, 
                simasjid_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
        method: 'post',
        dataType: 'json',
        success: function(data){

            $('.csrf_token').val(data.token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

            $('.modal-title').text(data.judul_memo);
            $('#isi_memo_lengkap').html(data.isi_memo);
            $('#waktu').text(data.tanggal);
        }
    });
});

$("#tblMemo").on('click', '.hapus-permanen', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus memo ini secara permanen?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Yes',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
        
        var $tr = $(this).closest('tr');
        const hash = $(this).data('id');
        const flow = $(this).data('href');

        $.ajax({
            url: baseURI + '/hapus-memo-permanen/' + flow,
            data: {
                id: hash,
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
                    $tr.find('td').fadeOut(1000,function(){ 
                        $tr.remove();                    
                    });
                    $('a[data-id="'+hash+'"]').remove();
                } 
                else {
                    Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        });
    }
    })
});

$("#tblMemo").on('click', '.pulihkan', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin memulihkan memo ini?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Yes',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
    
        var $tr = $(this).closest('tr');
        const hash = $(this).data('id');
        const flow = $(this).data('href');

        $.ajax({
            url: baseURI + '/pulihkan/' + flow,
            data: {
                id: hash,
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
                    $tr.find('td').fadeOut(1000,function(){ 
                        $tr.remove();                    
                    });
                } 
                else {
                    Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        });
    }
    })
});

$('#kosongkan-trash').on('click', '.kosongkan', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Semua memo akan dihapus secara permanen.',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Yes',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {

        const flow = $(this).data('href');
        $.ajax({
            url: baseURI + '/kosongkan-trash/' + flow,
            data: { 
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