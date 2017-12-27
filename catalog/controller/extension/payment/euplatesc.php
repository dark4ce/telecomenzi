<?php

class ControllerExtensionPaymentEuPlatesc extends Controller {

	public function hmacsha1($key,$data) {
		$blocksize = 64;
		$hashfunc  = 'md5';
		if(strlen($key) > $blocksize)
			$key = pack('H*', $hashfunc($key));
		   
		$key  = str_pad($key, $blocksize, chr(0x00));
		$ipad = str_repeat(chr(0x36), $blocksize);
		$opad = str_repeat(chr(0x5c), $blocksize);
		   
		$hmac = pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $data))));
		return bin2hex($hmac);
	}

	public function euplatesc_mac($data, $key){
		$str = NULL;
		foreach($data as $d){
			if($d === NULL || strlen($d) == 0)
				$str .= '-';
			else
				$str .= strlen($d) . $d;
		}
		$key = pack('H*', $key);                                            
		return $this->hmacsha1($key, $str);
	}

	public function index() {
		
		$this->load->model('extension/payment/euplatesc');
		
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['action'] = $this->url->link('extension/payment/euplatesc/checkout', '', 'SSL');
		$data['rate']=$this->model_extension_payment_euplatesc->displayRate();
		
		return $this->load->view('extension/payment/euplatesc', $data);
		
	}
	
	public function checkout(){
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$mid=$this->config->get('euplatesc_account');
		$key=$this->config->get('euplatesc_secret');

		$allProducts = "";
		$products = $this->cart->getProducts();

		foreach($products as $product) {
			$name = $product['name'];
			$quantity = $product['quantity'];
			$allProducts .= $name . " x" . $quantity . "<br/>";
		}
		
		$allProducts = preg_replace('/[^A-Za-z0-9 <>\-.,:;()]/', '', $allProducts);

		$dataAll = array(
					'amount'      => $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false),
					'curr'        => $order_info['currency_code'],
					'invoice_id'  => $this->session->data['order_id'],
					'order_desc'  => $allProducts,

					'merch_id'    => $mid,
					'timestamp'   => gmdate("YmdHis"),
					'nonce'       => md5(microtime() . mt_rand()),
		);
		  
		$dataAll['fp_hash'] = strtoupper($this->euplatesc_mac($dataAll,$key));

		$dataAll['email'] = $order_info['email'];
		$dataAll['phone'] = $order_info['telephone'];

		if ($this->cart->hasShipping()) {
			$dataAll['add'] = $order_info['shipping_address_1'];
			$dataAll['city'] = $order_info['shipping_city'];
		} else {
			$dataAll['add'] = $order_info['payment_address_1'];
			$dataAll['city'] = $order_info['payment_city'];		
		}
		$dataAll['ExtraData[successurl]'] = $this->url->link('checkout/success');
		
		if($this->config->get('euplatesc_ratestatus')){
			if(isset($this->request->post['ep_type']) && $this->request->post['ep_type']=="1"){
				if($this->config->get('euplatesc_ratedisplay')){
					if(isset($this->request->post['euplatesc_rate_banca']) && isset($this->request->post['euplatesc_rate_nr'])){
						$dataAll['ExtraData[rate]'] = $this->request->post['euplatesc_rate_banca'].'-'.$this->request->post['euplatesc_rate_nr'];
					}
				}else{
					if(isset($this->request->post['euplatesc_rate'])){
						$dataAll['ExtraData[rate]'] = $this->request->post['euplatesc_rate'];
					}
				}
			}
		}
		
		$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('euplatesc_order_status_id'));
		$this->response->redirect('https://secure.euplatesc.ro/tdsprocess/tranzactd.php?' . http_build_query($dataAll));
	}

	public function ipn() {
		$this->load->model('checkout/order');
		
		if($this->config->get('euplatesc_secstatus')=="0"){
			$zcrsp =  array (
				'amount'     => addslashes(trim(@$_POST['amount'])),
				'curr'       => addslashes(trim(@$_POST['curr'])),
				'invoice_id' => addslashes(trim(@$_POST['invoice_id'])),
				'ep_id'      => addslashes(trim(@$_POST['ep_id'])),
				'merch_id'   => addslashes(trim(@$_POST['merch_id'])),
				'action'     => addslashes(trim(@$_POST['action'])),
				'message'    => addslashes(trim(@$_POST['message'])),
				'approval'   => addslashes(trim(@$_POST['approval'])),
				'timestamp'  => addslashes(trim(@$_POST['timestamp'])),
				'nonce'      => addslashes(trim(@$_POST['nonce'])),
			);
			
			$zcrsp['fp_hash'] = strtoupper($this->euplatesc_mac($zcrsp, $this->config->get('euplatesc_secret')));
			$fp_hash=addslashes(trim(@$_POST['fp_hash']));
			if($zcrsp['fp_hash']===$fp_hash){
				if($zcrsp['action']=="0") {	
					$this->model_checkout_order->addOrderHistory($zcrsp['invoice_id'], $this->config->get('euplatesc_order_status_id_s'));
				}else{
					$this->model_checkout_order->addOrderHistory($zcrsp['invoice_id'], $this->config->get('euplatesc_order_status_id_f'));
				}
			}else{
				echo "Invalid FP_HASH";
			}
		}else if(isset($_POST['sec_status']) and isset($_POST['invoice_id'])){
			$zcrsp =  array (
				'amount'     => addslashes(trim(@$_POST['amount'])), 
				'curr'       => addslashes(trim(@$_POST['curr'])),  
				'invoice_id' => addslashes(trim(@$_POST['invoice_id'])),
				'ep_id'      => addslashes(trim(@$_POST['ep_id'])), 
				'merch_id'   => addslashes(trim(@$_POST['merch_id'])),
				'action'     => addslashes(trim(@$_POST['action'])),
				'message'    => addslashes(trim(@$_POST['message'])),
				'approval'   => addslashes(trim(@$_POST['approval'])),
				'timestamp'  => addslashes(trim(@$_POST['timestamp'])),
				'nonce'      => addslashes(trim(@$_POST['nonce'])),
				'sec_status' => addslashes(trim(@$_POST['sec_status'])),
			);
							 
			$zcrsp['fp_hash'] = strtoupper($this->euplatesc_mac($zcrsp, $this->config->get('euplatesc_secret')));
			$fp_hash=addslashes(trim(@$_POST['fp_hash']));
					
			if($zcrsp['fp_hash']!=$fp_hash)	{
				echo "Invalid FP_HASH";
			} else {
		
				if($_POST['action'] == 0) {
					if($_POST['sec_status']==8 or $_POST['sec_status']==9){
						if(strpos(strtolower($zcrsp['message']),"pending")==false){ /*to filter sms pending message*/
							$this->model_checkout_order->addOrderHistory($zcrsp['invoice_id'], $this->config->get('euplatesc_order_status_id_s'));
						}
					}else{
						$this->db->query("INSERT INTO ".DB_PREFIX."ep_trans(id,ep_id,invoice_id) VALUES (null,'".$zcrsp['ep_id']."','".$zcrsp['invoice_id']."')");
					}
						
				} else {
					$this->model_checkout_order->addOrderHistory($zcrsp['invoice_id'], $this->config->get('euplatesc_order_status_id_f'));
				}
						
			}
			
		}else if(isset($_POST['cart_id'])){
			
			$order_id = $this->db->query("SELECT invoice_id FROM ".DB_PREFIX."ep_trans WHERE ep_id='".$_POST['cart_id']."'" );
			$order_id = $order_id->row['invoice_id'];							
			if(isset($_POST['sec_status']) and $order_id){
				if($_POST['sec_status']==8 or $_POST['sec_status']==9){
					$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('euplatesc_order_status_id_s'));
				}if($_POST['sec_status']==5 or $_POST['sec_status']==6){
					$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('euplatesc_order_status_id_f'));
				}
			}
		}else{
			echo "Invalid request";
		}
	}
}
?>