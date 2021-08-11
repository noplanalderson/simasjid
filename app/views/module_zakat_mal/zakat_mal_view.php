<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Zakat Mal </h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'class="btn '.$btn_class.' btn-primary" data-toggle="modal" data-target="#zakatModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title float-left mt-3"><?= $card_title ?></h4>
                    <div class="form-group form-inline float-right">
                      <label class="mr-4 mt-2 text-white" for="range">Tanggal</label>
                      <input type="text" id="range" name="range" aria-label="Rentang Waktu" placeholder="Rentang Waktu" class="form-control text-white bg-dark">
                      <a id="fullscreen" class="float-right ml-2" title="Fullscreen"><i class="mdi mdi-fullscreen mdi-36px"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                    <h3 class="subtitle"><?= $this->app->nama_masjid ?></h3>
                    <small class="daterange"></small>
                    <div class="table-responsive mt-5">
                      <table class="table table-striped table-bordered w-100" id="tblZakatMal">
                        <thead>
                          <tr>
                            <th>Kode Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Atas Nama</th>
                            <th>Alamat & No. Telepon</th>
                            <th>Petugas</th>
                            <th>Bentuk & Satuan Zakat</th>
                            <th>Jumlah Jiwa</th>
                            <th>Jumlah Zakat</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($muzakki as $m) :?>
                            <tr>
                                <td><?= $m->kode_transaksi ?></td>
                                <td><?= $m->date ?></td>
                                <td><?= $m->atas_nama ?></td>
                                <td><?= $m->alamat ?> - <?= $m->no_telepon ?> </td>
                                <td><?= $m->real_name ?></td>
                                <td><?= $m->bentuk_zakat ?> - (<?= $m->satuan_zakat ?>)</td>
                                <td><?= $m->jumlah_jiwa ?> Jiwa</td>
                                <td><?= ($m->satuan_zakat === 'RUPIAH') ? rupiah($m->jumlah_zakat) : $m->jumlah_zakat; ?></td>
                                <td>
                                  <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="aksi-<?= $m->kode_transaksi ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-menu"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="aksi-<?= $m->kode_transaksi ?>">
                                      <h6 class="dropdown-header">Aksi</h6>
                                      <div class="dropdown-divider"></div>
                                      <?= button($btn_edit, true, 'a', 'data-id="'.encrypt($m->kode_transaksi).'" class="dropdown-item edit-zakat mb-1" data-toggle="modal" data-target="#zakatModal"');?>

                                      <?= button($btn_del, true, 'a', 'data-id="'.encrypt($m->kode_transaksi).'" class="dropdown-item delete-btn mb-1"');?>

                                      <?= button($btn_log, true, 'a', 'data-id="'.encrypt($m->kode_transaksi).'" class="dropdown-item log-zakat mb-1" data-toggle="modal" data-target="#logModal"');?>

                                      <?= button($btn_kwitansi, true, 'a', 'href="'.base_url('kwitansi-zakat-mal/'.base64url_encode(encrypt($m->kode_transaksi))).'" class="dropdown-item log-zakat"');?>
                                    </div>
                                  </div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                          <th>Kode Transaksi</th>
                          <th>Tanggal Transaksi</th>
                          <th>Atas Nama</th>
                          <th>Alamat & No. Telepon</th>
                          <th>Petugas</th>
                          <th>Bentuk & Satuan Zakat</th>
                          <th>Jumlah Jiwa</th>
                          <th>Jumlah Zakat</th>
                          <th>Aksi</th>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="zakatModal" tabindex="-1" role="dialog" aria-labelledby="Zakat Fitrah" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'method="post" id="zakatForm" accept-charset="utf-8"');?>
              <div class="row">
                  <div class="col-md-4">
                      <input type="hidden" name="kode_transaksi" id="kode_transaksi" value="">
                      <div class="form-group">
                          <label for="date">Tanggal *</label>
                          <input type="date" id="date" name="date" class="form-control" required="required">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="status">Status *</label>
                          <input type="text" id="status" name="status" class="form-control text-dark" readonly="readonly">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="atas_nama">Atas Nama *</label>
                          <input type="text" id="atas_nama" name="atas_nama" class="form-control" placeholder="Atas Nama" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea name="alamat" id="alamat" class="form-control textarea-vert" placeholder="Alamat" cols="30" rows="1"></textarea>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="no_telepon">No. Telepon</label>
                          <input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="No. Telepon">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="bentuk_zakat">Bentuk Zakat *</label>
                          <input type="text" id="bentuk_zakat" name="bentuk_zakat" class="form-control" placeholder="Bentuk Zakat" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="satuan_zakat">Satuan Zakat *</label>
                          <select name="satuan_zakat" id="satuan_zakat" class="form-control text-white" required="required">
                            <option value="">Pilih Satuan Zakat</option>
                            <option value="RUPIAH">Rupiah</option>
                            <option value="KILOGRAM">Kilogram</option>
                            <option value="GRAM">Gram</option>
                            <option value="LITER">Liter</option>
                            <option value="EKOR">Ekor</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="jumlah_jiwa">Jumlah Jiwa</label>
                          <input type="number" id="jumlah_jiwa" name="jumlah_jiwa" class="form-control" placeholder="0">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="jumlah_zakat">Jumlah Zakat</label>
                          <input type="text" id="jumlah_zakat" name="jumlah_zakat" class="form-control" placeholder="0.0" pattern="^([0-9.]+)">
                      </div>
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

      <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="Log Kas" aria-hidden="true">
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