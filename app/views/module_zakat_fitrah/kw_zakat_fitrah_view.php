<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Zakat Fitrah </h3>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div id="zakat-fitrah-card" class="card">
                  <div class="card-header">

                    <div class="page-tools float-right">
                        <div class="action-buttons">
                            <button class="btn btn-light mx-1px text-95" id="btn-print" type="button" data-title="PDF">
                                <i class="mr-1 fas fa-print text-danger text-120 w-2"></i>
                                Cetak
                            </button>
                        </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="page-content container" id="area-kwitansi">
                        <div class="page-header text-blue-d2">
                            <h1 class="kwitansi-title text-secondary-d1">
                                Kode Transaksi
                                <small class="page-info">
                                    <i class="fa fa-angle-double-right text-80"></i>
                                    <?= $transaksi->kode_transaksi ?>
                                </small>
                            </h1>
                        </div>

                        <div class="container px-0">
                            <div class="row mt-4">
                                <div class="col-12 col-lg-10 offset-lg-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-center text-150">
                                              <h3>Kwitansi <?= $status ?> Zakat Fitrah</h3>
                                              <h4><?= $this->app->nama_masjid ?></h4>
                                              <p><?= $this->app->alamat_masjid ?> - Telp: <?= $this->app->telepon_masjid ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .row -->

                                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div>
                                                <span class="text-sm text-grey-m2 align-middle">Nama:</span>
                                                <span class="text-600 text-110 text-blue align-middle"><span id="atas-nama"><?= $transaksi->atas_nama  ?></span></span>
                                            </div>
                                            <div class="text-grey-m2">
                                                <div class="my-1">
                                                    <?= $transaksi->alamat ?>
                                                </div>
                                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?= $transaksi->no_telepon ?></b></div>
                                            </div>
                                        </div>
                                        <!-- /.col -->

                                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                            <hr class="d-sm-none" />
                                            <div class="text-grey-m2">
                                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                                    Kwitansi
                                                </div>

                                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> <span id="kode-transaksi"><?= $transaksi->kode_transaksi ?></span></div>

                                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Tanggal:</span> <?= indonesian_date($transaksi->date) ?></div>

                                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <span class="badge badge-success badge-pill px-25">Diterima</span></div>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>

                                    <div class="mt-4">
                                        
                                <div class="table-responsive">
                                    <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                        <thead class="bg-none bgc-default-tp1">
                                            <tr class="text-white">
                                                <th class="opacity-2">#</th>
                                                <th width="50%">Bentuk Zakat</th>
                                                <th>Jumlah Jiwa</th>
                                                <th>Jumlah Zakat/Jiwa</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody class="text-95 text-secondary-d3">
                                            <tr></tr>
                                            <tr>
                                                <td>1</td>
                                                <td><?= ucwords($transaksi->bentuk_zakat) ?></td>
                                                <td><?= $transaksi->jumlah_jiwa ?></td>
                                                <td class="text-95"><?= ($transaksi->satuan_zakat === 'RUPIAH') ? rupiah($transaksi->jumlah_zakat/$transaksi->jumlah_jiwa) : $transaksi->jumlah_zakat/$transaksi->jumlah_jiwa ?></td>
                                                <td class="text-secondary-d2"><?= ($transaksi->satuan_zakat === 'RUPIAH') ? rupiah($transaksi->jumlah_zakat) : $transaksi->jumlah_zakat; ?></td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                                

                                        <div class="row border-b-2 brc-default-l2"></div>

                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                                <img src="<?= encodeImage(FCPATH . '_/uploads/qrcode/'.$this->uri->segment(2).'.png')?>" alt="<?= $transaksi->kode_transaksi ?>">
                                            </div>

                                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">

                                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                                    <div class="col-7 text-right">
                                                        Total Dibayar/Diterima
                                                    </div>
                                                    <div class="col-5">
                                                        <span class="text-150 text-success-d3 opacity-2"><?= ($transaksi->satuan_zakat === 'RUPIAH') ? rupiah($transaksi->jumlah_zakat) : $transaksi->jumlah_zakat.' '.strtolower($transaksi->satuan_zakat); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr />

                                        <div>
                                            <span class="text-secondary-d1 text-105"><small>Petugas : <?= $transaksi->real_name ?></small></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>