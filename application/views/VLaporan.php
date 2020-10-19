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


    <script type="text/javascript" src="<?php echo base_url('assets/datatable/datatable.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/datatable/datatable.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/datatable/datatable.bootstrap4.min.js') ?>"></script>

</head>
<body>

<?php if ($this->session->has_userdata('username')): ?>

	<div class="row">
		<div class="col-md-12">
			<?php $this->load->view('VNavbar') ?>
		</div>
	</div>

   <?php if (!empty($this->session->flashdata('status'))): ?>
        <div class="alert alert-warning">
            <?= $this->session->flashdata('status') ?>
        </div>
    <?php endif ?>
     <?= form_open('CApp/CCariRange', ['method' => 'POST']) ?>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-3">
                     <div class="form-group">
                        <label>Tanggal Awal</label>
                        <input id="min" type="date" class="form-control" name="tgl_awal" required="">
                    </div> 
                </div>
                 <div class="col-md-3">
                     <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input id="max" type="date" class="form-control" name="tgl_akhir" required="">
                    </div> 
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" class="btn btn-outline-success" value="Cari">
                        <a href="<?= site_url('CApp/CPdf') ?>" class="btn btn-outline-success">pdf</a>
                    </div> 
                </div>
            </div>
        </div>
    <?= form_close()?>


    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="tabellaporan" class="table table-striped table-bordered" style="width:100%">
                    <thead align="center">
                        <tr>
                            <th>No</th>
                            <th>Nama Member</th>
                            <th>Alamat</th>
                            <th>Kode Invoice</th>
                            <th>Tanggal Transaksi</th>
                            <th>Tanggal Bayar</th>
                            <th>Batas Waktu</th>
                            <th>Total Harga</th>
                            <th>Status Transaksi</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    $a=0;
                    foreach ($data as $d) :?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $d['nm_member'] ?></td>
                            <td><?= $d['alamat_member'] ?></td>
                            <td><?= $d['kode_invoice'] ?></td>
                            <td><?= $d['tgl_transaksi'] ?></td>
                            <td><?= $d['tgl_bayar'] ?></td>
                            <td><?= $d['batas_waktu'] ?></td>
                            <td><?= $d['total_harga'] ?></td>
                            <td><?= $d['status_transaksi'] ?></td>
                        </tr>
                        <?php $a = $a + $d['total_harga']; ?>
                    <?php endforeach ?>
                    </tbody>
            </table>
            <label><b>Total Pemasukan adalah <?= number_format($a , 0, ',', '.') ?></b></label>
            </div>
        </div>
    </div>

  <script>
              
    $(document).ready(function() {
          var table = $('#tabellaporan').DataTable();
     
          // Add event listeners to the two range filtering inputs
          $('#min').keyup( function() { table.draw(); } );
          $('#max').keyup( function() { table.draw(); } );
      } );
  </script>  
	 
<?php else: ?>
	<?php $this->load->view('Vlogin') ?>
<?php endif ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>