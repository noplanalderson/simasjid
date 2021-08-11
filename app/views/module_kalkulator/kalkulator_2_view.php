          <div class="content-wrapper">
            <div class="row">
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
                    <?= form_open('', 'method="post" id="kalkulatorForm" accept-charset="utf-8"');?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tabungan">Harta dalam Bentuk Tabungan/Giro/Deposito (Rp)</label>
                                <input type="text"  id="tabungan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logam_mulia">Harta dalam Bentuk Logam Mulia (Rp)</label>
                                <input type="text"  id="logam_mulia" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="surat_berharga">Harta dalam Bentuk Surat Beharga (Rp)<sup class="text-danger">1)</sup></label>
                                <input type="text"  id="surat_berharga" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="properti">Harta dalam Bentuk Properti (Rp)<sup class="text-danger">2)</sup></label>
                                <input type="text"  id="properti" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kendaraan">Harta dalam Bentuk Kendaraan (Rp)<sup class="text-danger">3)</sup></label>
                                <input type="text"  id="kendaraan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="koleksi">Harta dalam Bentuk Koleksi Seni & Barang Antik (Rp)<sup class="text-danger">4)</sup></label>
                                <input type="text"  id="koleksi" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barang_dagangan">Harta dalam Bentuk Stok Barang Dagangan (Rp)</label>
                                <input type="text"  id="barang_dagangan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lainnya">Harta dalam Bentuk Lainnya (Rp)<sup class="text-danger">5)</sup></label>
                                <input type="text"  id="lainnya" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="piutang_lancar">Harta dalam Bentuk Piutang Lancar (Rp)</label>
                                <input type="text"  id="piutang_lancar" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_harta font-weight-bold">Jumlah Harta (Rp)</label>
                                <input type="text"  id="total_harta" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hutang_jatuh_tempo">Hutang Jatuh Tempo Saat Membayar Zakat (Rp)</label>
                                <input type="text"  id="hutang_jatuh_tempo" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harta_kena_zakat font-weight-bold">Jumlah Harta Yang Dihitung Zakatnya (Rp)</label>
                                <input type="text"  id="harta_kena_zakat" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix border-bottom border-info mb-4"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_emas font-weight-bold">Masukkan harga Emas saat ini (dalam gram) (Rp)</label>
                                <input type="text"  id="harga_emas" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nisab font-weight-bold">Besarnya Nisab Zakat Maal per Tahun (Rp)</label>
                                <input type="text"  id="nisab" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wajib_tidak font-weight-bold">Apakah Saya Wajib Membayar Zakat Mal?</label>
                                <input type="text" id="wajib_tidak" class="form-control" value="-" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zakat_tahunan font-weight-bold">Jumlah yang Saya Harus Dibayarkan/Tahun (Rp)</label>
                                <input type="text"  id="zakat_tahunan" class="form-control bg-dark" value="0" readonly="readonly">
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