<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-3 float-left">Dokumentasi</h4>
                  </div>
                  <div class="card-body">
                    <?= form_open('', 'method="post" id="formCari" accept-charset="utf-8"');?>
                      <div class="form-row">
                        <div class="col-1"><label class="mt-2">Cari</label> </div>
                        <div class="col-4">
                          <input type="text" id="range" name="range" aria-label="Rentang Waktu" placeholder="Rentang Waktu" class="form-control text-white bg-dark" required="required">
                        </div>
                        <div class="col-4">
                          <input type="text" id="kegiatan" class="form-control" placeholder="Judul Kegiatan">
                        </div>
                        <div class="col-3">
                          <button type="submit" id="cari" class="btn btn-md mt-1 pt-2 pb-2 btn-primary"><i class="fas fa-search"></i> Cari</button>
                        </div>
                      </div>
                    </form>
                    <div class="header d-flex flex-column align-items-center mt-5">
                      <h3 class="display-6 mt-3 mb-0" id="judul-kegiatan">Dokumentasi Kegiatan</h3>
                      <small class="mt-2 mb-4" id="daterange">Silakan pilih tanggal dan judul kegiatan untuk melihat dokumentasi</small>
                    </div>
                    <div class="container-sm">
                      <div class="row justify-content-center">
                        <div class="col col-md-10">
                          <div class="gallery-container" id="animated-thumbnails-gallery">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>