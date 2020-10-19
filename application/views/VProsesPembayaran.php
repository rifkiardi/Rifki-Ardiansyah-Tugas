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

   <?php if (!empty($this->session->flashdata('status'))): ?>
        <div class="alert alert-warning">
            <?= $this->session->flashdata('status') ?>
        </div>
    <?php endif ?>


    <?php 
        foreach ($data as $d) :?>
            <?= form_open('CApp/CProsesBayar/'.$d['id_transaksi'], ['method' => 'POST']) ?>
    <?php endforeach ?>
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bayar</label>
                                <input type="number" class="form-control" name="bayar" required="">
                            </div> 
                        </div>

                    </div>
                </div>


                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Bayar">
                            </div> 
                        </div>
                    </div>   
                </div>
            <?= form_close()?>
        
    

    <div class="row mt-3">
        <table class="container col-md-9 table table-striped">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total Harga</th>
                <!-- <th>Aksi</th> -->
            </tr>
        </thead>
        <tbody>
        <?php 
        $i=1;
        $a=0;
        foreach ($data as $d) :?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $d['nm_paket'] ?></td>
                <td><?= number_format($d['harga_paket'], 0, ',', '.') ?></td>
                <td><?= $d['qty'] ?></td>
                <td><?= number_format(($d['harga_paket'] * $d['qty']), 2, ',', '.')  ?></td>
<!--                 <td>
                        <a href="<?php echo site_url('CApp/CHapusKeranjang/'.$d['id_detail_transaksi']) ?>" class="btn btn-outline-success" onclick="return confirm('Yakin ingin menghapus')"> Hapus</a>
                </td> -->
            </tr>
            <?php $a = $a + ($d['harga_paket'] * $d['qty']) ?>
        <?php endforeach ?>
            <tr>
                <td colspan="6">Harga Awal : <?= number_format($a, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <th colspan="6">Total bayar : <?= number_format($d['total_harga'], 2, ',', '.') ?> Dengan Diskon : <?= $d['diskon'] ?> % dan Pajak : <?= $d['pajak'] ?> %</th>  
            </tr>
            <tr>
                <th colspan="6">Sudah dibayar sebesar : <?= number_format($d['bayar_transaksi'], 2, ',', '.') ?></th>  
            </tr>
            <tr>
                <th colspan="6">Kembalian/Kurang : <?= number_format( $d['bayar_transaksi'] - $d['total_harga'], 2, ',', '.') ?></th>  
            </tr>
        </tbody>
        </table>

    </div>
	 
<?php else: ?>
	<?php $this->load->view('Vlogin') ?>
<?php endif ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>