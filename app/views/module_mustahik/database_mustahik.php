<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Database Mustahik & Penerima Bantuan </h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'class="btn tambah-mustahik btn-primary" data-toggle="modal" data-target="#mustahikModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-3">Daftar Mustahik & Penerima Bantuan</h4>
                  </div>
                  <div class="card-body">
                    <h3 class="subtitle"><?= $this->app->nama_masjid ?></h3>
                    <div class="table-responsive mt-5">
                      <table class="table table-striped table-bordered w-100" id="tblMustahik">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($mustahik as $m) :?>
                            <tr>
                                <td><?= $m->nama ?></td>
                                <td><?= $m->kategori ?></td>
                                <td><?= $m->alamat ?></td>
                                <td><?= $m->telepon ?></td>
                                <td><?= $m->real_name ?></td>
                                <td>
                                  <?= button($btn_edit, FALSE, 'button', 'data-id="'.encrypt($m->id_mustahik).'" class="btn btn-sm btn-warning edit-mustahik" data-toggle="modal" data-target="#mustahikModal"');?>

                                  <?= button($btn_del, FALSE, 'button', 'data-id="'.encrypt($m->id_mustahik).'" class="btn btn-sm btn-danger delete-btn"');?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="mustahikModal" tabindex="-1" role="dialog" aria-labelledby="Mustahik" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'method="post" id="mustahikForm" accept-charset="utf-8"');?>
              <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="id_mustahik" id="id_mustahik" value="">
                      <div class="form-group">
                          <label for="nama">Nama *</label>
                          <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="kategori">Kategori *</label>
                          <select name="kategori" id="kategori" class="form-control text-white" required="required">
                            <option value="">Pilih Kategori</option>
                            <option value="fakir">Fakir</option>
                            <option value="miskin">Miskin</option>
                            <option value="riqab">Riqab</option>
                            <option value="gharim">Gharim</option>
                            <option value="ibnu sabil">Ibnu Sabil</option>
                            <option value="mualaf">Mualaf</option>
                            <option value="amil zakat">Amil Zakat</option>
                            <option value="yatim">Yatim</option>
                            <option value="piatu">Piatu</option>
                            <option value="janda">Janda</option>
                            <option value="fi sabilillah">Fi Sabilillah</option>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat"></textarea>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="telepon">No. Telepon</label>
                          <input type="text" id="telepon" name="telepon" class="form-control" placeholder="021xxxxxxx / +62xxxxxxx">
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