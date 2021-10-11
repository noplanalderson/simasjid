  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <!-- <div class="row w-100 m-0"> -->
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="row">
              <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Zakat Penghasilan</h4>
                  </div>
                  <div class="card-body">
                    <div class="media">
                      <i class="mdi mdi-earth icon-lg text-info d-flex align-self-start mr-3"></i>
                      <div class="media-body">
                        <h5 class="text-info">Nisab Zakat Penghasilan</h5>
                        <p class="card-text text-justify">Nisab adalah syarat jumlah minimum (ambang batas) harta yang dapat dikategorikan sebagai harta wajib zakat. Untuk penghasilan yang diwajibkan zakat adalah penghasilan yang berada diatas nisab. Nisab Zakat Penghasilan adalah setara 522 kg beras normal.</p>
                      </div>
                    </div>
                    <blockquote class="blockquote blockquote-primary mt-3 text-justify">
                      <footer class="blockquote-footer font-weight-bold">Keterangan</footer>
                      <ol class="font-small">
                        <li>Yang dimaksud Kebutuhan Pokok adalah kebutuhan sandang, pangan, papan, pendidikan, kesehatan dan alat transportasi primer.</li>
                      </ol>
                    </blockquote>
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Hitung Zakat Penghasilan</h4>
                  </div>
                  <div class="card-body">
                    <?= form_open('', 'method="post" id="kalkulatorZpForm" accept-charset="utf-8"');?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_penghasilan_pokok">Penghasilan/Gaji Saya per Bulan (Rp)</label>
                                <input type="text" id="zp_penghasilan_pokok" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_penghasilan_tambahan">Penghasilan Tambahan per Bulan (Rp)</label>
                                <input type="text"  id="zp_penghasilan_tambahan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_hutang">Hutang/Cicilan Saya untuk Kebutuhan Pokok (Rp) <sup class="text-danger">*1)</sup> </label>
                                <input type="text"  id="zp_hutang" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_total_penghasilan font-weight-bold">Jumlah Penghasilan per Bulan (Rp)</label>
                                <input type="text"  id="zp_total_penghasilan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_harga_beras font-weight-bold">Masukkan harga beras saat ini/kg (Rp)</label>
                                <input type="text"  id="zp_harga_beras" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_besar_nishab font-weight-bold">Besarnya Nishab Zakat Penghasilan per Bulan (Rp)</label>
                                <input type="text"  id="zp_besar_nishab" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_wajib_tidak font-weight-bold">Apakah Saya Wajib Membayar Zakat Penghasilan?</label>
                                <input type="text" id="zp_wajib_tidak" class="form-control bg-dark" value="-" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zp_jumlah_zakat font-weight-bold">Jumlah yang Saya Harus Dibayarkan per Bulan (Rp)</label>
                                <input type="text"  id="zp_jumlah_zakat" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                          <button type="reset" class="btn btn-block btn-primary">Reset</button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Zakat Mal</h4>
                  </div>
                  <div class="card-body">
                    <div class="media">
                      <i class="mdi mdi-earth icon-lg text-info d-flex align-self-start mr-3"></i>
                      <div class="media-body">
                        <h5 class="text-info">Zakat Mal</h5>
                        <p class="card-text text-justify">Zakat Harta (Maal) adalah sejumlah harta yang wajib dikeluarkan bila telah mencapai batas minimal tertentu (nisab) dalam kurun waktu (haul) setiap satu tahun kalender. Untuk harta yang diwajibkan zakat adalah harta yang berjumlah diatas nisab. Nisab Zakat Harta (Maal) adalah setara dengan 85 gr emas 24 karat.</p>
                      </div>
                    </div>
                    <blockquote class="blockquote blockquote-primary mt-3 text-justify">
                      <footer class="blockquote-footer font-weight-bold">Keterangan</footer>
                      <ol class="font-small">
                        <li>Surat Berharga antara lain nilai tunai dari Reksadana, Saham, Obligasi, Unit Link, dll.</li>
                        <li>Rumah (properti) yang digunakan sehari-hari, TIDAK DIKENAKAN ZAKAT.</li>
                        <li>Kendaraan yang digunakan sehari-hari, TIDAK DIKENAKAN ZAKAT.</li>
                        <li>Nilai Koleksi dapat ditaksir sendiri, bila dimungkinkan dapat dibantu kurator seni.</li>
                        <li>Contoh bagi pedagang yang harus melunasi cicilan hutang atas barang yang diperdagangkan.</li>
                      </ol>
                    </blockquote>
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Hitung Zakat Mal</h4>
                  </div>
                  <div class="card-body">
                    <?= form_open('', 'method="post" id="kalkulatorZmForm" accept-charset="utf-8"');?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_tabungan">Harta dalam Bentuk Tabungan/Giro/Deposito (Rp)</label>
                                <input type="text"  id="zm_tabungan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_logam_mulia">Harta dalam Bentuk Logam Mulia (Rp)</label>
                                <input type="text"  id="zm_logam_mulia" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_surat_berharga">Harta dalam Bentuk Surat Beharga (Rp)<sup class="text-danger">1)</sup></label>
                                <input type="text"  id="zm_surat_berharga" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_properti">Harta dalam Bentuk Properti (Rp)<sup class="text-danger">2)</sup></label>
                                <input type="text"  id="zm_properti" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_kendaraan">Harta dalam Bentuk Kendaraan (Rp)<sup class="text-danger">3)</sup></label>
                                <input type="text"  id="zm_kendaraan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_koleksi">Harta dalam Bentuk Koleksi Seni & Barang Antik (Rp)<sup class="text-danger">4)</sup></label>
                                <input type="text"  id="zm_koleksi" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_barang_dagangan">Harta dalam Bentuk Stok Barang Dagangan (Rp)</label>
                                <input type="text"  id="zm_barang_dagangan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_lainnya">Harta dalam Bentuk Lainnya (Rp)<sup class="text-danger">5)</sup></label>
                                <input type="text"  id="zm_lainnya" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_piutang_lancar">Harta dalam Bentuk Piutang Lancar (Rp)</label>
                                <input type="text"  id="zm_piutang_lancar" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_total_harta font-weight-bold">Jumlah Harta (Rp)</label>
                                <input type="text"  id="zm_total_harta" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_hutang_jatuh_tempo">Hutang Jatuh Tempo Saat Membayar Zakat (Rp)</label>
                                <input type="text"  id="zm_hutang_jatuh_tempo" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_harta_kena_zakat font-weight-bold">Jumlah Harta Yang Dihitung Zakatnya (Rp)</label>
                                <input type="text"  id="zm_harta_kena_zakat" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix border-bottom border-info mb-4"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_harga_emas font-weight-bold">Masukkan harga Emas saat ini (dalam gram) (Rp)</label>
                                <input type="text"  id="zm_harga_emas" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_nisab font-weight-bold">Besarnya Nisab Zakat Maal per Tahun (Rp)</label>
                                <input type="text"  id="zm_nisab" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_wajib_tidak font-weight-bold">Apakah Saya Wajib Membayar Zakat Mal?</label>
                                <input type="text" id="zm_wajib_tidak" class="form-control" value="-" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zm_zakat_tahunan font-weight-bold">Jumlah yang Saya Harus Dibayarkan/Tahun (Rp)</label>
                                <input type="text"  id="zm_zakat_tahunan" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="reset" class="btn btn-block btn-primary">Reset</button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        <!-- </div> -->
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
  </body>