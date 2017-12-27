<?php
 
class ControllerExtensionModuleGlsSender extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/gls_sender');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('gls_sender', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		$data['glsform_api_country']           = $this->language->get('glsform_api_country');
		$data['glsform_username']              = $this->language->get('glsform_username');
		$data['glsform_password']              = $this->language->get('glsform_password');
		$data['glsform_senderid']              = $this->language->get('glsform_senderid');
		
		$data['glsform_name']               = $this->language->get('glsform_name');
		$data['glsform_address']            = $this->language->get('glsform_address');
		$data['glsform_postcode']           = $this->language->get('glsform_postcode');
		$data['glsform_city']               = $this->language->get('glsform_city');
		$data['glsform_country']            = $this->language->get('glsform_country');
		$data['glsform_contact']            = $this->language->get('glsform_contact');
		$data['glsform_phone']              = $this->language->get('glsform_phone');
		$data['glsform_email']              = $this->language->get('glsform_email');



		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
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

		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		if (isset($this->error['zip'])) {
			$data['error_zip'] = $this->error['zip'];
		} else {
			$data['error_zip'] = '';
		}
		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}
		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}
		if (isset($this->error['contact'])) {
			$data['error_contact'] = $this->error['contact'];
		} else {
			$data['error_contact'] = '';
		}
		if (isset($this->error['phone'])) {
			$data['error_phone'] = $this->error['phone'];
		} else {
			$data['error_phone'] = '';
		}
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}



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
				'href' => $this->url->link('extension/module/gls_sender', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/gls_sender', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/gls_sender', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/gls_sender', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['gls_api'])) {
			$data['gls_api'] = $this->request->post['gls_api'];
		} elseif (!empty($module_info)) {
			$data['gls_api'] = $module_info['gls_api'];
		} else {
			$data['gls_api'] = '';
		}
		if (isset($this->request->post['gls_username'])) {
			$data['gls_username'] = $this->request->post['gls_username'];
		} elseif (!empty($module_info)) {
			$data['gls_username'] = $module_info['gls_username'];
		} else {
			$data['gls_username'] = '';
		}
		if (isset($this->request->post['gls_password'])) {
			$data['gls_password'] = $this->request->post['gls_password'];
		} elseif (!empty($module_info)) {
			$data['gls_password'] = $module_info['gls_password'];
		} else {
			$data['gls_password'] = '';
		}
		if (isset($this->request->post['gls_senderid'])) {
			$data['gls_senderid'] = $this->request->post['gls_senderid'];
		} elseif (!empty($module_info)) {
			$data['gls_senderid'] = $module_info['gls_senderid'];
		} else {
			$data['gls_senderid'] = '';
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($module_info)) {
			$data['address'] = $module_info['address'];
		} else {
			$data['address'] = '';
		}
		if (isset($this->request->post['zip'])) {
			$data['zip'] = $this->request->post['zip'];
		} elseif (!empty($module_info)) {
			$data['zip'] = $module_info['zip'];
		} else {
			$data['zip'] = '';
		}
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($module_info)) {
			$data['city'] = $module_info['city'];
		} else {
			$data['city'] = '';
		}
		if (isset($this->request->post['country'])) {
			$data['country'] = $this->request->post['country'];
		} elseif (!empty($module_info)) {
			$data['country'] = $module_info['country'];
		} else {
			$data['country'] = '';
		}
		if (isset($this->request->post['contact'])) {
			$data['contact'] = $this->request->post['contact'];
		} elseif (!empty($module_info)) {
			$data['contact'] = $module_info['contact'];
		} else {
			$data['contact'] = '';
		}
		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (!empty($module_info)) {
			$data['phone'] = $module_info['phone'];
		} else {
			$data['phone'] = '';
		}
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($module_info)) {
			$data['email'] = $module_info['email'];
		} else {
			$data['email'] = '';
		}
		
		$data['postcodes_url'] = $this->url->link('sale/order/get_orase&token='.$this->session->data['token']);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/gls_sender', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/gls_sender')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
   
}