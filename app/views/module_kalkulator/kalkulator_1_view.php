          <div class="content-wrapper">
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
                    <?= form_open('', 'method="post" id="kalkulatorForm" accept-charset="utf-8"');?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penghasilan_pokok">Penghasilan/Gaji Saya per Bulan (Rp)</label>
                                <input type="text" id="penghasilan_pokok" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penghasilan_tambahan">Penghasilan Tambahan per Bulan (Rp)</label>
                                <input type="text"  id="penghasilan_tambahan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hutang">Hutang/Cicilan Saya untuk Kebutuhan Pokok (Rp) <sup class="text-danger">*1)</sup> </label>
                                <input type="text"  id="hutang" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_penghasilan font-weight-bold">Jumlah Penghasilan per Bulan (Rp)</label>
                                <input type="text"  id="total_penghasilan" class="form-control" value="0" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_beras font-weight-bold">Masukkan harga beras saat ini/kg (Rp)</label>
                                <input type="text"  id="harga_beras" class="form-control" value="0" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="besar_nishab font-weight-bold">Besarnya Nishab Zakat Penghasilan per Bulan (Rp)</label>
                                <input type="text"  id="besar_nishab" class="form-control bg-dark" value="0" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wajib_tidak font-weight-bold">Apakah Saya Wajib Membayar Zakat Penghasilan?</label>
                                <input type="text" id="wajib_tidak" class="form-control bg-dark" value="-" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_zakat font-weight-bold">Jumlah yang Saya Harus Dibayarkan per Bulan (Rp)</label>
                                <input type="text"  id="jumlah_zakat" class="form-control bg-dark" value="0" readonly="readonly">
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
            </div>
          </div>