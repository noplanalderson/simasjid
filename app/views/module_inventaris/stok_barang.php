<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Inventarisasi </h3>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title float-left mt-2">Stok Barang</h4>
                  </div>
                  <div class="card-body">
                    <h3 class="subtitle"><?= $this->app->nama_masjid ?></h3>
                    <small class="daterange"></small>
                    <div class="table-responsive mt-5">
                      <table class="table table-striped table-bordered w-100" id="tblBarang">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kuantitas Masuk</th>
                                <th>Kuantitas Keluar</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($stok_brg as $brg) :?>
                            <tr>
                                <td><?= $brg['nama_barang'] ?></td>
                                <td class="text-right"><?= $brg['stok_in'] ?> <?= $brg['satuan'] ?></td>
                                <td class="text-right"><?= $brg['stok_out'] ?> <?= $brg['satuan'] ?></td>
                                <td class="text-right"><?= $brg['stok_in'] - $brg['stok_out'] ?> <?= $brg['satuan'] ?></td>
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