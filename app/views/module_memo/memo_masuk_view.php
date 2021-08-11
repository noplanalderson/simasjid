<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-12">
                <!-- Sidebar -->
                <div class="w3-bar-block bg-dark text-white rounded mb-lg-0 mb-sm-4 mb-xs-4 mt-2">
                  <h3 class="w3-bar-item border-bottom pt-4 pb-4">Pengirim</h3>
                  <?php foreach ($memo_masuk as $memo) :?>
                
                  <a class="w3-bar-item w3-button w3-hover-blue pt-3 pb-3 memo-link" data-id="<?= encrypt($memo->dari) ?>">
                    <img class="img-xs rounded-circle float-left" src="<?= site_url('_/uploads/users/'.encrypt($memo->dari).'/'.$memo->user_picture)?>" alt="<?= $memo->real_name ?>">
                    <div class="preview-item-content float-left ml-3">
                      <h6 class="preview-subject mt-2"><?= $memo->real_name ?></h6>
                    </div>
                  </a>
                  <?php endforeach;?>
                
                </div>
              </div>
              <div class="col-lg-9 col-md-8 col-sm-12">
                <!-- Page Content -->
                <div class="w-100 h-100 mt-2">

                  <div class="w3-container bg-dark rounded-top border-bottom">
                    <h3 class="w3-bar-item pt-4 pb-3 memo-dari float-left">Memo Masuk</h3>
                    <div id="hapus-semua"></div>
                  </div>
                  <div class="card-body rounded-bottom bg-dark">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="tblMemo">
                        <thead>
                          <tr>
                            <th width="25%">Tanggal</th>
                            <th>Prioritas</th>
                            <th width="50%">Judul Memo</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        