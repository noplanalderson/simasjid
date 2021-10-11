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

                <?= form_open('submit-smtp', 'id="formSmtp"');?>
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                      <label for="protokol">Protokol *</label>
                      <select name="protokol" id="protokol" class="form-control text-white" required="required">
                          <option value="smtp">smtp</option>
                          <option value="sendmail">sendmail</option>
                          <option value="mail">mail</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="smtp_host">SMTP Host *</label>
                      <input type="text" id="smtp_host" name="smtp_host" placeholder="smtp.domain.com" class="form-control" required="required" />
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="smtp_port">SMTP Port *</label>
                      <input type="text" id="smtp_port" name="smtp_port" placeholder="Contoh: 587" class="form-control" pattern="[0-9]{2,5}" required="required" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                      <label for="mode_enkripsi">Mode Enkripsi *</label>
                      <select name="mode_enkripsi" id="mode_enkripsi" class="form-control text-white" required="required">
                          <option value="tls">TLS</option>
                          <option value="ssl">SSL</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="smtp_user">SMTP User *</label>
                      <input type="email" id="smtp_user" name="smtp_user" placeholder="admin@domain.com" class="form-control" required="required"/>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="smtp_password">SMTP Password *</label>
                      <input type="password" id="smtp_password" name="smtp_password" placeholder="********" class="form-control" required="required"/>
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