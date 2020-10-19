<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title> Beranda </title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.min.css') ?>">
</head>
<body>

<?php if ($this->session->has_userdata('username')): ?>

	<div class="row">
		<div class="col-md-12">
			<?php $this->load->view('VNavbar') ?>
		</div>
	</div>

    <!-- mengecek apakah berhasil input ke kerangang -->
    <?php if (!empty($this->session->flashdata('status'))): ?>
        <div class="alert alert-warning">
            <?= $this->session->flashdata('status') ?>
        </div>
    <?php endif ?>
    <!-- end cek kerangang -->
    <div class="row">
        <div class="col-md-12">
            <?= $paketan ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $standar ?>
        </div>
    </div>
	 
<?php else: ?>
	<?php $this->load->view('Vlogin') ?>
<?php endif ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>