<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-12">
                <!-- Sidebar -->
                <div class="w3-bar-block bg-dark text-white rounded mb-lg-0 mb-sm-4 mb-xs-4 mt-2">
                  <h3 class="w3-bar-item border-bottom pt-4 pb-4">Trash</h3>
                  <a class="w3-bar-item w3-button w3-hover-grey pt-3 pb-3 memo-link" data-href="masuk">
                    <i class="img-xs rounded-circle float-left mdi mdi-inbox-arrow-down icon-md text-primary"></i>
                    <div class="preview-item-content float-left ml-2">
                      <h6 class="preview-subject mt-3">Memo Masuk</h6>
                    </div>
                  </a>
                  <a class="w3-bar-item w3-button w3-hover-grey pt-3 pb-3 memo-link" data-href="keluar">
                    <i class="img-xs rounded-circle float-left mdi mdi-inbox-arrow-up icon-md text-warning"></i>
                    <div class="preview-item-content float-left ml-2">
                      <h6 class="preview-subject mt-3">Memo Keluar</h6>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-lg-9 col-md-8 col-sm-12">
                <!-- Page Content -->
                <div class="w-100 h-100 mt-2">

                  <div class="w3-container bg-dark rounded-top border-bottom">
                    <h3 class="w3-bar-item pt-4 pb-3 memo-flow float-left">Memo</h3>
                    <div id="kosongkan-trash"></div>
                  </div>
                  <div class="card-body rounded-bottom bg-dark">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="tblMemo">
                        <thead>
                          <tr>
                            <th width="25%">Tanggal</th>
                            <th>Flow</th>
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
        