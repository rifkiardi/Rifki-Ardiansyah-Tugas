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

    <div class="row mt-3">
        <table class="container col-md-9 table table-striped">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total Harga</th>
                <th>Aksi</th>
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
                <td>
                    <a href="<?php echo site_url('CApp/CHapusKeranjang/'.$d['id_detail_transaksi']) ?>" class="btn btn-outline-success" onclick="return confirm('Yakin ingin menghapus')"> Hapus</a>
                </td>
            </tr>
            <?php $a = $a + ($d['harga_paket'] * $d['qty']) ?>
        <?php endforeach ?>

        </tbody>
        </table>
    </div>


    <?= form_open('CApp/CProsesKeranjang', ['method' => 'POST']) ?>
        <div class="container">
        <hr>
            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="form-group">
                         <label>Id Member</label>
                         <input type="text" class="form-control" name="id_member" placeholder="Id Member" required>
                     </div>
                    <div class="form-group">
                        <label>Biaya Tambahan</label>
                        <input type="number" class="form-control" name="biaya_tambahan" required id="biaya_tambahan" onchange="prosesHarga();">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pajak</label>
                        <input type="number" class="form-control" name="pajak" required id="pajak" onchange="prosesHarga();">
                    </div>
                    <div class="form-group">
                        <label>Diskon</label>
                        <input type="number" class="form-control" name="diskon" required id="diskon" onchange="prosesHarga();">
                    </div>      
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type=text class="form-control" name="keterangan">
                    </div>
                    <div class="form-group">
                        <label>Batas Waktu</label>
                        <input type="date" class="form-control" name="batas_waktu" placeholder="0" required>
                    </div>                       
                </div>

            </div>
        </div>

        <!-- mengambil nilai total -->
        <input type=text class="form-control" id="total" name="total" hidden value="<?= $a ?>">

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Total Bayar</label>
                        <input type=text class="form-control" id="total_bayar" name="total_bayar" readonly >
                    </div>  
                </div>
                
            </div>   
        </div>  

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Checkout">
                    </div> 
                </div>
                
            </div>  
         <hr>
        </div>            
    <?= form_close()?>

    <script>
        function prosesHarga() {
            var biaya_tambahan = document.getElementById('biaya_tambahan').value;
            var pajak = document.getElementById('pajak').value;
            var diskon = document.getElementById('diskon').value;
            var total = document.getElementById("total").value;

            document.getElementById('total_bayar').value = (parseInt(biaya_tambahan) + (parseInt(total) * parseFloat(pajak)/100) + parseInt(total)) - (parseInt(total) * parseFloat(diskon)/100);
        }
    </script>
    


     
<?php else: ?>
    <?php $this->load->view('Vlogin') ?>
<?php endif ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>