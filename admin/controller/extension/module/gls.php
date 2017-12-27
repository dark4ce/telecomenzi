<?php
 
class ControllerExtensionModuleGls extends Controller {
	private $error = array();
	
	public function index() {
		//print_r($_POST);
		$this->load->language('extension/module/gls');
		$this->load->model("extension/gls");
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('gls', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['text_edit'] = $this->language->get('text_edit');

		$data['glsform_default_settings']      = $this->language->get('glsform_default_settings');
		$data['glsform_sms_msg']               = $this->language->get('glsform_sms_msg');


		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);
		$data['action'] = $this->url->link('extension/module/gls', 'token=' . $this->session->data['token'], true);


		// VALIDATION ERRORS START
		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}
		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}
		// VALIDATION ERRORS STOP


		// BREADCRUMBS START
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)
		);
		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/gls', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/gls', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}
		// BREADCRUMBS STOP

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		
		if (isset($this->request->post['gls_express_parcel'])) {
			$data['gls_express_parcel'] = $this->request->post['gls_express_parcel'];
		} else {
			$data['gls_express_parcel'] = $this->config->get('gls_express_parcel');
		}
		if (isset($this->request->post['gls_flex_delivery'])) {
			$data['gls_flex_delivery'] = $this->request->post['gls_flex_delivery'];
		} else {
			$data['gls_flex_delivery'] = $this->config->get('gls_flex_delivery');
		}
		if (isset($this->request->post['gls_flex_delivery_email'])) {
			$data['gls_flex_delivery_email'] = $this->request->post['gls_flex_delivery_email'];
		} else {
			$data['gls_flex_delivery_email'] = $this->config->get('gls_flex_delivery_email');
		}
		if (isset($this->request->post['gls_flex_delivery_sms'])) {
			$data['gls_flex_delivery_sms'] = $this->request->post['gls_flex_delivery_sms'];
		} else {
			$data['gls_flex_delivery_sms'] = $this->config->get('gls_flex_delivery_sms');
		}
		if (isset($this->request->post['gls_pick_ship'])) {
			$data['gls_pick_ship'] = $this->request->post['gls_pick_ship'];
		} else {
			$data['gls_pick_ship'] = $this->config->get('gls_pick_ship');
		}
		if (isset($this->request->post['gls_pick_return'])) {
			$data['gls_pick_return'] = $this->request->post['gls_pick_return'];
		} else {
			$data['gls_pick_return'] = $this->config->get('gls_pick_return');
		}
		if (isset($this->request->post['gls_sms'])) {
			$data['gls_sms'] = $this->request->post['gls_sms'];
		} else {
			$data['gls_sms'] = $this->config->get('gls_sms');
		}
		if (isset($this->request->post['gls_sms_msg'])) {
			$data['gls_sms_msg'] = $this->request->post['gls_sms_msg'];
		} else {
			$data['gls_sms_msg'] = $this->config->get('gls_sms_msg');
		}
		if (isset($this->request->post['gls_preadvice'])) {
			$data['gls_preadvice'] = $this->request->post['gls_preadvice'];
		} else {
			$data['gls_preadvice'] = $this->config->get('gls_preadvice');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/module/gls', $data));
	}

	public function install() {
      $this->load->model("extension/gls");
      $this->model_extension_gls->createSchema();
   }
 
   public function uninstall() {
      $this->load->model("extension/gls");
      $this->model_extension_gls->deleteSchema();
   }
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/gls')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
   
}