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

$('#formCari').on('submit', function(e){
    e.preventDefault();

    var range = $('#range').val().split(' - ');
    var min = new Date(range[0]);
    var max = new Date(range[1]);
    
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
    };
    
    var minPeriod = min.toLocaleDateString('id-ID', options);  
    var maxPeriod = max.toLocaleDateString('id-ID', options);
    var judul_kegiatan = $('#kegiatan').val();

    periode = minPeriod + ' - ' + maxPeriod;

    $.ajax({
        url: baseURI + '/dokumentasi',
        cache: false,
        data: {
                start: range[0],
                end: range[1], 
                kegiatan: judul_kegiatan,
                simasjid_token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                submit: 'submit'
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
            
            var dokumentasi = data.response;
            
            var image = '';
            for (var i = 0; i < dokumentasi.length; i++) {

            	var tgl = dokumentasi[i].tanggal.split('-');

            	const options = { 
			        year: 'numeric', 
			        month: 'long', 
			        day: 'numeric',
			    };
			    
			    var tglIndo = new Date(dokumentasi[i].tanggal).toLocaleDateString('id-ID', options);  
            	
            	image += '<a data-lg-size="1600-1067" data-pinterest-text="'+dokumentasi[i].judul_kegiatan+'" data-tweet-text="'+dokumentasi[i].judul_kegiatan+'" class="gallery-item" data-src="'+baseURI+'/_/uploads/dokumentasi/'+tgl[0]+'/'+tgl[1]+'/'+dokumentasi[i].file_dokumentasi+'" data-sub-html="<h5>'+dokumentasi[i].judul_kegiatan+'</h5><small>'+dokumentasi[i].keterangan+' - '+tglIndo+'</small>">';
            	image += '<img class="img-responsive" src="'+baseURI+'/_/uploads/dokumentasi/'+tgl[0]+'/'+tgl[1]+'/thumbnail/'+dokumentasi[i].file_dokumentasi+'" />';
            	image += '</a>';
            }

            var header = ((dokumentasi.length === 0) ? 'Tidak ditemukan pencarian dengan judul di atas' : judul_kegiatan);
            $('#judul-kegiatan').text(header.replace( /(<([^>]+)>)/ig, ''));
			$('#daterange').text('Periode: '+periode);
            
            $('#animated-thumbnails-gallery').html(image);

			$("#animated-thumbnails-gallery").justifiedGallery({
			    captions: true,
			    lastRow: "hide",
			    rowHeight: 180,
			    margins: 5
			  }).on("jg.complete", function () {
				window.lightGallery( document.getElementById("animated-thumbnails-gallery"), {
					autoplayFirstVideo: false,
					pager: false,
					galleryId: "dokumentasi",
					plugins: [lgZoom, lgThumbnail, lgAutoplay, lgFullscreen, lgRotate, lgShare],
					mobileSettings: {
						controls: true,
						showCloseIcon: true,
						download: true,
						rotate: true
					}
				});
			});
        }
    })
})

