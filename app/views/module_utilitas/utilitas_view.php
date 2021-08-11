<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Utilitas </h3>
            </div>
            <div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title float-left mt-2">Kategori Kas</h4>
                    <?= button($btn_add, TRUE, 'button', 'href="#" class="btn tambah-kategori btn-primary float-right" data-toggle="modal" data-target="#kategoriModal"');?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered w-100" id="kategoriTbl">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($kategori as $kat) :?>
                            <tr>
                                <td><?= $kat->kategori ?></td>
                                <td>
                                    <?= button($btn_edit, FALSE, 'button', 'data-id="'.encrypt($kat->id_kategori).'" class="btn btn-sm btn-warning edit-kategori" data-toggle="modal" data-target="#kategoriModal"');?>

                                    <?= button($btn_delete, FALSE, 'button', 'data-id="'.encrypt($kat->id_kategori).'" class="btn btn-sm btn-danger delete-kategori"');?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title float-left mt-2">Jabatan</h4>
                    <?= button($btn_add, TRUE, 'button', 'href="#" class="btn tambah-jabatan btn-primary float-right" data-toggle="modal" data-target="#jabatanModal"');?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered w-100" id="jabatanTbl">
                        <thead>
                            <tr>
                                <th>Jabatan</th>
                                <th>Tipe User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($jabatan as $j) :?>
                            <tr>
                                <td><?= $j->nama_jabatan ?></td>
                                <td><?= $j->type_name ?></td>
                                <td>
                                    <?= button($btn_edit, FALSE, 'button', 'data-id="'.encrypt($j->id_jabatan).'" class="btn btn-sm btn-warning edit-jabatan" data-toggle="modal" data-target="#jabatanModal"');?>

                                    <?= button($btn_delete, FALSE, 'button', 'data-id="'.encrypt($j->id_jabatan).'" class="btn btn-sm btn-danger delete-jabatan"');?>
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
            <div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title float-left mt-2">Jenis Kegiatan</h4>
                    <?= button($btn_add, TRUE, 'button', 'href="#" class="btn tambah-jenis btn-primary float-right" data-toggle="modal" data-target="#jenisKegiatanModal"');?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered w-100" id="jenisKegiatanTbl">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($kegiatan as $jenis) :?>
                            <tr>
                                <td><?= $jenis->jenis_kegiatan ?></td>
                                <td>
                                    <?= button($btn_edit, FALSE, 'button', 'data-id="'.encrypt($jenis->id_jenis).'" class="btn btn-sm btn-warning edit-jenis" data-toggle="modal" data-target="#jenisKegiatanModal"');?>

                                    <?= button($btn_delete, FALSE, 'button', 'data-id="'.encrypt($jenis->id_jenis).'" class="btn btn-sm btn-danger delete-jenis"');?>
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

      <div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="Kategori Kas" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('tambah-utilitas/kategori', 'id="kategoriForm" method="post"');?>

              <input type="hidden" id="id_kategori" name="id_kategori" value="">

              <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">Kategori *</label>
                <div class="col-sm-12 col-md-9">
                  <input type="text" id="kategori" name="kategori" class="form-control bg-dark text-white" placeholder="Kategori Kas" required="required">
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
              <button id="submitKategori" class="btn btn-success" type="submit" name="submit"></button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="jabatanModal" tabindex="-1" role="dialog" aria-labelledby="Jabatan" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('tambah-utilitas/jabatan', 'id="jabatanForm" method="post"');?>

              <input type="hidden" id="id_jabatan" name="id_jabatan" value="">

              <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">Jabatan *</label>
                <div class="col-sm-12 col-md-9">
                  <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control bg-dark text-white" placeholder="Nama Jabatan" required="required">
                </div>
              </div>

              <div class="form-group row">
                
                <label class="col-sm-12 col-md-3 col-form-label">Tipe User *</label>
                <div class="col-sm-12 col-md-9">
                  <select name="type_id" id="type_id" class="form-control text-white" required="required">
                    <option value="">Pilih Tipe User</option>
                    <?php foreach ($user_type as $type) :?>

                    <option value="<?= $type->type_id ?>"><?= $type->type_name ?></option>
                    <?php endforeach;?>

                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
              <button id="submitJabatan" class="btn btn-success" type="submit" name="submit"></button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="jenisKegiatanModal" tabindex="-1" role="dialog" aria-labelledby="Jenis Kegiatan" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('tambah-utilitas/jenis-kegiatan', 'id="jenisKegiatanForm" method="post"');?>

              <input type="hidden" id="id_jenis" name="id_jenis" value="">

              <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">Jenis Kegiatan *</label>
                <div class="col-sm-12 col-md-9">
                  <input type="text" id="jenis_kegiatan" name="jenis_kegiatan" class="form-control bg-dark text-white" placeholder="Jenis Kegiatan" required="required">
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
              <button id="submitKegiatan" class="btn btn-success" type="submit" name="submit"></button>
              </form>
            </div>
          </div>
        </div>
      </div>