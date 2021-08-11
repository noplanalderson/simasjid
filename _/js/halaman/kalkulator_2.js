function mask(input_id) {    
    var numberMask = IMask(document.getElementById(input_id), {
      mask: Number,
      min: 0,
      thousandsSeparator: '.'
    }).on('accept', function() {
      document.getElementById(input_id).innerHTML = numberMask.masked.number;
    });
}

mask('tabungan');
mask('logam_mulia');
mask('surat_berharga');
mask('properti');
mask('kendaraan');
mask('koleksi');
mask('barang_dagangan');
mask('lainnya');
mask('piutang_lancar');
mask('hutang_jatuh_tempo');
mask('harga_emas');

$('input').on('change', function() {

	const tabungan 			= $('#tabungan').val().replace(/\./g,'');
	const logam_mulia 	= $('#logam_mulia').val().replace(/\./g,'');
	const surat_berharga= $('#surat_berharga').val().replace(/\./g,'');
	const properti  		= $('#properti').val().replace(/\./g,'');
	const kendaraan 		= $('#kendaraan').val().replace(/\./g,'');
	const barang_koleksi= $('#koleksi').val().replace(/\./g,'');
	const dagangan 			= $('#barang_dagangan').val().replace(/\./g,'');
	const lainnya  			= $('#lainnya').val().replace(/\./g,'');
	const piutang 			= $('#piutang_lancar').val().replace(/\./g,'');
	const hutang 				= $('#hutang_jatuh_tempo').val().replace(/\./g,'');


	const jumlah_harta 	= parseFloat(tabungan) + parseFloat(logam_mulia) + parseFloat(surat_berharga) + parseFloat(properti) + parseFloat(kendaraan) + parseFloat(barang_koleksi) + parseFloat(dagangan) + parseFloat(lainnya) + parseFloat(piutang);

	$('#total_harta').val(jumlah_harta);

	const harta_kena_zakat = parseFloat(jumlah_harta) - parseFloat(hutang);

	$('#harta_kena_zakat').val(harta_kena_zakat);

	const harga_emas = $('#harga_emas').val().replace(/\./g,'');
	const besar_nishab 	= parseFloat(harga_emas) * 85;
	$('#nisab').val(besar_nishab);
	
	if(harta_kena_zakat >= besar_nishab)
	{
		$('#wajib_tidak').val('Ya');
		$('#zakat_tahunan').val((harta_kena_zakat * 2.5)/100);
	}
	else
	{
		$('#wajib_tidak').val('Tidak');
		$('#zakat_tahunan').val(0);
	}

	mask('total_harta');
	mask('harta_kena_zakat');
	mask('nisab');
	mask('zakat_tahunan');
})