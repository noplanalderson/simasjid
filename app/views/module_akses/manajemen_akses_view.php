<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Manajemen Akses </h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'href="#" class="btn-sm add-access btn-primary float-right" data-toggle="modal" data-target="#accessModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Daftar Tipe Akses</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="access_lists" class="table table-striped table-bordered">
                        <thead>
                          <tr class="text-center">
                            <th>Tipe Akses</th>
                            <th>Role</th>
                            <th>Halaman Index</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($user_type as $type) :?>

                          <tr>
                            <td><?= $type->type_name;?></td>
                            <td class="text-wrap"><?= $this->akses_m->getDaftarAkses($type->type_id);?></td>
                            <td>
                              <select name="index_page" class="index_page bg-dark text-white" data-id="<?= encrypt($type->type_id) ?>" required>
                                <option value="">Index Page</option>
                                <?php foreach ($this->akses_m->getIndexPage($type->type_id) as $index) :?>
                                
                                <option value="<?= $index->menu_link ?>" <?php if($type->index_page === $index->menu_link):?>selected=""<?php endif;?>><?= $index->menu_label ?></option>
                                <?php endforeach; ?>
                              
                              </select>
                            </td>
                            <td>
                              <?= button($btn_edit, FALSE, 'a', 'href="#" class="btn btn-small btn-warning edit-access" data-toggle="modal" data-target="#accessModal" data-id="'.encrypt($type->type_id).'"');?>
                              <?= button($btn_delete, FALSE, 'button', 'href="#" data-id="'.encrypt($type->type_id).'" class="btn delete-btn btn-small btn-danger"');?>
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

      <div class="modal fade" id="accessModal" tabindex="-1" role="dialog" aria-labelledby="Access Management" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="accessAction"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

              <?= form_open('', 'id="accessForm" method="post"');?>

              <input type="hidden" id="type_id" name="type_id" value="">

              <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Tipe Akses *</label>
                <div class="col-sm-12 col-md-10">
                  <input type="text" id="type_code" name="type_code" class="form-control bg-dark text-white" placeholder="Access Type" required="required">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Role *</label>
                <div class="col-sm-12 col-md-10">
                  <select id="menu_id" name="menu_id[]" class="form-control text-dark select2-search" required="required" multiple="multiple">
                  <?php foreach ($menus as $menu) :?>
                    
                    <option value="<?= $menu->menu_id ?>"><?= $menu->menu_label ?></option>
                  <?php endforeach;?>
                  
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
              <button id="submit" class="btn btn-success" type="submit" name="submit"></button>
              </form>
            </div>
          </div>
        </div>
      </div>