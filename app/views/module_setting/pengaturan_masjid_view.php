<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Pengaturan Masjid </h3>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    
                    <h4 class="card-title mt-2">Pengaturan Masjid</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <?= form_open('pengaturan-masjid/submit', 'id="formSetting" class="form-sample"');?>
                              <div class="form-group">
                                <label for="nama_masjid">Nama Masjid</label>
                                <input type="text" class="form-control" id="nama_masjid" name="nama_masjid" placeholder="Nama Masjid" value="<?= $this->app->nama_masjid ?>">
                              </div>
                              <div class="form-group">
                                <label for="email_masjid">Email Masjid</label>
                                <input type="email" class="form-control" id="email_masjid" name="email_masjid" placeholder="Email Masjid" value="<?= $this->app->email_masjid ?>">
                              </div>
                              <div class="form-group">
                                <label for="telepon_masjid">Telepon Masjid</label>
                                <input type="text" class="form-control" id="telepon_masjid" name="telepon_masjid" placeholder="Telepon Masjid (Contoh: +62xxxx / 021xxx)" value="<?= $this->app->telepon_masjid ?>">
                              </div>
                              <div class="form-group">
                                <label for="alamat_masjid">Alamat Masjid</label>
                                <textarea class="form-control" id="alamat_masjid" name="alamat_masjid" rows="4"><?= $this->app->alamat_masjid ?></textarea>
                              </div>
                              <div class="form-group">
                                <label>Logo Masjid</label>
                                <input type="file" name="logo_masjid" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                  <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                                  <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Cari...</button>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Icon Aplikasi</label>
                                <input type="file" name="icon_masjid" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                  <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                                  <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Cari...</button>
                                  </span>
                                </div>
                              </div>
                              <button type="submit" class="btn btn-primary mr-2">Kirim</button>
                              <button type="reset" class="btn btn-dark">Reset</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>