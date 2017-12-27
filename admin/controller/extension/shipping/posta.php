<?php
class ControllerExtensionShippingPosta extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('extension/shipping/posta');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('posta', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_insurance'] = $this->language->get('entry_insurance');		
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['entry_mandat'] = $this->language->get('entry_mandat');
		$data['entry_expeditor'] = $this->language->get('entry_expeditor');
		$data['entry_cui'] = $this->language->get('entry_cui');
		$data['entry_adr'] = $this->language->get('entry_adr');

		$data['entry_jud'] = $this->language->get('entry_jud');
		$data['entry_oras'] = $this->language->get('entry_oras');
		$data['entry_code'] = $this->language->get('entry_code');	
		$data['entry_banca'] = $this->language->get('entry_banca');	
		$data['entry_sucursala'] = $this->language->get('entry_sucursala');	
		$data['entry_iban'] = $this->language->get('entry_iban');	


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_extension'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true),
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/shipping/posta', 'token=' . $this->session->data['token'], true),
   		);
		
		$data['action'] = $this->url->link('extension/shipping/posta', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('extension/extention', 'token=' . $this->session->data['token'] . '&type=shipping', true);
		
		if (isset($this->request->post['posta_cost'])) {
			$data['posta_cost'] = $this->request->post['posta_cost'];
		} elseif ($this->config->get('posta_cost')) {
			$data['posta_cost'] = $this->config->get('posta_cost');			
		} else {
			$data['posta_cost'] = 4.50;
		}

		if (isset($this->request->post['posta_kg'])) {
			$data['posta_kg'] = $this->request->post['posta_kg'];
		} elseif ($this->config->get('posta_kg')) {
			$data['posta_kg'] = $this->config->get('posta_kg');			
		} else {
			$data['posta_kg'] = 1.65;
		}

		if (isset($this->request->post['posta_valoare'])) {
			$data['posta_valoare'] = $this->request->post['posta_valoare'];
		} elseif ($this->config->get('posta_valoare')) {
			$data['posta_valoare'] = $this->config->get('posta_valoare');			
		} else {
			$data['posta_valoare'] = 20.00;
		}	
	
		if (isset($this->request->post['posta_exp_name'])) {
			$data['posta_exp_name'] = $this->request->post['posta_exp_name'];
		} else {
			$data['posta_exp_name'] = $this->config->get('posta_exp_name');
		}

		if (isset($this->request->post['posta_exp_cui'])) {
			$data['posta_exp_cui'] = $this->request->post['posta_exp_cui'];
		} else {
			$data['posta_exp_cui'] = $this->config->get('posta_exp_cui');
		}

		if (isset($this->request->post['posta_exp_adr'])) {
			$data['posta_exp_adr'] = $this->request->post['posta_exp_adr'];
		} else {
			$data['posta_exp_adr'] = $this->config->get('posta_exp_adr');
		}

		if (isset($this->request->post['posta_exp_banca'])) {
			$data['posta_exp_banca'] = $this->request->post['posta_exp_banca'];
		} else {
			$data['posta_exp_banca'] = $this->config->get('posta_exp_banca');
		}

		if (isset($this->request->post['posta_exp_sucursala'])) {
			$data['posta_exp_sucursala'] = $this->request->post['posta_exp_sucursala'];
		} else {
			$data['posta_exp_sucursala'] = $this->config->get('posta_exp_sucursala');
		}

		if (isset($this->request->post['posta_exp_iban'])) {
			$data['posta_exp_iban'] = $this->request->post['posta_exp_iban'];
		} else {
			$data['posta_exp_iban'] = $this->config->get('posta_exp_iban');
		}

		if (isset($this->request->post['posta_exp_oras'])) {
			$data['posta_exp_oras'] = $this->request->post['posta_exp_oras'];
		} else {
			$data['posta_exp_oras'] = $this->config->get('posta_exp_oras');
		}

		if (isset($this->request->post['posta_exp_code'])) {
			$data['posta_exp_code'] = $this->request->post['posta_exp_code'];
		} else {
			$data['posta_exp_code'] = $this->config->get('posta_exp_code');
		}
		
		if (isset($this->request->post['posta_exp_jud'])) {
			$data['posta_exp_jud'] = $this->request->post['posta_exp_jud'];
		} else {
			$data['posta_exp_jud'] = $this->config->get('posta_exp_jud');
		}

		if (isset($this->request->post['posta_tax_class_id'])) {
			$data['posta_tax_class_id'] = $this->request->post['posta_tax_class_id'];
		} else {
			$data['posta_tax_class_id'] = $this->config->get('posta_tax_class_id');
		}
		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		if (isset($this->request->post['posta_geo_zone_id'])) {
			$data['posta_geo_zone_id'] = $this->request->post['posta_geo_zone_id'];
		} else {
			$data['posta_geo_zone_id'] = $this->config->get('posta_geo_zone_id');
		}
				$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['posta_status'])) {
			$data['posta_status'] = $this->request->post['posta_status'];
		} else {
			$data['posta_status'] = $this->config->get('posta_status');
		}
		
		if (isset($this->request->post['posta_sort_order'])) {
			$data['posta_sort_order'] = $this->request->post['posta_sort_order'];
		} else {
			$data['posta_sort_order'] = $this->config->get('posta_sort_order');
		}				
								
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('extension/shipping/posta', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/posta')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
				
		if ($this->request->post['posta_valoare'] < 20) {
			$this->error['warning'] = $this->language->get('error_insurance');
		}

		if ($this->request->post['posta_kg'] <= 0) {
			$this->error['warning'] = $this->language->get('error_weight');
		}

		if ($this->request->post['posta_cost'] <= 0) {
			$this->error['warning'] = $this->language->get('error_cost');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}