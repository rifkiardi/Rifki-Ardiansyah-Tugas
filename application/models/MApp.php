<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MApp extends CI_Model {

public function MProsesLogin($pengguna, $pass, $role)
	{
		$sql = $this->db->get_where('tb_user',[
			'username' => $pengguna,
			'password' => $pass,
			'role' => $role
			]);
		if($sql->num_rows() < 1){
			return false;
		}else {
			return $sql->row_array();
		}
	}
	public function MTampilMember($id_user)
	{
		$this->db->where('id_user', $id_user);
		return $this->db->get('tb_member')->result_array();
	}
	public function MProsesTambahMember($nm_member, $tlp_member, $alamat_member, $id_user)
	{
		return $this->db->insert('tb_member', [
			'nm_member' => $nm_member,
			'tlp_member' => $tlp_member,
			'alamat_member' => $alamat_member,
			'id_user' => $id_user
			]) > 0;
	}
	public function MHapusMember($id)
	{
		$this->db->where('id_member', $id);
		return $hasil = $this->db->delete('tb_member');
	}
	public function MEditMember($id)
	{
		$this->db->where('id_member', $id);
		return $hasil = $this->db->get('tb_member')->row_array();
	}
	public function MProsesEditMember($nm_member, $tlp_member, $alamat_member, $id)
	{
		$this->db->where('id_member', $id);
		return $hasil = $this->db->update('tb_member',[
			'id_member' => $id,
			'nm_member' => $nm_member,
			'tlp_member' => $tlp_member,
			'alamat_member' => $alamat_member
		]) > 0;
	}
	public function MAmbilJenis()
	{
		return $hasil = $this->db->get('tb_paket')->result_array();
	}
	public function MTampilPaket($jenis_paket, $id_outlet)
	{
		$arrayName = array('jenis_paket' => $jenis_paket, 'id_outlet' => $id_outlet );
		$this->db->where($arrayName);
		return $hasil = $this->db->get('tb_paket')->result_array();
	}
	public function MMasukKeranjang($qty, $id_paket, $id_user)
	{

		return $this->db->insert('tb_detail_transaksi', [
			'qty' => $qty,
			'id_paket' => $id_paket,
			'status_detail' => 'dikeranjang',
			'id_user' => $id_user
			]) > 0;
	}
	public function MTampilKeranjang($id_user)
	{
		return $this->db
		->select('tb_detail_transaksi.*, tb_paket.*')
		->from('tb_paket')
		->join('tb_detail_transaksi', 'tb_detail_transaksi.id_paket = tb_paket.id_paket')
		->where('tb_detail_transaksi.status_detail', 'dikeranjang')
		->where('tb_detail_transaksi.id_user', $id_user)
		->get()
		->result_array();
	}
	public function MHapusKeranjang($id_detail_transaksi)
	{
		$this->db->where('id_detail_transaksi', $id_detail_transaksi);
		return $hasil = $this->db->delete('tb_detail_transaksi');
	}
	public function MProsesKeranjang($id_member, $biaya_tambahan, $pajak, $diskon, $id_user, $id_outlet, $batas_waktu, $total_harga)
	{
			return $this->db->insert('tb_transaksi', [
			'id_outlet' => $id_outlet,
			'kode_invoice' => uniqid(),
			'id_member' => $id_member,
			'tgl_transaksi' => date('Y-m-d'),
			'batas_waktu' => $batas_waktu,
			'tgl_bayar' => '',
			'biaya_tambahan' => $biaya_tambahan,
			'diskon' => $diskon,
			'pajak' => $pajak,
			'status_transaksi' => 'baru',
			'status_pembayaran' => 'belum bayar',
			'id_user' => $id_user,
			'total_harga' =>$total_harga
			]) > 0;
	}
	public function MUpdateKeranjang($id_user, $keterangan, $id_member)
	{
		$sql = $this->db->get_where('tb_transaksi', [
			'id_member' => $id_member,
			'status_transaksi' => 'baru'
			])->row_array();

		$dikeranjang = 'dikeranjang';
		$array = array('id_user' => $id_user, 'status_detail' => $dikeranjang);
		$this->db->where($array);
		return $hasil = $this->db->update('tb_detail_transaksi',[
			'id_transaksi' => $sql['id_transaksi'],
			'keterangan' => $keterangan,
			'status_detail' => 'ditransaksi'
		]) > 0;
	}
	public function MAmbilDataTransaksi($id_member)
	{
		
		return $sql = $this->db->get_where('tb_transaksi', [
			'id_member' => $id_member,
			'status_transaksi' => 'baru'
			])->row_array();
		
	}
	public function MUpdateStatus($kode_invoice)
	{
		$array = array('kode_invoice' => $kode_invoice, 'status_transaksi' => 'baru' );
		$this->db->where($array);
		return $hasil = $this->db->update('tb_transaksi',[
			'status_transaksi' => 'proses'
			]) > 0;
	}
	public function MTampilPembayaran($id_user)
	{
		$this->db->order_by('status_pembayaran', 'DeSC');
		return $this->db
		->select('tb_member.*, tb_transaksi.*')
		->from('tb_transaksi')
		->join('tb_member', 'tb_transaksi.id_member = tb_member.id_member')
		->where('tb_transaksi.id_user', $id_user)
		->get()
		->result_array();
	}
	public function MProsesTampilBayar($id_transaksi)
	{
		return $this->db
		->select('tb_transaksi.*, tb_detail_transaksi.*, tb_paket.*, tb_member.*')
		->from('tb_detail_transaksi')
		->join('tb_paket', 'tb_detail_transaksi.id_paket = tb_paket.id_paket')
		->join('tb_transaksi', 'tb_transaksi.id_transaksi = tb_detail_transaksi.id_transaksi')
		->join('tb_member', 'tb_member.id_member = tb_transaksi.id_member')
		->where('tb_detail_transaksi.id_transaksi', $id_transaksi)
		->get()
		->result_array();

	}
	public function MHapusPembayaran($id_transaksi)
	{
		$this->db->delete('tb_detail_transaksi', array('id_transaksi' => $id_transaksi));
		$this->db->delete('tb_transaksi', array('id_transaksi' => $id_transaksi));
	}
	public function MAmbilTotal($id_transaksi)
	{
		$this->db->where('id_transaksi', $id_transaksi);
		return $this->db->get('tb_transaksi')->row_array();
	}
	public function MProsesBayar($id_transaksi, $bayar, $total_harga)
	{
		$this->db->where('id_transaksi', $id_transaksi);

		if ($bayar >= $total_harga) {
				return $hasil = $this->db->update('tb_transaksi',[
				'bayar_transaksi' => $bayar,
				'status_pembayaran' => 'dibayar',
				'tgl_bayar' => date('Y-m-d h:i:sa')
			]) > 0;
		} else {
			return $hasil = $this->db->update('tb_transaksi',[
				'bayar_transaksi' => $bayar,
				'status_pembayaran' => 'dp',
				'tgl_bayar' => date('Y-m-d h:i:sa')
			]) > 0;
		}
	}
	public function MTampilSelesai($id_transaksi)
	{
		$this->db->where('id_transaksi', $id_transaksi);
		return $hasil = $this->db->update('tb_transaksi',[
			'status_transaksi' => 'selesai'
		]) > 0;
	}
	public function MProsesPengambilan($id_transaksi)
	{
		$this->db->where('id_transaksi', $id_transaksi);
		return $hasil = $this->db->update('tb_transaksi',[
			'status_transaksi' => 'diambil'
		]) > 0;
	}
	public function MCariRange($id_user, $tgl_awal, $tgl_akhir)
	{
		$this->db->order_by('status_transaksi', 'DeSC');
		return $this->db
		->select('tb_member.*, tb_transaksi.*')
		->from('tb_transaksi')
		->join('tb_member', 'tb_transaksi.id_member = tb_member.id_member')
		->where('tb_transaksi.id_user', $id_user)
		->where('tgl_transaksi >=', $tgl_awal)
		->where('tgl_transaksi <=', $tgl_akhir)
		->get()
		->result_array();
	}

}
