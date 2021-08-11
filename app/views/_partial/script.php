<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

		<!-- js -->
		<?= js('core.min') ?>
		
		<?php $this->_CI->load_js_plugin() ?>
		
		<?= plugin('select2/select2.min', 'js');?>
		
		<script src="https://unpkg.com/sweetalert2@7.24.1/dist/sweetalert2.js"></script>
		
		<?= js('toaster') ?>

		<?= empty($this->session->userdata('uid')) ? '' : js('app-dev') ?>

		<?php $this->_CI->load_js() ?>

		<?= $custom_js; ?>
		
	</body>
</html>