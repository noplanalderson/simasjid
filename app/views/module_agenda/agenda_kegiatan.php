<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Manajemen Kegiatan </h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'class="btn tambah-agenda btn-primary" data-toggle="modal" data-target="#agendaModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-3 float-left">Agenda Kegiatan</h4>
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
                      <table class="table table-striped table-bordered w-100" id="tblAgenda">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Jenis Kegiatan</th>
                                <th>Judul Kegiatan</th>
                                <th>Waktu</th>
                                <th>Narasumber</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($agenda as $a) :?>
                            <tr>
                                <td><?= $a->tanggal ?></td>
                                <td><?= indonesian_date($a->tanggal, TRUE) ?></td>
                                <td><?= $a->jenis_kegiatan ?></td>
                                <td><?= $a->judul_kegiatan ?></td>
                                <td><?= $a->jam_mulai ?> s/d <?= is_null($a->jam_selesai) ? 'Selesai' : $a->jam_selesai ?></td>
                                <td><?= $a->narasumber ?></td>
                                <td><?= is_null($a->keterangan) ? '-' : $a->keterangan; ?></td>
                                <td>
                                  <?= button($btn_edit, FALSE, 'button', 'data-id="'.encrypt($a->id_kegiatan).'" class="btn btn-sm btn-warning edit-agenda" data-toggle="modal" data-target="#agendaModal"');?>

                                  <?= button($btn_upload, FALSE, 'button', 'data-id="'.$a->id_kegiatan.'" data-hash="'.encrypt($a->id_kegiatan).'" class="btn btn-sm btn-info unggah-foto" data-toggle="modal" data-target="#unggahModal"');?>
                                  
                                  <?= button($btn_del, FALSE, 'button', 'data-id="'.encrypt($a->id_kegiatan).'" class="btn btn-sm btn-danger delete-agenda"');?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th></th>
                            <th>Judul Kegiatan</th>
                            <th>Waktu</th>
                            <th></th>
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

      <div class="modal fade" id="agendaModal" tabindex="-1" role="dialog" aria-labelledby="Agenda Kegiatan" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'method="post" id="agendaForm" accept-charset="utf-8"');?>
              <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="">
                      <div class="form-group">
                          <label for="date">Tanggal *</label>
                          <input type="date" id="date" name="date" class="form-control" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="id_jenis">Jenis Agenda *</label>
                          <select name="id_jenis" id="id_jenis" class="form-control text-white" required="required">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($jenis as $j) :?>

                            <option value="<?= $j->id_jenis ?>"><?= $j->jenis_kegiatan ?></option>
                            <?php endforeach;?>

                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="judul_kegiatan">Judul Kegiatan *</label>
                          <input type="text" id="judul_kegiatan" name="judul_kegiatan" class="form-control" placeholder="Judul Kegiatan" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="narasumber">Narasumber *</label>
                          <input type="text" id="narasumber" name="narasumber" class="form-control" placeholder="Narasumber" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="jam_mulai">Jam Mulai *</label>
                          <input type="text" id="jam_mulai" name="jam_mulai" class="form-control" placeholder="00:00:00" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="jam_selesai">Jam Selesai</label>
                          <input type="text" id="jam_selesai" name="jam_selesai" class="form-control" placeholder="00:00:00">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="keterangan">Keterangan *</label>
                          <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan">
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

      <div class="modal fade" id="unggahModal" tabindex="-1" role="dialog" aria-labelledby="Unggah Dokumentasi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('unggah-foto', 'method="post" id="formUnggah" accept-charset="utf-8"');?>
              <input type="hidden" name="id" id="kegiatan" value="">
              <div class="row row-xs align-items-center mg-b-20 item form-group">
                <div class="col-md-12 mg-t-5 mg-md-t-0">
                  <div class="file-loading">
                      <input name="dokumentasi[]" type="file" class="dokumentasi"
                      data-allowed-file-extensions='["jpg","jpeg","png","webp"]' multiple="" />
                  </div>
                  <small class="text-danger font-weight-normal">Ukuran maksimal 5 MB/Foto dan maksimal 10 Foto sekali unggah.</small>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
                <input type="submit" id="unggah" class="my-3 btn btn-small btn-success" name="unggah" value="Unggah Semua">
                </form>
            </div>
          </div>
        </div>
      </div>