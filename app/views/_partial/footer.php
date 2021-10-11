<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?= date('Y') ?> | SIMASJID v<?= SIMASJID_VERSION ?> by Debu Semesta</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><?= $this->app->nama_masjid ?></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- Password Modal-->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Kata Sandi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?= form_open('akun/ganti-kata-sandi', 'id="formGantiPwd" method="post"');?>
                    <div class="form-group">
                        <label for="ch_user_password my-2">Kata Sandi *</label>
                        <div class="input-group">
                            <input id="ch_user_password" 
                                type="password" 
                                class="form-control" 
                                placeholder="********"
                                name="user_password" 
                                pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[.!@$%?/~_]).{8,32}$"
                                required="required" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text show-btn-password"><i class="fa fa-eye password"></i></span>
                            </div>
                        </div>
                        <small class="text-danger">Kata sandi harus mengandung huruf besar, kecil, angka, dan simbol minimal 8 karakter.</small>
                    </div>
                    <div class="form-group">
                        <label for="ch_repeat_password my-2">Ulangi Kata Sandi *</label>
                        <div class="input-group">
                            <input id="ch_repeat_password" type="password" class="form-control" placeholder="********" name="repeat_password" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text show-btn-repeat"><i class="fa fa-eye repeat"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <input id="submitPassword" type="submit" class="btn btn-small btn-primary" name="submit" value="Ubah">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="akunModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengaturan Akun</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?= form_open_multipart('akun/update', 'id="formAkun" method="post"');?>
                    <div class="form-group">
                        <label for="akun_real_name">Nama *</label>
                        <input id="akun_real_name" type="text" class="form-control" name="real_name" placeholder="Nama" required="required">
                    </div>
                    <div class="form-group">
                        <label for="akun_user_name">Username *</label>
                        <input id="akun_user_name" type="text" class="form-control" name="user_name" placeholder="Username (ex: user_name)" required="required">
                    </div>
                    <div class="form-group">
                        <label for="akun_user_email">Email *</label>
                        <input id="akun_user_email" type="email"  class="form-control" name="user_email" placeholder="kamu@dimana.domain" required="required">
                    </div>
                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input type="file" name="user_picture" id="nama_file" class="file-upload-default">
                            <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" id="cari" type="button">Cari...</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <input id="submitAkun" type="submit" class="btn btn-small btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="memoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Memo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?= form_open('buat-memo', 'id="formMemo" method="post"');?>
                    <div class="form-group">
                        <label>Kirim ke *</label>
                        <select id="user_ids" name="user_id[]" class="form-control text-dark select2-search" required="required" multiple="multiple">
                            <?php foreach ($this->users as $user) :?>

                            <option value="<?= $user->user_id ?>"><?= $user->real_name ?></option>
                            <?php endforeach;?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Prioritas *</label>
                        <select id="prioritas" name="prioritas" class="form-control text-white" required="required">
                            <option value="biasa">Biasa</option>
                            <option value="khusus">Khusus</option>
                            <option value="mendesak">Mendesak</option>
                            <option value="darurat">Darurat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Judul Memo</label>
                        <input type="text" id="judul_memo" class="form-control" placeholder="Judul Memo" required="required">
                    </div>
                    <div class="form-group">
                        <label>Isi Memo *</label>
                        <textarea name="isi_memo" id="isi_memo" class="form-control" cols="30" rows="10" placeholder="Isi Memo..." required="required"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <input id="submitMemo" type="submit" class="btn btn-small btn-success" name="submit" value="Kirim">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailNotifModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul_memo"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 id="dari"></h6>
                    <p id="isi_memo_lengkap" class="text-justify"></p>
                    <small id="waktu" class="mt-5"></small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>