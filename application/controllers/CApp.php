<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CApp extends CI_Controller {


	public function index()
	{
		$this->load->view('VLogin');
	}

	public function CProsesLogin(){
		$pengguna = $this->input->post('nm_pengguna');
		$pass = $this->input->post('pass');
		$role = 'kasir';
		$hasil = $this->MApp->MProsesLogin($pengguna, $pass, $role);
		if ($hasil == false) {
			$this->session->set_flashdata('error_login', true);
			redirect('CApp');
		}
		$hasil2 = array(
			'username' => $hasil['username'],
			'nm_user' => $hasil['nm_user'],
			'id_user' => $hasil['id_user'],
			'id_outlet' => $hasil['id_outlet']
			);
		$this->session->set_userdata($hasil2);
		//$this->session->set_userdata('id_outlet', $hasil2['id_outlet']);

		$this->session->set_flashdata('status', 'Selamat Datang : ' .$hasil2['username']);
		redirect('CApp/CTampilMember');
	}

	public function CTampilMember()
	{
		$id_user = $this->session->userdata('id_user');
		$data = $this->MApp->MTampilMember($id_user);
		$this->load->view('VHome', ['data' => $data]);
	}

	public function CLogout(){
		$this->session->unset_userdata('usename');
		redirect('CApp');
	}
	public function CTambahMember()
	{
		$this->load->view('VTambahMember');
	}
	public function CProsesTambahMember()
	{
		$id_user = $this->session->userdata('id_user');
		$nm_member = $this->input->post('nm_member');
		$tlp_member = $this->input->post('tlp_member');
		$alamat_member = $this->input->post('alamat_member');

		$hasil = $this->MApp->MProsesTambahMember($nm_member, $tlp_member, $alamat_member, $id_user);
		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Berhasil Menambahkan Member ');

		}else {
			$this->session->set_flashdata('status', 'Gagal Menambahkan Member');
		}
		redirect('CApp/CTampilMember');
	}
	public function CHapusMember($id)
	{
		$this->MApp->MHapusMember($id);
		redirect('CApp/CTampilMember');
	}
	public function CEditMember($id)
	{
		$data = $this->MApp->MEditMember($id);
		$this->load->view('VEditMember', ['data' => $data]);
	}
	public function CProsesEditMember($id_member)
	{
		$id = $id_member;
		$nm_member = $this->input->post('nm_member');
		$tlp_member = $this->input->post('tlp_member');
		$alamat_member = $this->input->post('alamat_member');

		$hasil = $this->MApp->MProsesEditMember($nm_member, $tlp_member, $alamat_member, $id);
		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Berhasil Merubah Member ');

		}else {
			$this->session->set_flashdata('status', 'Gagal Merubah Member');
		}
		redirect('CApp/CTampilMember');
	}
	public function CTampilService()
	{
		$ambil_jenis = $this->MApp->MAmbilJenis();
		$id_outlet = $this->session->userdata('id_outlet');


		foreach ($ambil_jenis as $j) {
			if ($j['jenis_paket'] == 'paketan') {
				$paketan = $this->MApp->MTampilPaket('paketan', $id_outlet);
				$paketan2 = $this->load->view('VServicePaket', ['data' => $paketan], true);
			} elseif ($j['jenis_paket'] == 'standar' ) {
				$standar = $this->MApp->MTampilPaket('standar', $id_outlet);
				$standar2 = $this->load->view('VServiceStandar', ['data' => $standar], true);
			}
		}

		$this->load->view('VService', ['standar' => $standar2, 'paketan' => $paketan2]);

	}
	public function CMasukKeranjang($id)
	{
		
		$id_paket = $id;
		$id_user = $this->session->userdata('id_user');
		$qty = $this->input->post('kuantitas');


		$hasil = $this->MApp->MMasukKeranjang($qty, $id_paket, $id_user);
		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Berhasil Masuk Keranjang ');

		}else {
			$this->session->set_flashdata('status', 'Gagal Masuk Keranjang');
		}
		redirect('CApp/CTampilService');
	}
	public function CTampilKeranjang()
	{
		$data = $this->MApp->MTampilKeranjang($this->session->userdata('id_user'));
		$this->load->view('VKeranjang', ['data' => $data]);
	}
	public function CHapusKeranjang($id_detail_transaksi)
	{
		$this->MApp->MHapusKeranjang($id_detail_transaksi);
		redirect('CApp/CTampilKeranjang');
	}
	public function CProsesKeranjang()
	{
		$total_harga = $this->input->post('total_bayar');
		$id_member = $this->input->post('id_member');
		$biaya_tambahan = $this->input->post('biaya_tambahan');
		$pajak = $this->input->post('pajak');
		$diskon = $this->input->post('diskon');
		$keterangan = $this->input->post('keterangan');
		$batas_waktu = $this->input->post('batas_waktu');

		$id_user = $this->session->userdata('id_user');
		$id_outlet = $this->session->userdata('id_outlet');
		
		$hasil = $this->MApp->MProsesKeranjang($id_member, $biaya_tambahan, $pajak, $diskon, $id_user, $id_outlet, $batas_waktu, $total_harga);
		$hasil2 = $this->MApp->MUpdateKeranjang($id_user, $keterangan, $id_member);
		
		$invoice = $this->MApp->MAmbilDataTransaksi($id_member);
		$invoice2 = array(
			'kode_invoice' => $invoice['kode_invoice']
			);

		$updateStatus = $this->MApp->MUpdateStatus($invoice2['kode_invoice']);

		//mengecek klo berhasil checkout atau tidak
		if ($hasil == true) {
			$this->session->set_userdata($invoice2);
			$this->session->set_flashdata('status', 'Berhasil Checkout, dengan Kode Invoice : '.$invoice2['kode_invoice']);

		}else {
			$this->session->set_flashdata('status', 'Gagal Checkout');
		}
		redirect('CApp/CTampilKeranjang');
	}
	public function CTampilPembayaran()
	{
		$id_user = $this->session->userdata('id_user');

		$data = $this->MApp->MTampilPembayaran($id_user);
		$this->load->view('VPembayaran', ['data' => $data]);
	}
	public function CProsesTampilPembayaran($id_transaksi)
	{
		$data = $this->MApp->MProsesTampilBayar($id_transaksi);
		$this->load->view('VProsesPembayaran', ['data' => $data]);
	}
	public function CHapusPembayaran($id_transaksi)
	{
		$data = $this->MApp->MHapusPembayaran($id_transaksi);
		redirect('CApp/CTampilPembayaran');
	}
	public function CProsesBayar($id_transaksi)
	{
		// $sql = $this->App_model->MProsesTampilBayar($id_transaksi);

		// $ambil_total_harga = $sql['total_harga'];
		// $ambil_bayar_transaksi = $sql['bayar_transaksi'];

		$bayar = $this->input->post('bayar');
		$ambil_total_harga = $this->MApp->MAmbilTotal($id_transaksi);
		$total_harga = $ambil_total_harga['total_harga'];
		

		$hasil = $this->MApp->MProsesBayar($id_transaksi, $bayar, $total_harga);




		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Pembayaran Berhasil ');

		}else {
			$this->session->set_flashdata('status', 'Gagal Melakukan Pembayaran');
		}

		redirect('CApp/CProsesTampilPembayaran/'.$id_transaksi);
	}
	public function CTampilSelesai($id_transaksi)
	{
		$hasil = $this->MApp->MTampilSelesai($id_transaksi);

		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Data Berhasil Diperbaharui ');

		}else {
			$this->session->set_flashdata('status', 'Gagal Melakukan Pembaharuan');
		}

		redirect('CApp/CTampilPembayaran/');
	}
	public function CProsesTampilPengambilan($id_transaksi)
	{
		$data = $this->MApp->MProsesTampilBayar($id_transaksi);
		$this->load->view('VProsesPengambilan', ['data' => $data]);
	}
	public function CProsesPengambilan($id_transaksi)
	{
		$hasil = $this->MApp->MProsesPengambilan($id_transaksi);

		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Data Berhasil Diperbaharui ');

		}else {
			$this->session->set_flashdata('status', 'Gagal Melakukan Pembaharuan');
		}

		redirect('CApp/CTampilPembayaran/');
	}
	public function CTampilLaporan()
	{
		$id_user = $this->session->userdata('id_user');

		$data = $this->MApp->MTampilPembayaran($id_user);
		$this->load->view('VLaporan', ['data' => $data]);
	}
	public function CCariRange()
	{
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$id_user = $this->session->userdata('id_user');

		$data = $this->MApp->MCariRange($id_user, $tgl_awal, $tgl_akhir);
		$this->load->view('VLaporan', ['data' => $data]);
	}

	public function CPdf()
	{



	}

}
