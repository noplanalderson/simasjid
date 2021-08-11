<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Pengaturan SMTP </h3>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    
                    <h4 class="card-title mt-2">Pengaturan SMTP</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <?= form_open('pengaturan-smtp/submit', 'id="formSmtp"');?>
                            <div class="row">
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="protokol">Protokol *</label>
                                  <select name="protokol" id="protokol" class="form-control text-white" required="required">
                                      <option value="smtp" <?php if($smtp['protocol'] == 'smtp') :?>selected="selected"<?php endif;?>>smtp</option>
                                      <option value="sendmail" <?php if($smtp['protocol'] == 'sendmail') :?>selected="selected"<?php endif;?>>sendmail</option>
                                      <option value="mail" <?php if($smtp['protocol'] == 'mail') :?>selected="selected"<?php endif;?>>mail</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-8">
                                <div class="form-group">
                                  <label for="smtp_host">SMTP Host *</label>
                                  <input type="text" id="smtp_host" name="smtp_host" placeholder="smtp.domain.com" class="form-control" value="<?= $smtp['smtp_host'] ?>" required="required" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="smtp_port">SMTP Port *</label>
                                  <input type="text" id="smtp_port" name="smtp_port" placeholder="Contoh: 587" class="form-control" pattern="[0-9]{2,5}" value="<?= $smtp['smtp_port'] ?>" required="required" />
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="smtp_user">SMTP User *</label>
                                  <input type="email" id="smtp_user" name="smtp_user" placeholder="admin@domain.com" class="form-control" value="<?= $smtp['smtp_user'] ?>" required="required"/>
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="smtp_password">SMTP Password *</label>
                                  <input type="password" id="smtp_password" name="smtp_password" placeholder="********" class="form-control" value="<?= $smtp['smtp_pass'] ?>" required="required"/>
                                </div>
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