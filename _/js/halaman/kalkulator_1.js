function mask(input_id) {    
    var numberMask = IMask(document.getElementById(input_id), {
      mask: Number,
      min: 0,
      thousandsSeparator: '.'
    }).on('accept', function() {
      document.getElementById(input_id).innerHTML = numberMask.masked.number;
    });
}

mask('penghasilan_pokok');
mask('penghasilan_tambahan');
mask('hutang');
mask('harga_beras');

$('input').on('change', function() {

	const penghasilan_pokok = $('#penghasilan_pokok').val().replace(/\./g,'');
	const penghasilan_tambahan = $('#penghasilan_tambahan').val().replace(/\./g,'');
	const hutang = $('#hutang').val().replace(/\./g,'');
	const total_penghasilan = $('#total_penghasilan').val((parseFloat(penghasilan_pokok) + parseFloat(penghasilan_tambahan)) - parseFloat(hutang));

	const harga_beras = $('#harga_beras').val().replace(/\./g,'');
	const besar_nishab = parseFloat(harga_beras) * 522;
	$('#besar_nishab').val(besar_nishab);

	if(parseFloat($('#total_penghasilan').val().replace(/\./g,'')) >= parseFloat($('#besar_nishab').val().replace(/\./g,'')))
	{
		$('#wajib_tidak').val('Ya');
		$('#jumlah_zakat').val((parseFloat($('#total_penghasilan').val()) * 2.5)/100);
	}
	else
	{
		$('#wajib_tidak').val('Tidak');
		$('#jumlah_zakat').val(0);
	}

	mask('total_penghasilan');
	mask('besar_nishab');
	mask('jumlah_zakat');
})