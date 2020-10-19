<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <title> Login </title>
  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">

</head>
<body>

<div class="container mt-4">
<?php if (!empty($this->session->flashdata('error_login'))) :?>
    <div class="alert alert-warning">
        <p> Mohon maaf password atau username salah </p>
    </div>
<?php endif ?>


    <?= form_open('CApp/CProsesLogin', ['method' => 'POST']) ?>
            <div class="form-group">
                <label>Nama Pengguna</label>
                <input type="text" class="form-control" name="nm_pengguna" placeholder="Nama Pelanggan">
            </div>
            <div class="form-group">
                <label>Password</labl>
                <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
            <input type="submit" class="btn btn-success" value="Login">
    <?= form_close()?>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>