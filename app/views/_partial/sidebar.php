<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <body>
      <div class="container-scroller">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo ml-4 w-100" href="<?= base_url() ?>"><img src="<?= site_url('_/images/simasjid_logo.png') ?>" alt="<?= $this->app->nama_masjid ?>" /></a>
            <a class="sidebar-brand brand-logo-mini" href="<?= base_url() ?>"><img src="<?= site_url('_/images/mosque-icon.png') ?>" alt="<?= $this->app->nama_masjid ?>" /></a>
          </div>
          <ul class="nav">
            <li class="nav-item profile">
              <div class="profile-desc">
                <div class="profile-pic">
                  <div class="count-indicator">
                    <img class="img-xs rounded-circle " src="<?= site_url('_/uploads/users/'.encrypt($this->session->userdata('uid')).'/'.$this->user->user_picture) ?>" alt="<?= $this->user->real_name ?>">
                    <span class="count bg-success"></span>
                  </div>
                  <div class="profile-name">
                    <h5 class="mb-0 font-weight-normal"><?= $this->user->real_name ?></h5>
                    <span><?= $this->user->nama_jabatan ?></span>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item nav-category">
              <span class="nav-link">Navigasi</span>
            </li>
            <?php 
              foreach ($this->menus as $menu) :

              $submenus = $this->app_m->getSubMenu($menu->menu_id);
              if(empty($submenus)) {
            ?>

            <li class="nav-item menu-items">
              <a class="nav-link" href="<?= base_url($menu->menu_link) ?>">
                <span class="menu-icon">
                  <i class="<?= $menu->menu_icon ?>"></i>
                </span>
                <span class="menu-title"><?= $menu->menu_label ?></span>
              </a>
            </li>
            <?php } else { ?>

            <li class="nav-item menu-items">
              <a class="nav-link" data-toggle="collapse" href="<?= $menu->menu_link ?>" aria-expanded="false" aria-controls="<?= ltrim($menu->menu_link, '#') ?>">
                <span class="menu-icon">
                  <i class="<?= $menu->menu_icon ?>"></i>
                </span>
                <span class="menu-title"><?= $menu->menu_label ?></span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="<?= ltrim($menu->menu_link, '#') ?>">
                <ul class="nav flex-column sub-menu">
                  <?php foreach ($submenus as $submenu): ?>

                  <li class="nav-item"> <a class="nav-link" href="<?= base_url($submenu->menu_link) ?>"><?= $submenu->menu_label ?></a></li>
                  <?php endforeach; ?>

                </ul>
              </div>
            </li>
            <?php } endforeach;?>
          
          </ul>
        </nav>