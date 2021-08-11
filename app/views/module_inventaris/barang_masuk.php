<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Inventarisasi </h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'class="btn tambah-barang btn-primary" data-toggle="modal" data-target="#brgModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title float-left mt-3">Barang Masuk</h4>
                    <div class="form-group form-inline float-right">
                      <label class="mr-4 mt-2 text-white" for="range">Rentang Waktu</label>
                      <input type="text" id="range" name="range" aria-label="Rentang Waktu" placeholder="Rentang Waktu" class="form-control text-white bg-dark">
                      <a id="fullscreen" class="float-right ml-2" title="Fullscreen"><i class="mdi mdi-fullscreen mdi-36px"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                    <h3 class="subtitle"><?= $this->app->nama_masjid ?></h3>
                    <small class="daterange"></small>
                    <div class="table-responsive mt-5">
                      <table class="table table-striped table-bordered w-100" id="tblBarang">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Tanggal Pendataan</th>
                                <th>Petugas</th>
                                <th>Nama Barang</th>
                                <th>Kuantitas Masuk</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($barang as $brg) :?>
                            <tr>
                                <td><?= $brg->tgl_pendataan ?></td>
                                <td><?= $brg->kode_barang ?></td>
                                <td><?= indonesian_date($brg->tgl_pendataan) ?></td>
                                <td><?= $brg->real_name ?></td>
                                <td><?= $brg->nama_barang ?></td>
                                <td><?= $brg->kuantitas_masuk ?> <?= $brg->satuan ?></td>
                                <td><?= $brg->keterangan ?></td>
                                <td>
                                  <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="aksi-<?= $brg->kode_barang ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-menu"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="aksi-<?= $brg->kode_barang ?>">
                                      <h6 class="dropdown-header">Aksi</h6>
                                      <div class="dropdown-divider"></div>
                                      <?= button($btn_edit, true, 'a', 'data-id="'.encrypt($brg->kode_barang).'" class="dropdown-item edit-barang" data-toggle="modal" data-target="#brgModal"');?>

                                      <?= button($btn_del, true, 'a', 'data-id="'.encrypt($brg->kode_barang).'" class="dropdown-item delete-btn"');?>

                                      <?= button($btn_log, true, 'a', 'data-id="'.encrypt($brg->kode_barang).'" class="dropdown-item log-barang" data-toggle="modal" data-target="#logModal"');?>
                                    </div>
                                  </div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                          <th>#</th>
                          <th>Kode Barang</th>
                          <th>Tanggal Pendataan</th>
                          <th>Petugas</th>
                          <th>Nama Barang</th>
                          <th>Kuantitas Masuk</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="brgModal" tabindex="-1" role="dialog" aria-labelledby="Barang" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'method="post" id="brgForm" accept-charset="utf-8"');?>
              <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="kode_barang" id="kode_barang" value="">
                      <input type="hidden" name="hash" id="hash" value="">
                      <div class="form-group">
                          <label for="date">Tanggal *</label>
                          <input type="date" id="date" name="tgl_pendataan" class="form-control" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama_barang">Nama Barang *</label>
                          <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama Barang" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="keterangan">Keterangan</label>
                          <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="kuantitas_masuk">Kuantitas Masuk *</label>
                          <input type="text" id="kuantitas_masuk" name="kuantitas_masuk" class="form-control" placeholder="0.0" pattern="^([0-9.]+)" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="satuan">Satuan *</label>
                          <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Satuan" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="id_kategori">Dana Pembelian dari</label>
                          <input type="hidden" name="hidden_kategori" id="hidden_kategori" value="">
                          <select name="id_kategori" id="id_kategori" class="form-control text-white">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($saldo_kas as $kat) :?>

                            <option value="<?= $kat['id_kategori'] ?>" data-saldo="<?= $kat['saldo'] ?>"><?= $kat['kategori'] ?></option>
                            <?php endforeach;?>

                          </select>
                          <small class="text-danger">Dipilih jika barang masuk dibeli menggunakan kas masjid.</small>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="saldo">Saldo</label>
                          <input type="text" id="saldo" name="saldo" class="form-control bg-dark" placeholder="0.0" readonly="readonly">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="pengeluaran">Pengeluaran</label>
                          <input type="text" id="pengeluaran" name="pengeluaran" class="form-control" placeholder="0.0" pattern="^([0-9.]+)">
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label>Dokumentasi</label>
                      <input type="hidden" name="dokumentasi_old" id="dokumentasi_old">
                      <input type="file" name="dokumentasi" id="dokumentasi_barang" class="file-upload-default">
                          <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Dokumentasi">
                          <span class="input-group-append">
                              <button class="file-upload-browse btn btn-primary cari-foto" type="button">Cari...</button>
                          </span>
                      </div>
                      <small class="text-danger">Maksimal 5MB dengan ekstensi jpg, jpeg, atau png.</small>
                  </div>
                </div>
              </div>
              <div class="row bukti-dokumentasi">
                <div class="col-12">
                  <label for="dokumentasi">Bukti/Dokumentasi</label>
                  <div class="clearfix"></div>
                  <img src="" id="bukti_dokumentasi" alt="" class="img-thumbnail w-100">
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
                <input type="submit" id="submit" class="my-3 btn btn-small btn-success" name="submit" value="Submit">
                </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="Log Barang" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="timeline" data-vertical-start-position="right" data-vertical-trigger="150px">
                <div class="timeline__wrap">
                  <div class="timeline__items">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>