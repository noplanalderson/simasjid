<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Manajemen User </h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'class="btn btn-sm tambah-user btn-primary" data-toggle="modal" data-target="#userModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Daftar User</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered w-100" id="tblUser">
                        <thead>
                            <tr>
                                <th>Nama Petugas</th>
                                <th>Username</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user) :?>
                            <tr>
                                <td><?= $user->real_name ?></td>
                                <td><?= $user->user_name ?></td>
                                <td><?= $user->nama_jabatan ?></td>
                                <td><?= $user->user_email ?></td>
                                <td><?= ($user->is_active === '1') ? 'Aktif' : 'Non Aktif'; ?></td>
                                <td>
                                    <?= button($btn_edit, FALSE, 'button', 'data-id="'.encrypt($user->user_id).'" class="btn btn-sm btn-warning edit-user" data-toggle="modal" data-target="#userModal"');?>

                                    <?= button($btn_del, FALSE, 'button', 'data-id="'.encrypt($user->user_id).'" class="btn btn-sm btn-danger delete-btn"');?>
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

      <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="User" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="accessAction"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'method="post" id="userForm" accept-charset="utf-8"');?>
              <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="id_user" id="id_user" value="">
                      <div class="form-group">
                          <label for="user_name">Username *</label>
                          <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Username" data-parsley-pattern="^[A-Za-z0-9_]{1,15}$" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="user_email">Email *</label>
                          <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Email User" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <label>Nama Petugas *</label>
                      <input type="text" id="real_name" name="real_name" placeholder="Nama Petugas" class="form-control" required="required"/>
                      <small class="text-danger">Hanya Huruf, titik, koma, dan Spasi</small>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="user_password my-2">Kata Sandi *</label>
                    <div class="input-group">
                        <input id="user_password" 
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
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="user_password my-2">Ulangi Kata Sandi *</label>
                    <div class="input-group">
                        <input id="repeat_password" type="password" class="form-control" placeholder="********" name="repeat_password" autocomplete="off">
                        <div class="input-group-prepend">
                            <span class="input-group-text show-btn-repeat"><i class="fa fa-eye repeat"></i></span>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-1">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="id_jabatan">Jabatan *</label>
                          <select id="id_jabatan" class="form-control text-white" name="id_jabatan" required="required">
                              <option value="">Pilih Jabatan</option>
                              <?php foreach ($jabatan as $j) :?>

                                  <option value="<?= $j->id_jabatan ?>"><?= $j->nama_jabatan ?></option>
                              
                              <?php endforeach;?>
                          </select>
                      </div>
                  </div>
                  <div id="is_active_box" class="col-md-6">
                      <input class="my-3 mt-5" id="is_active" type="checkbox" name="is_active" value="1"><label for="is_active" class="ml-1">Aktivasi User</label>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
                <input type="submit" id="submitUser" class="my-3 btn btn-small btn-success" name="submit" value="Submit">
                </form>
            </div>
          </div>
        </div>
      </div>