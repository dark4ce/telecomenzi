<?php 
class ControllerExtensionPaymentEuPlatesc extends Controller {
	private $error = array(); 
	
	public function getRate(){
		return array('apb'=>'Alpha Bank','bcr'=>'Banca Comerciala Romana','brdf'=>'BRD Finance','btrl'=>'Banca Transilvania','pbr'=>'Piraeus Bank','rzb'=>'Raiffeisen Bank');
	}

	public function index() {
		$this->load->language('payment/euplatesc');
		
		$this->load->model('setting/setting');
		
		$this->install();
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('euplatesc', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_edit'] = "EuPlatesc";
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_account'] = $this->language->get('entry_account');
		$data['entry_secret'] = $this->language->get('entry_secret');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_order_status'] = $this->language->get('entry_order_status');		
		$data['entry_order_status_s'] = $this->language->get('entry_order_status_s');		
		$data['entry_order_status_f'] = $this->language->get('entry_order_status_f');		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		
		$data['entry_ratestate'] = $this->language->get('entry_ratestate');
		$data['entry_rate'] = $this->language->get('entry_rate');
		$data['entry_nrrate'] = $this->language->get('entry_nrrate');
		$data['entry_ratedisplay'] = $this->language->get('entry_ratedisplay');
		$data['entry_rateorder'] = $this->language->get('entry_rateorder');
		
		$data['rate_ep']= $this->getRate();
		
		$data['euplatesc_rateactive']=array();
		$data['euplatesc_ratenr']=array();
		foreach($data['rate_ep'] as $code=>$name){
			if (isset($this->request->post['euplatesc_rateactive_'.$code])) {
				$data['euplatesc_rateactive'][$code]=$this->request->post['euplatesc_rateactive_'.$code];
			} else {
				$data['euplatesc_rateactive'][$code]=$this->config->get('euplatesc_rateactive_'.$code);
			}
			
			if (isset($this->request->post['euplatesc_rate_'.$code])) {
				$data['euplatesc_ratenr'][$code]=$this->request->post['euplatesc_rate_'.$code];
			} else {
				$data['euplatesc_ratenr'][$code]=$this->config->get('euplatesc_rate_'.$code);
			}
		}
		
		if (isset($this->request->post['euplatesc_secstatus'])) {
			$data['euplatesc_secstatus'] = $this->request->post['euplatesc_secstatus'];
		} else {
			$data['euplatesc_secstatus'] = $this->config->get('euplatesc_secstatus');
		}
		
		if (isset($this->request->post['euplatesc_ratestatus'])) {
			$data['euplatesc_ratestatus'] = $this->request->post['euplatesc_ratestatus'];
		} else {
			$data['euplatesc_ratestatus'] = $this->config->get('euplatesc_ratestatus');
		}
		
		if (isset($this->request->post['euplatesc_ratedisplay'])) {
			$data['euplatesc_ratedisplay'] = $this->request->post['euplatesc_ratedisplay'];
		} else {
			$data['euplatesc_ratedisplay'] = $this->config->get('euplatesc_ratedisplay');
		}
		
		if (isset($this->request->post['euplatesc_rateorder'])) {
			$data['euplatesc_rateorder'] = $this->request->post['euplatesc_rateorder'];
		} else {
			$data['euplatesc_rateorder'] = $this->config->get('euplatesc_rateorder');
		}
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		 
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}	
		
		if (isset($this->error['account'])) {
			$data['error_account'] = $this->error['account'];
		} else {
			$data['error_account'] = '';
		}	
		
		if (isset($this->error['secret'])) {
			$data['error_secret'] = $this->error['secret'];
		} else {
			$data['error_secret'] = '';
		}	
		
  		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/extension', 'type=payment&token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/euplatesc', 'token=' . $this->session->data['token'], 'SSL')
		);
				
		$data['action'] = HTTPS_SERVER . 'index.php?route=payment/euplatesc&token=' . $this->session->data['token'];
		$data['action'] = $this->url->link('extension/payment/euplatesc', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);
		
		if (isset($this->request->post['euplatesc_account'])) {
			$data['euplatesc_account'] = $this->request->post['euplatesc_account'];
		} else {
			$data['euplatesc_account'] = $this->config->get('euplatesc_account');
		}
		
		if (isset($this->request->post['euplatesc_name'])) {
			$data['euplatesc_name'] = $this->request->post['euplatesc_name'];
		} else {
			$data['euplatesc_name'] = $this->config->get('euplatesc_name');
		}

		if (isset($this->request->post['euplatesc_secret'])) {
			$data['euplatesc_secret'] = $this->request->post['euplatesc_secret'];
		} else {
			$data['euplatesc_secret'] = $this->config->get('euplatesc_secret');
		}
	
		if (isset($this->request->post['euplatesc_test'])) {
			$data['euplatesc_test'] = $this->request->post['euplatesc_test'];
		} else {
			$data['euplatesc_test'] = $this->config->get('euplatesc_test');
		}
		
		if (isset($this->request->post['euplatesc_order_status_id'])) {
			$data['euplatesc_order_status_id'] = $this->request->post['euplatesc_order_status_id'];
		} else {
			$data['euplatesc_order_status_id'] = $this->config->get('euplatesc_order_status_id'); 
		}
		
		if (isset($this->request->post['euplatesc_order_status_id_s'])) {
			$data['euplatesc_order_status_id_s'] = $this->request->post['euplatesc_order_status_id_s'];
		} else {
			$data['euplatesc_order_status_id_s'] = $this->config->get('euplatesc_order_status_id_s'); 
		}
		
		if (isset($this->request->post['euplatesc_order_status_id_f'])) {
			$data['euplatesc_order_status_id_f'] = $this->request->post['euplatesc_order_status_id_f'];
		} else {
			$data['euplatesc_order_status_id_f'] = $this->config->get('euplatesc_order_status_id_f'); 
		}
		
		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		

		if (isset($this->request->post['euplatesc_status'])) {
			$data['euplatesc_status'] = $this->request->post['euplatesc_status'];
		} else {
			$data['euplatesc_status'] = $this->config->get('euplatesc_status');
		}
		
		if (isset($this->request->post['euplatesc_sort_order'])) {
			$data['euplatesc_sort_order'] = $this->request->post['euplatesc_sort_order'];
		} else {
			$data['euplatesc_sort_order'] = $this->config->get('euplatesc_sort_order');
		}
		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		

		$this->response->setOutput($this->load->view('extension/payment/euplatesc.tpl', $data));
	}

	private function install(){
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "ep_trans (	`id` int NOT NULL AUTO_INCREMENT,`ep_id` VARCHAR (50) NOT NULL,`invoice_id` VARCHAR (50) NOT NULL,UNIQUE KEY id (id));");
		
	}
	
	private function validate() {
		
		if (!$this->request->post['euplatesc_name']) {
			$this->error['name'] = $this->language->get('error_name');
		}	
		
		if (!$this->request->post['euplatesc_account']) {
			$this->error['account'] = $this->language->get('error_account');
		}

		if (!$this->request->post['euplatesc_secret']) {
			$this->error['secret'] = $this->language->get('error_secret');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>