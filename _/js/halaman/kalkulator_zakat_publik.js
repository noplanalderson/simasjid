function mask(input_id) {    
    var numberMask = IMask(document.getElementById(input_id), {
      mask: Number,
      min: 0,
      thousandsSeparator: '.'
    }).on('accept', function() {
      document.getElementById(input_id).innerHTML = numberMask.masked.number;
    });
}

mask('zp_penghasilan_pokok');
mask('zp_penghasilan_tambahan');
mask('zp_hutang');
mask('zp_harga_beras');

$('#kalkulatorZpForm').on('change', function() {

	const zp_penghasilan_pokok = $('#zp_penghasilan_pokok').val().replace(/\./g,'');
	const zp_penghasilan_tambahan = $('#zp_penghasilan_tambahan').val().replace(/\./g,'');
	const zp_hutang = $('#zp_hutang').val().replace(/\./g,'');
	const zp_total_penghasilan = $('#zp_total_penghasilan').val((parseFloat(zp_penghasilan_pokok) + parseFloat(zp_penghasilan_tambahan)) - parseFloat(zp_hutang));

	const zp_harga_beras = $('#zp_harga_beras').val().replace(/\./g,'');
	const zp_besar_nishab = parseFloat(zp_harga_beras) * 522;
	$('#zp_besar_nishab').val(zp_besar_nishab);

	if(parseFloat($('#zp_total_penghasilan').val().replace(/\./g,'')) >= parseFloat($('#zp_besar_nishab').val().replace(/\./g,'')))
	{
		$('#zp_wajib_tidak').val('Ya');
		$('#zp_jumlah_zakat').val((parseFloat($('#zp_total_penghasilan').val()) * 2.5)/100);
	}
	else
	{
		$('#zp_wajib_tidak').val('Tidak');
		$('#zp_jumlah_zakat').val(0);
	}

	mask('zp_total_penghasilan');
	mask('zp_besar_nishab');
	mask('zp_jumlah_zakat');
})

mask('zm_tabungan');
mask('zm_logam_mulia');
mask('zm_surat_berharga');
mask('zm_properti');
mask('zm_kendaraan');
mask('zm_koleksi');
mask('zm_barang_dagangan');
mask('zm_lainnya');
mask('zm_piutang_lancar');
mask('zm_hutang_jatuh_tempo');
mask('zm_harga_emas');

$('input').on('change', function() {

	const zm_tabungan 			= $('#zm_tabungan').val().replace(/\./g,'');
	const zm_logam_mulia 	= $('#zm_logam_mulia').val().replace(/\./g,'');
	const zm_surat_berharga= $('#zm_surat_berharga').val().replace(/\./g,'');
	const zm_properti  		= $('#zm_properti').val().replace(/\./g,'');
	const zm_kendaraan 		= $('#zm_kendaraan').val().replace(/\./g,'');
	const barang_zm_koleksi= $('#zm_koleksi').val().replace(/\./g,'');
	const zm_dagangan 			= $('#zm_barang_dagangan').val().replace(/\./g,'');
	const zm_lainnya  			= $('#zm_lainnya').val().replace(/\./g,'');
	const zm_piutang 			= $('#zm_piutang_lancar').val().replace(/\./g,'');
	const zm_hutang 				= $('#zm_hutang_jatuh_tempo').val().replace(/\./g,'');


	const zm_jumlah_harta 	= parseFloat(zm_tabungan) + parseFloat(zm_logam_mulia) + parseFloat(zm_surat_berharga) + parseFloat(zm_properti) + parseFloat(zm_kendaraan) + parseFloat(barang_zm_koleksi) + parseFloat(zm_dagangan) + parseFloat(zm_lainnya) + parseFloat(zm_piutang);

	$('#zm_total_harta').val(zm_jumlah_harta);

	const zm_harta_kena_zakat = parseFloat(zm_jumlah_harta) - parseFloat(zm_hutang);

	$('#zm_harta_kena_zakat').val(zm_harta_kena_zakat);

	const zm_harga_emas = $('#zm_harga_emas').val().replace(/\./g,'');
	const zm_besar_nishab 	= parseFloat(zm_harga_emas) * 85;
	$('#zm_nisab').val(zm_besar_nishab);
	
	if(zm_harta_kena_zakat >= zm_besar_nishab)
	{
		$('#zm_wajib_tidak').val('Ya');
		$('#zm_zakat_tahunan').val((zm_harta_kena_zakat * 2.5)/100);
	}
	else
	{
		$('#zm_wajib_tidak').val('Tidak');
		$('#zm_zakat_tahunan').val(0);
	}

	mask('zm_total_harta');
	mask('zm_harta_kena_zakat');
	mask('zm_nisab');
	mask('zm_zakat_tahunan');
})