  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto bg-transparan">
              <div class="card-body px-4 py-4">
                <div class="text-center">
                  <?= show_image('sites/'.$this->app->icon_masjid, 'image', 'width="100px"') ?>

                  <h5 class="card-title mb-5 mt-2"><?= $this->app->nama_masjid ?></h5>
                </div>
                
                <?= form_open('lupa-kata-sandi/submit', 'id="formLupa"');?>
                  <div class="form-group">
                    <input type="email" id="user_email" class="form-control p_input" placeholder="Alamat Email" required="required" autocomplete="off">
                  </div>
                  <div class="text-center">
                    <div class="row mt-4">
                      <div class="col-md-6">
                        <a href="<?= base_url('masuk') ?>" class="btn btn-secondary btn-block btn-md pt-2 pb-2 mt-2">Coba Masuk</a>
                      </div>
                      <div class="col-md-6">
                        <button type="submit" id="submit" name="masuk" class="btn btn-primary btn-md btn-block pt-2 pb-2 mt-2">Reset</button>
                      </div> 
                    </div>
                  </div>
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