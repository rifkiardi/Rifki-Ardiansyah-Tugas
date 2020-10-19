<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title> Tambah  Member</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.min.css') ?>">
</head>
<body>
<div>
<?php if ($this->session->has_userdata('username')): ?>
	<div class="row">
		<div class="col-md-12">
			<?php $this->load->view('VNavbar') ?>
		</div>
	</div>

	<div class="row mt-5">
	<div class="container">
		<?= form_open('CApp/CProsesTambahMember', ['method' => 'POST']) ?>
            <div class="form-group">
                <label>Nama Member</label>
                <input type="text" class="form-control" name="nm_member" required>
            </div>
            <div class="form-group">
                <label>Telp/No Hp</label>
                <input type="number" class="form-control" name="tlp_member" required>
            </div>
            <div class="form-group">
                <label>Alamat Member</label>
                <input type="text" class="form-control" name="alamat_member" required>
            </div>
            <input type="submit" class="btn btn-success" value="Daftar">
    	<?= form_close()?>
    </div>
	</div>
</div>
<?php else: ?>
    <?php $this->load->view('Vlogin') ?>
<?php endif ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>