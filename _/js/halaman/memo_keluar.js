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
    var memoReceiver = $('a[data-id="'+hash+'"] h6').text();
    $.ajax({
        url: baseURI + '/get-memo-kepada',
        data: {
                kepada: hash, 
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
            
            var memo_keluar = data.response;               
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
           		
           		for (var i = 0; i < memo_keluar.length; i++) {
                    
                    var icon = (memo_keluar[i].dibaca === '1') ? 'fa fa-check-double text-primary' : 'fa fa-check text-secondary';
                    
                    switch(memo_keluar[i].prioritas) {
                        
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

					table += '<tr id="'+memo_keluar[i].hash+'">';
					table += '<td>'+memo_keluar[i].datetime+'</td>';
                    table += '<td><button type="button" class="btn '+color+' btn-sm">'+memo_keluar[i].prioritas+'</button></td>';
					table += '<td>'+memo_keluar[i].judul_memo+'</td>';
					table += '<td>';
                    table += '<button type="button" class="btn btn-info btn-sm lihat-memo" data-id="'+memo_keluar[i].hash+'" data-name="'+memoReceiver+'" data-toggle="modal" data-target="#detailNotifModal"><i class="fas fa-eye"></i></button>';
                    table += '<button type="button" class="btn btn-warning btn-sm hapus-memo ml-2" data-id="'+memo_keluar[i].hash+'"><i class="fas fa-trash-alt"></i></button>';
                    table += '<i class="'+icon+' ml-2">';
                    table += '</td>';
					table += '</tr>';
				}
				table += '</tbody>';

			$('#tblMemo').html(table);
            $('#tblMemo').DataTable(tableCfg);
            $('.memo-kepada').text('Memo Keluar - '+memoReceiver);
            $('#hapus-semua').html('<button type="button" class="btn btn-md btn-danger float-right hapus-memo-kepada mt-4" data-id="'+hash+'" title="Hapus semua memo untuk '+memoReceiver+'"><i class="fas fa-trash-alt"></i>Hapus Semua</button>');
        }
    });
})

$("#tblMemo").on('click', '.lihat-memo', function(e) {
    e.preventDefault();

    const hash = $(this).data('id');
    const name = $(this).data('name');

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
            $('#dari').html('Dari: ' + data.real_name + "<br/>"+'Kepada: '+name+'<hr class="bg-light">');
            $('#isi_memo_lengkap').html(data.isi_memo);
            $('#waktu').text(data.tanggal);
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
        html: '<div class="form-check"><label class="form-check-label"><input type="checkbox" class="form-check-input" id="untuk-semua"> Hapus untuk semua? <i class="input-helper"></i></label></div>',
        reverseButtons: true
    }).then((result) => {

    if (result.value) {
        var hapusUntukSemua = ($('#untuk-semua').is(":checked")) ? '1' : '0';
        var $tr = $(this).closest('tr');
        const hash = $(this).data('id');

        $.ajax({
            url: baseURI + '/hapus-memo-keluar',
            data: { 
                id_memo: hash,
                hapus_semua: hapusUntukSemua,
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

$('#hapus-semua').on('click', '.hapus-memo-kepada', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin hapus semua memo?',
        showCancelButton: true,
        type: 'warning',
        html: '<div class="form-check"><label class="form-check-label"><input type="checkbox" class="form-check-input" id="untuk-semua"> Hapus untuk semua? <i class="input-helper"></i></label></div>',
        confirmButtonText: 'Yes',
        reverseButtons: true
    }).then((result) => {

    if (result.value == true) {

        var hapusUntukSemua = ($('#untuk-semua').is(":checked")) ? '1' : '0';
        const hash = $(this).data('id');
        
        $.ajax({
            url: baseURI + '/hapus-semua-kepada',
            data: { 
                kepada: hash,
                hapus_semua: hapusUntukSemua,
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