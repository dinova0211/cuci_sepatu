<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi_m');
	}

	public function index()
	{
		$this->load->model(['customer_m', 'paket_m']);
		$customer = $this->customer_m->get()->result();
		$paket = $this->paket_m->get()->result();
		$cart = $this->transaksi_m->get_cart();
		$data = array(
			'customer' => $customer,
			'paket' => $paket,
			'cart' => $cart,
			'invoice' => $this->transaksi_m->invoice_no(),
		);
		$this->template->load('template', 'transaction/transaction_form', $data);
	}

	public function process()
	{
		$data = $this->input->post(null, TRUE);

		if(isset($_POST['add_cart'])) {

			$paket_id = $this->input->post('paket_id');
			$check_cart = $this->transaksi_m->get_cart(['cart.paket_id' => $paket_id])->num_rows();
			if($check_cart > 0) {
				$this->transaksi_m->update_cart_qty($data);
			} else {
				$this->transaksi_m->add_cart($data);	
			}
					

			if($this->db->affected_rows() > 0) {
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}

		if(isset($_POST['edit_cart'])) {
			$this->transaksi_m->edit_cart($data);

			if($this->db->affected_rows() > 0) {
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}

		if(isset($_POST['process_payment'])) {
			$transaksi_id = $this->transaksi_m->add_transaksi($data);
			$cart = $this->transaksi_m->get_cart()->result();
			$row = [];
			foreach($cart as $c => $value) {
				array_push($row, array(
					'transaksi_id' => $transaksi_id,
					'paket_id' => $value->paket_id,
					'price' => $value->price,
					'qty' => $value->qty,
					'discount_paket' => $value->discount_paket,
					'total' => $value->total,
				)
			);
			}
			$this->transaksi_m->add_transaksi_detail($row);
			$this->transaksi_m->del_cart(['user_id' => $this->session->userdata('userid')]);
		
			if($this->db->affected_rows() > 0) {
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}
	}

	function cart_data() 
	{
		$cart = $this->transaksi_m->get_cart();
		$data['cart'] = $cart;
		$this->load->view('transaction/cart_data', $data);
	}

	public function cart_del()
	{
		$cart_id = $this->input->post('cart_id');
		$this->transaksi_m->del_cart(['cart_id' => $cart_id]);

		if($this->db->affected_rows() > 0) {
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
	}
}