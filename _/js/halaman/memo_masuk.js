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
    const hash = $(this).data('id');
    var memoSender = $('a[data-id="'+hash+'"] h6').text();
    $.ajax({
        url: baseURI + '/get-memo-dari',
        data: {
                dari: hash, 
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
            
            var memo_masuk = data.response;               
			if ( $.fn.DataTable.isDataTable('#tblMemo') ) {
				 $('#tblMemo').DataTable().destroy();
			}

			var table = "";
        		table += '<thead>';
				table += '<tr>';
				table += '<th width="30%">Tanggal</th>';
                table += '<th width="10%">Prioritas</th>';
				table += '<th width="50%">Judul Memo</th>';
				table += '<th>Aksi</th>';
				table += '</tr>';
           		table += '</thead>';
           		table += '<tbody>';
           		
           		for (var i = 0; i < memo_masuk.length; i++) {
                    var bold = (memo_masuk[i].dibaca == 0) ? 'class="font-weight-bold"' : '';

                    switch(memo_masuk[i].prioritas) {
                        
                        case 'khusus':
                            var color = 'btn-outline-primary';
                            break;
                        
                        case 'mendesak':
                            var color = 'btn-outline-warning';
                            break;
                        
                        case 'darurat':
                            var color = 'btn-outline-danger';
                            break;
                        
                        default:
                            var color = 'btn-outline-secondary';
                    }
					table += '<tr id="'+memo_masuk[i].hash+'" '+bold+'>';
					table += '<td>'+memo_masuk[i].datetime+'</td>';
                    table += '<td><button type="button" class="btn '+color+' btn-sm">'+memo_masuk[i].prioritas+'</button></td>';
					table += '<td>'+memo_masuk[i].judul_memo+'</td>';
					table += '<td>';
                    table += '<button type="button" class="btn btn-info btn-sm lihat-memo" data-id="'+memo_masuk[i].hash+'" data-toggle="modal" data-target="#detailNotifModal"><i class="fas fa-eye"></i></button>';
                    table += '<button type="button" class="btn btn-warning btn-sm hapus-memo ml-2" data-id="'+memo_masuk[i].hash+'"><i class="fas fa-trash-alt"></i></button>';
                    table += '</td>';
					table += '</tr>';
				}
				table += '</tbody>';

			$('#tblMemo').html(table);
            $('#tblMemo').DataTable(tableCfg);
            $('.memo-dari').text('Memo Masuk - '+memoSender);
            $('#hapus-semua').html('<button type="button" class="btn btn-md btn-danger float-right hapus-memo-dari mt-4" data-id="'+hash+'" title="Hapus semua dari '+memoSender+'"><i class="fas fa-trash-alt"></i>Hapus Semua</button>');
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

            $('#tblMemo tr[id="'+hash+'"]').removeClass();
            $('.modal-title').text(data.judul_memo);
            $('#dari').text('Dari: ' + data.real_name);
            $('#isi_memo_lengkap').html(data.isi_memo);
            $('#waktu').text(data.tanggal);
            $('a[data-id="'+hash+'"] .icon-read').text('[Sudah dibaca]');

            terbaca(data.id);
        }
    });
});

$("#tblMemo").on('click', '.hapus-memo', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus memo ini?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Yes',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
        var $tr = $(this).closest('tr');
        const hash = $(this).data('id');

        $.ajax({
            url: baseURI + '/hapus-memo-masuk',
            data: { 
                id_memo: hash,
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

$('#hapus-semua').on('click', '.hapus-memo-dari', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin hapus semua memo?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Yes',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {
        const hash = $(this).data('id');

        $.ajax({
            url: baseURI + '/hapus-semua-dari',
            data: { 
                dari: hash,
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