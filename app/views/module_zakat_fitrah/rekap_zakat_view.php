<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Rekapitulasi Zakat Fitrah</h3>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title float-left mt-3">Rekapitulasi Zakat Fitrah</h4>
                    <div class="form-group form-inline float-right">
                      <label class="mr-4 mt-2 text-white" for="range">Tanggal</label>
                      <input type="text" id="range" name="range" aria-label="Rentang Waktu" placeholder="Rentang Waktu" class="form-control text-white bg-dark">
                      <a id="fullscreen" class="float-right ml-2" title="Fullscreen"><i class="mdi mdi-fullscreen mdi-36px"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                    <h3 class="subtitle"><?= $this->app->nama_masjid ?></h3>
                    <small class="daterange"></small>
                    <div class="table-responsive mt-5">
                      <table class="table table-striped table-bordered w-100" id="tblRekap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bentuk Zakat</th>
                                <th>Zakat Masuk</th>
                                <th>Zakat Keluar</th>
                                <th>Sisa Zakat</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rekap_zakat as $zakat) :?>
                            <tr>
                                <td><?= $zakat->date ?></td>
                                <td><?= strtoupper($zakat->bentuk_zakat) ?> (<?= $zakat->satuan_zakat ?>)</td>
                                <td class="text-right"><?= ($zakat->zakat_masuk === null) ? 0 : (($zakat->bentuk_zakat === 'uang tunai') ? rupiah($zakat->zakat_masuk, true) : $zakat->zakat_masuk) ?></td>
                                <?php $zakat_keluar = $this->zakat_fitrah_m->rekapZakatKeluar($zakat->bentuk_zakat) ?>
                                <td class="text-right"><?= ($zakat_keluar === null) ? 0 : (($zakat->bentuk_zakat === 'uang tunai') ? rupiah($zakat_keluar, true) : $zakat_keluar)?></td>
                                <td class="text-right"><?= ($zakat->bentuk_zakat === 'uang tunai') ? rupiah($zakat->zakat_masuk - $zakat_keluar, true) : $zakat->zakat_masuk - $zakat_keluar?></td>
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