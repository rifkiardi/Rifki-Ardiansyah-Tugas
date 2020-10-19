<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
    <title> Beranda </title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/jquery.dataTables.min.css') ?>">
    <script type="text/javascript" src="<?php echo base_url('assets/datatables/jquery-3.5.1.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>

    
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
	
	<div class="container">
		<div class="row mt-3">
			<div class="col-md-12">
				<table id="tabelmember" class="display" style="width:100%">
				<thead align="center">
					<tr>
						<th>No</th>
						<th>Nama Member</th>
						<th>No Telp</th>
						<th>Alamat</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$i=1;
				foreach ($data as $d) :?>
					<tr>
						<td><?= $i++ ?></td>
						<td><?= $d['nm_member'] ?></td>
						<td><?= $d['tlp_member'] ?></td>
						<td><?= $d['alamat_member'] ?></td>
						<td align="center">
							<a href="<?php echo site_url('CApp/CEditMember/'.$d['id_member']) ?>" class="btn btn-outline-success">Edit </a>
							<a href="<?php echo site_url('CApp/CHapusMember/' . $d['id_member']) ?>" class="btn btn-outline-success" onclick="return confirm('Yakin ingin menghapus')"> Hapus</a>
						</td>
					</tr>
				<?php endforeach ?>
				</tbody>
				</table>
			</div>
		</div>
	</div>


	  <script>   
	        $(document).ready(function() {
	            $('#tabelmember').DataTable();
	        } );
 	   </script> 


	<div class="row">
		<div class="container col-md-9">
			<a href="<?php echo site_url('CApp/CTambahMember') ?>" class="btn btn-success"> Tambah Member</a>
		</div>
	</div>
<?php else: ?>
	<?php $this->load->view('Vlogin') ?>
<?php endif ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>