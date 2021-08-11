          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                  <div class="card-body py-4 px-1 px-sm-3">
                    <div class="row align-items-center">
                      <div class="col-md-8 col-sm-12">
                        <h4>Selamat Datang, <?= $this->user->real_name ?></h4>
                        <small>Login Terakhir: <?= indonesian_date(date('Y-m-d h:i:s', $this->user->last_login), false, true) ?></small> | 
                        <small>Dari: <?= $this->user->ip ?></small>
                      </div>
                      <div class="col-md-4 col-sm-12">
                        <div id="jam" class="float-right text-white"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?= empty($kas_masjid->saldo) ? rupiah(0) : rupiah($kas_masjid->saldo); ?></h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="fas fa-coins text-danger"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Saldo Kas Masjid</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?= empty($zakat_fitrah->sisa_zakat_fitrah) ? rupiah(0) : rupiah($zakat_fitrah->sisa_zakat_fitrah); ?></h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="fas fa-hand-holding-usd text-primary"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Zakat Fitrah (Uang Tunai)</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?= empty($zakat_mal->sisa_zakat_mal) ? rupiah(0) : rupiah($zakat_mal->sisa_zakat_mal); ?></h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="fas fa-wallet text-success"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Zakat Mal (Uang Tunai)</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Sumber Kas Masjid</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="sumber-kas" class="transaction-chart"></canvas>
                    
                    <?php foreach ($transaksi_terakhir as $transaksi) :?>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="text-md-left text-xl-left col-xl-7 col-md-12 col-sm-12">
                        <h6 class="mb-1"><?= $transaksi->keterangan ?></h6>
                        <p class="text-muted mb-0"><?= indonesian_date($transaksi->date, true) ?></p>
                      </div>
                      <div class="align-self-center col-xl-5 col-md-12 col-sm-12 flex-grow text-right text-md-right text-xl-right text-sm-right py-md-2 py-xl-0">
                        <h6 class="font-weight-bold mb-0"><?= is_null($transaksi->pemasukan) ? rupiah($transaksi->pengeluaran).' <span class="fas fa-arrow-right text-danger ml-2" title="Kas Keluar"></span>' : rupiah($transaksi->pemasukan).' <span class="fas fa-arrow-left text-success ml-2" title="Kas Masuk"></span>'; ?></h6>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2 float-left">Agenda Hari Ini</h4>
                    <p class="text-muted mt-2 float-right">Waktu</p>
                  </div>
                  <div class="card-body">
                    <div class="preview-list">
                      <?php foreach ($agenda_hari_ini as $agenda) :?>
                      <div class="preview-item border-bottom">
                        <div class="preview-item-content d-sm-flex flex-grow">
                          <div class="flex-grow">
                            <h6 class="preview-subject"><?= $agenda->judul_kegiatan ?></h6>
                            <p class="text-muted mb-0">Narasumber: <?= $agenda->narasumber ?></p>
                          </div>
                          <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                            <p class="text-muted"><?= $agenda->jam_mulai ?> - <?= $agenda->jam_selesai ?></p>
                            <p class="text-muted mb-0"><?= $agenda->jenis_kegiatan ?></p>
                          </div>
                        </div>
                      </div>
                      <?php endforeach;?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Top 5 Aset Terbanyak</h4>
                  </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th> Nama Barang </th>
                            <th> Tanggal Pendataan </th>
                            <th> Stok </th>
                            <th> Satuan </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $colors = ['success','danger','primary','warning'];
                          foreach ($inventaris as $item) :?>
                          <tr>
                            <td> <?= $item->nama_barang ?></td>
                            <td> <?= indonesian_date($item->tgl_pendataan, true) ?> </td>
                            <td> <?= $item->stok ?></td>
                            <td>
                              <div class="badge badge-outline-<?php shuffle($colors); echo $colors[0]; ?>"><?= $item->satuan ?></div>
                            </td>
                          </tr>
                          <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>