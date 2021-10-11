<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Sistem Manajemen Masjid">
    <meta name="author" content="debu_semesta">
    <meta name="X-CSRF-TOKEN" content="<?= $this->security->get_csrf_hash();?>">
    
    <base href="<?= rtrim(base_url(), '/') ?>">
    
    <title><?= $title ?></title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= site_url('_/images/mosque-icon.png') ?>">

    <!-- Core -->
    <?= css('style.min') ?>
      
    <?php $this->_CI->load_css() ?>
    
    <?php $this->_CI->load_css_plugin() ?>

    <?= plugin('sweetalert2/dist/sweetalert2.min');?>

    <?= css('app-prod.min') ?>

    <style nonce="<?= NONCE ?>">
    
      .swal2-popup {
          display: none;
          position: relative;
          flex-direction: column;
          justify-content: center;
          width: 32em;
          max-width: 100%;
          padding: 1.25em;
          border-radius: 0.3125em;
          background: #3a3a3a;
          font-family: inherit;
          font-size: 1rem;
          box-sizing: border-box;
      }

      .swal2-popup #swal2-content {
          text-align: center;
          color: #fff;
      }

      .swal2-popup #swal2-title {
          text-align: center;
          color: #fff;
      }
    </style>
</head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth install-bg">
            <div class="card col-lg-8 mx-auto bg-transparan">
              <div class="card-body px-4 py-4">
                <div class="text-center">
                  <img class="logo-simasjid" src="<?= site_url('_/images/mosque-icon.png') ?>" alt="Logo Simasjid">

                  <h5 class="card-title mb-5 mt-2">SIMASJID Versi <?= SIMASJID_VERSION ?></h5>
                </div>

                <?= form_open('submit-masjid', 'id="formMasjid"');?>
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="nama_masjid">Nama Masjid *</label>
                      <input type="text" class="form-control" id="nama_masjid" name="nama_masjid" placeholder="Nama Masjid">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="email_masjid">Email Masjid *</label>
                      <input type="email" class="form-control" id="email_masjid" name="email_masjid" placeholder="Email Masjid">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="telepon_masjid">Telepon Masjid *</label>
                      <input type="text" class="form-control" id="telepon_masjid" name="telepon_masjid" placeholder="Telepon Masjid (Contoh: +62xxxx / 021xxx)">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="alamat_masjid">Alamat Masjid *</label>
                      <textarea class="form-control" id="alamat_masjid" name="alamat_masjid" rows="4" placeholder="Alamat Masjid"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label>Logo Masjid *</label>
                      <input type="file" name="logo_masjid" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Cari...</button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Icon Aplikasi *</label>
                      <input type="file" name="icon_masjid" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Cari...</button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" id="submit" name="masuk" class="btn btn-primary btn-md btn-block pt-2 pb-2 mt-2">Submit</button>
                <div class="text-center mt-3">
                  <small class="text-white-50">Copyright &copy; 2021 - SIMASJID App by Debu Semesta</small>
                </div>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
  </body>