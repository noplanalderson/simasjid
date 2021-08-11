<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="<?= base_url() ?>">
              <img src="<?= site_url('_/images/mosque-icon.png') ?>" alt="<?= $this->app->nama_masjid ?>" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown border-left">
                <a class="nav-link mb-1" id="memo" href="#" data-toggle="dropdown"><i class='fas fa-envelope'></i></a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="memo">
                  <h6 class="p-3 mb-0">Memo</h6>
                  <div class="dropdown-divider"></div>
                  <a href="#" data-toggle="modal" data-target="#memoModal" class="dropdown-item preview-item" id="buat-memo">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-message-plus text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Buat Memo</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a id="memo_masuk" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-inbox-arrow-down text-primary"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Memo Masuk <span class="ml-2 badge badge-danger rounded"><?= $this->memo_unread ?>/<?= $this->memo_in ?></span></p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a id="memo_keluar" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-inbox-arrow-up text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Memo Keluar <span class="ml-2 badge badge-warning rounded"><?= $this->memo_out ?></span></p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a id="trash" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="fas fa-trash-alt text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Trash <span class="ml-2 badge badge-warning rounded"><?= $this->memo_trash ?></span></p>
                    </div>
                  </a>
                </div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Pemberitahuan</h6>
                  <div id="pemberitahuan"></div>
                  <div class="dropdown-divider"></div>
                  <a href="<?= base_url('memo-masuk') ?>" class="dropdown-item"><p class="p-3 mb-0 text-center">Lihat Semua Pemberitahuan</p></a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="<?= site_url('_/uploads/users/'.encrypt($this->session->userdata('uid')).'/'.$this->user->user_picture)?>" alt="<?= $this->user->real_name ?>">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= $this->user->real_name ?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profil</h6>
                  <div class="dropdown-divider"></div>
                  <a id="akun" href="#" data-toggle="modal" data-target="#akunModal" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Pengaturan Akun</p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" id="password" href="#" data-toggle="modal" data-target="#passwordModal">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-key-variant text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Ganti Kata Sandi</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a id="keluar" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Keluar</p>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">