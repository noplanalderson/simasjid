<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Audit </h3>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-3 float-left">Log Kas</h4>
                    <div class="form-group form-inline float-right">
                      <label class="mr-4 mt-2 text-white" for="range">Rentang Waktu</label>
                      <?= form_open('audit-kas', 'id="formPeriode"'); ?>
                        <input type="text" id="range" name="range" aria-label="Rentang Waktu" placeholder="Rentang Waktu" class="form-control text-white bg-dark">
                      </form>
                      <a id="fullscreen" class="float-right ml-2" title="Fullscreen"><i class="mdi mdi-fullscreen mdi-36px"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                    <h3 class="subtitle"><?= $this->app->nama_masjid ?></h3>
                    <small class="daterange"></small>
                    <div class="table-responsive mt-5">
                      <table class="table table-striped table-bordered w-100" id="tblLogKas">
                        <thead>
                            <tr>
                              <th>Waktu Log</th>
                              <th>Kode Transaksi</th>
                              <th>Aksi</th>
                              <th>Tanggal Transaksi</th>
                              <th>Petugas</th>
                              <th>Kategori</th>
                              <th>Pemasukan</th>
                              <th>Pengeluaran</th>
                              <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                              <th>Waktu Log</th>
                              <th>Kode Transaksi</th>
                              <th>Aksi</th>
                              <th>Tanggal Transaksi</th>
                              <th>Petugas</th>
                              <th>Kategori</th>
                              <th>Pemasukan</th>
                              <th>Pengeluaran</th>
                              <th>Keterangan</th>
                            </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>