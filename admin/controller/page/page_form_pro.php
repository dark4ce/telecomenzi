<?php
class ControllerPagePageFormPro extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('page/page_form_pro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('page/page_buildtable_pro');
		$this->model_page_page_buildtable_pro->Buildtable();

		$this->load->model('page/page_form_pro');

		$this->getList();
	}

	public function add() {
		$this->load->language('page/page_form_pro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('page/page_form_pro');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_page_page_form_pro->addPageFormPro($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('page/page_form_pro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('page/page_form_pro');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_page_page_form_pro->editPageFormPro($this->request->get['page_form_pro_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('page/page_form_pro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('page/page_form_pro');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $page_form_pro_id) {
				$this->model_page_page_form_pro->deletePageFormPro($page_form_pro_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.title';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('page/page_form_pro/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('page/page_form_pro/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['page_form_pros'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$page_form_pro_total = $this->model_page_page_form_pro->getTotalPageFormPros();

		$results = $this->model_page_page_form_pro->getPageFormPros($filter_data);

		foreach ($results as $result) {
			$data['page_form_pros'][] = array(
				'page_form_pro_id'  => $result['page_form_pro_id'],
				'title' 		=> $result['title'],
				'status' 		=> ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'sort_order' 	=> $result['sort_order'],
				'edit'       	=> $this->url->link('page/page_form_pro/edit', 'token=' . $this->session->data['token'] . '&page_form_pro_id=' . $result['page_form_pro_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . '&sort=o.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . '&sort=o.sort_order' . $url, true);
		$data['sort_status'] = $this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . '&sort=o.status' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $page_form_pro_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($page_form_pro_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($page_form_pro_total - $this->config->get('config_limit_admin'))) ? $page_form_pro_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $page_form_pro_total, ceil($page_form_pro_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('page/page_list_pro.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['page_form_pro_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_choose'] = $this->language->get('text_choose');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_radio'] = $this->language->get('text_radio');
		$data['text_checkbox'] = $this->language->get('text_checkbox');
		$data['text_input'] = $this->language->get('text_input');
		$data['text_text'] = $this->language->get('text_text');
		$data['text_textarea'] = $this->language->get('text_textarea');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_confirm_password'] = $this->language->get('text_confirm_password');
		$data['text_file'] = $this->language->get('text_file');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_datetime'] = $this->language->get('text_datetime');
		$data['text_time'] = $this->language->get('text_time');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_country'] = $this->language->get('text_country');
		$data['text_zone'] = $this->language->get('text_zone');
		$data['text_localisation'] = $this->language->get('text_localisation');
		$data['text_postcode'] = $this->language->get('text_postcode');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_number'] = $this->language->get('text_number');
		$data['text_email_exists'] = $this->language->get('text_email_exists');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_lang_setting'] = $this->language->get('text_lang_setting');
		$data['text_type_setting'] = $this->language->get('text_type_setting');
		$data['text_value_setting'] = $this->language->get('text_value_setting');

		$data['valid_field_type'] = $this->language->get('valid_field_type');
		$data['valid_field_info'] = $this->language->get('valid_field_info');
		$data['valid_select_type'] = $this->language->get('valid_select_type');
		$data['valid_input_type'] = $this->language->get('valid_input_type');
		$data['valid_file_type'] = $this->language->get('valid_file_type');
		$data['valid_date_type'] = $this->language->get('valid_date_type');
		$data['valid_localisation_type'] = $this->language->get('valid_localisation_type');
		
		$data['text_select_value'] = $this->language->get('text_select_value');
		$data['text_radio_value'] = $this->language->get('text_radio_value');
		$data['text_checkbox_value'] = $this->language->get('text_checkbox_value');
		$data['text_text_value'] = $this->language->get('text_text_value');
		$data['text_textarea_value'] = $this->language->get('text_textarea_value');
		$data['text_number_value'] = $this->language->get('text_number_value');
		$data['text_telephone_value'] = $this->language->get('text_telephone_value');
		$data['text_email_value'] = $this->language->get('text_email_value');
		$data['text_email_exists_value'] = $this->language->get('text_email_exists_value');
		$data['text_password_value'] = $this->language->get('text_password_value');
		$data['text_password_value'] = $this->language->get('text_password_value');
		$data['text_confirm_value'] = $this->language->get('text_confirm_value');
		$data['text_file_value'] = $this->language->get('text_file_value');
		$data['valid_date_type'] = $this->language->get('valid_date_type');
		$data['text_date_value'] = $this->language->get('text_date_value');
		$data['text_time_value'] = $this->language->get('text_time_value');
		$data['text_datetime_value'] = $this->language->get('text_datetime_value');
		$data['text_country_value'] = $this->language->get('text_country_value');
		$data['text_zone_value'] = $this->language->get('text_zone_value');
		$data['text_postcode_value'] = $this->language->get('text_postcode_value');
		$data['text_address_value'] = $this->language->get('text_address_value');
		$data['text_form_attributes'] = $this->language->get('text_form_attributes');

		$data['leg_product'] = $this->language->get('leg_product');
		$data['leg_customer_group'] = $this->language->get('leg_customer_group');
		$data['leg_store'] = $this->language->get('leg_store');
		
		$data['entry_title'] = $this->language->get('entry_title');		
		$data['entry_pbutton_title'] = $this->language->get('entry_pbutton_title');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_show_guest'] = $this->language->get('entry_show_guest');
		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_bottom_description'] = $this->language->get('entry_bottom_description');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_producttype'] = $this->language->get('entry_producttype');
		
		$data['entry_customer_email_status'] = $this->language->get('entry_customer_email_status');
		$data['entry_customer_subject'] = $this->language->get('entry_customer_subject');
		$data['entry_customer_message'] = $this->language->get('entry_customer_message');
		$data['entry_admin_email_status'] = $this->language->get('entry_admin_email_status');
		$data['entry_admin_subject'] = $this->language->get('entry_admin_subject');
		$data['entry_admin_message'] = $this->language->get('entry_admin_message');
		$data['entry_success_title'] = $this->language->get('entry_success_title');
		$data['entry_success_description'] = $this->language->get('entry_success_description');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_field_name'] = $this->language->get('entry_field_name');
		$data['entry_field_help'] = $this->language->get('entry_field_help');
		$data['entry_field_value'] = $this->language->get('entry_field_value');
		$data['entry_field_error'] = $this->language->get('entry_field_error');
		$data['entry_field_placeholder'] = $this->language->get('entry_field_placeholder');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_top'] = $this->language->get('entry_top');
		$data['entry_top'] = $this->language->get('entry_top');
		$data['entry_bottom'] = $this->language->get('entry_bottom');
		$data['entry_fieldset_title'] = $this->language->get('entry_fieldset_title');
		$data['entry_submit_button'] = $this->language->get('entry_submit_button');
		$data['entry_information'] = $this->language->get('entry_information');
		$data['entry_action'] = $this->language->get('entry_action');
		
		$data['const_names'] = $this->language->get('const_names');
		$data['const_short_codes'] = $this->language->get('const_short_codes');
		$data['const_logo'] = $this->language->get('const_logo');
		$data['const_store_name'] = $this->language->get('const_store_name');
		$data['const_store_link'] = $this->language->get('const_store_link');
		$data['const_name'] = $this->language->get('const_name');

		$data['help_field_name'] = $this->language->get('help_field_name');
		$data['help_field_help'] = $this->language->get('help_field_help');
		$data['help_field_value'] = $this->language->get('help_field_value');
		$data['help_field_error'] = $this->language->get('help_field_error');
		$data['help_field_placeholder'] = $this->language->get('help_field_placeholder');
		$data['help_required'] = $this->language->get('help_required');
		$data['help_sort_order'] = $this->language->get('help_sort_order');
		$data['help_type'] = $this->language->get('help_type');
		$data['help_top'] = $this->language->get('help_top');
		$data['help_bottom'] = $this->language->get('help_bottom');
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_product'] = $this->language->get('help_product');
		
		$data['text_no_product'] = $this->language->get('text_no_product');
		$data['text_all_product'] = $this->language->get('text_all_product');
		$data['text_choose_product'] = $this->language->get('text_choose_product');
		
		$data['help_fieldset_title'] = $this->language->get('help_fieldset_title');
		$data['help_submit_button'] = $this->language->get('help_submit_button');
		$data['help_customer_email_status'] = $this->language->get('help_customer_email_status');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_page'] = $this->language->get('tab_page');
		$data['tab_fields'] = $this->language->get('tab_fields');
		$data['tab_field'] = $this->language->get('tab_field');
		$data['tab_email'] = $this->language->get('tab_email');
		$data['tab_success_page'] = $this->language->get('tab_success_page');
		$data['tab_error_page'] = $this->language->get('tab_error_page');
		$data['tab_customer_email'] = $this->language->get('tab_customer_email');
		$data['tab_admin_email'] = $this->language->get('tab_admin_email');
		$data['tab_link'] = $this->language->get('tab_link');
		$data['tab_css'] = $this->language->get('tab_css');

		$data['button_add_field'] = $this->language->get('button_add_field');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}

		if (isset($this->error['success_title'])) {
			$data['error_success_title'] = $this->error['success_title'];
		} else {
			$data['error_success_title'] = '';
		}

		if (isset($this->error['customer_subject'])) {
			$data['error_customer_subject'] = $this->error['customer_subject'];
		} else {
			$data['error_customer_subject'] = '';
		}

		if (isset($this->error['customer_message'])) {
			$data['error_customer_message'] = $this->error['customer_message'];
		} else {
			$data['error_customer_message'] = '';
		}

		if (isset($this->error['admin_subject'])) {
			$data['error_admin_subject'] = $this->error['admin_subject'];
		} else {
			$data['error_admin_subject'] = '';
		}

		if (isset($this->error['admin_message'])) {
			$data['error_admin_message'] = $this->error['admin_message'];
		} else {
			$data['error_admin_message'] = '';
		}

		if (isset($this->error['field_name'])) {
			$data['error_field_name'] = $this->error['field_name'];
		} else {
			$data['error_field_name'] = array();
		}

		if (isset($this->error['value_name'])) {
			$data['error_value_name'] = $this->error['value_name'];
		} else {
			$data['error_value_name'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['page_form_pro_id'])) {
			$data['action'] = $this->url->link('page/page_form_pro/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('page/page_form_pro/edit', 'token=' . $this->session->data['token'] . '&page_form_pro_id=' . $this->request->get['page_form_pro_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('page/page_form_pro', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['page_form_pro_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$page_form_pro_info = $this->model_page_page_form_pro->getPageFormPro($this->request->get['page_form_pro_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		
		if (isset($this->request->post['top'])) {
			$data['top'] = $this->request->post['top'];
		} elseif (!empty($page_form_pro_info)) {
			$data['top'] = $page_form_pro_info['top'];
		} else {
			$data['top'] = '1';
		}

		if (isset($this->request->post['bottom'])) {
			$data['bottom'] = $this->request->post['bottom'];
		} elseif (!empty($page_form_pro_info)) {
			$data['bottom'] = $page_form_pro_info['bottom'];
		} else {
			$data['bottom'] = '1';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($page_form_pro_info)) {
			$data['sort_order'] = $page_form_pro_info['sort_order'];
		} else {
			$data['sort_order'] = '0';
		}

		if (isset($this->request->post['producttype'])) {
			$data['producttype'] = $this->request->post['producttype'];
		} elseif (!empty($page_form_pro_info)) {
			$data['producttype'] = $page_form_pro_info['producttype'];
		} else {
			$data['producttype'] = 'no';
		}

		if (isset($this->request->post['css'])) {
			$data['css'] = $this->request->post['css'];
		} elseif (!empty($page_form_pro_info)) {
			$data['css'] = $page_form_pro_info['css'];
		} else {
			$data['css'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($page_form_pro_info)) {
			$data['status'] = $page_form_pro_info['status'];
		} else {
			$data['status'] = '1';
		}


		if (isset($this->request->post['customer_email_status'])) {
			$data['customer_email_status'] = $this->request->post['customer_email_status'];
		} elseif (!empty($page_form_pro_info)) {
			$data['customer_email_status'] = $page_form_pro_info['customer_email_status'];
		} else {
			$data['customer_email_status'] = '';
		}

		if (isset($this->request->post['admin_email_status'])) {
			$data['admin_email_status'] = $this->request->post['admin_email_status'];
		} elseif (!empty($page_form_pro_info)) {
			$data['admin_email_status'] = $page_form_pro_info['admin_email_status'];
		} else {
			$data['admin_email_status'] = '';
		}

		if (isset($this->request->post['show_guest'])) {
			$data['show_guest'] = $this->request->post['show_guest'];
		} elseif (!empty($page_form_pro_info)) {
			$data['show_guest'] = $page_form_pro_info['show_guest'];
		} else {
			$data['show_guest'] = '1';
		}

		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} elseif (!empty($page_form_pro_info)) {
			$data['captcha'] = $page_form_pro_info['captcha'];
		} else {
			$data['captcha'] = '';
		}

		if (isset($this->request->post['css'])) {
			$data['css'] = $this->request->post['css'];
		} elseif (!empty($page_form_pro_info)) {
			$data['css'] = $page_form_pro_info['css'];
		} else {
			$data['css'] = '';
		}

		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();
		if (isset($this->request->post['page_form_pro_store'])) {
			$data['page_form_pro_store'] = $this->request->post['page_form_pro_store'];
		} elseif (isset($this->request->get['page_form_pro_id'])) {
			$data['page_form_pro_store'] = $this->model_page_page_form_pro->getPageFormProStores($this->request->get['page_form_pro_id']);
		} else {
			$data['page_form_pro_store'] = array(0);
		}

		if(VERSION > '2.0.3.1') {
			$this->load->model('customer/customer_group');
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		} else{
			$this->load->model('sale/customer_group');
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		}

		if (isset($this->request->post['page_form_pro_customer_group'])) {
			$data['page_form_pro_customer_group'] = $this->request->post['page_form_pro_customer_group'];
		} elseif (isset($this->request->get['page_form_pro_id'])) {
			$data['page_form_pro_customer_group'] = $this->model_page_page_form_pro->getPageFormProCustomerGroups($this->request->get['page_form_pro_id']);
		} else {
			$data['page_form_pro_customer_group'] = array($this->config->get('config_customer_group_id'));
		}

		if (isset($this->request->post['page_form_pro_description'])) {
			$data['page_form_pro_description'] = $this->request->post['page_form_pro_description'];
		} elseif (isset($this->request->get['page_form_pro_id'])) {
			$data['page_form_pro_description'] = $this->model_page_page_form_pro->getPageFormProDescriptions($this->request->get['page_form_pro_id']);
		} else {
			$data['page_form_pro_description'] = array();
		}

			
		if (isset($this->request->post['page_form_pro_field'])) {
			$data['fields'] = $this->request->post['page_form_pro_field'];
		} elseif (isset($this->request->get['page_form_pro_id'])) {
			$data['fields'] = $this->model_page_page_form_pro->getPageFormProOptions($this->request->get['page_form_pro_id']);
		} else {
			$data['fields'] = array();
		}

		if (isset($this->request->post['page_form_pro_product'])) {
			$page_form_pro_products = $this->request->post['page_form_pro_product'];
		} elseif (isset($this->request->get['page_form_pro_id'])) {
			$page_form_pro_products = $this->model_page_page_form_pro->getPageFormProProducts($this->request->get['page_form_pro_id']);
		} else {
			$page_form_pro_products = array();
		}

		$data['page_form_pro_products'] = array();
		$this->load->model('catalog/product');
		foreach ($page_form_pro_products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['page_form_pro_products'][] = array(
					'product_id' 	=> $product_info['product_id'],
					'name'        	=> $product_info['name'],
				);
			}
		}

		$data['config_language_id'] = $this->config->get('config_language_id');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('page/page_form_pro.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'page/page_form_pro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['page_form_pro_description'] as $language_id => $page_form_pro_value) {
			if ((utf8_strlen($page_form_pro_value['title']) < 2) || (utf8_strlen($page_form_pro_value['title']) > 255)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
			
			if ((utf8_strlen($page_form_pro_value['success_title']) < 2) || (utf8_strlen($page_form_pro_value['success_title']) > 255)) {
				$this->error['success_title'][$language_id] = $this->language->get('error_success_title');
			}

			if(!empty($this->request->post['customer_email_status'])) {
				if ((utf8_strlen($page_form_pro_value['customer_subject']) < 2) || (utf8_strlen($page_form_pro_value['customer_subject']) > 255)) {
					$this->error['customer_subject'][$language_id] = $this->language->get('error_customer_subject');
				}

				$page_form_pro_value['customer_message'] = str_replace('&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '', $page_form_pro_value['customer_message']);
				if ((utf8_strlen($page_form_pro_value['customer_message']) < 25)) {
					$this->error['customer_message'][$language_id] = $this->language->get('error_customer_message');
				}
			}

			if(!empty($this->request->post['admin_email_status'])) {
				if ((utf8_strlen($page_form_pro_value['admin_subject']) < 2) || (utf8_strlen($page_form_pro_value['admin_subject']) > 255)) {
					$this->error['admin_subject'][$language_id] = $this->language->get('error_admin_subject');
				}

				$page_form_pro_value['admin_message'] = str_replace('&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '', $page_form_pro_value['admin_message']);
				if ((utf8_strlen($page_form_pro_value['admin_message']) < 25)) {
					$this->error['admin_message'][$language_id] = $this->language->get('error_admin_message');
				}
			}
		}

		if (isset($this->request->post['page_form_pro_field'])) {
			foreach ($this->request->post['page_form_pro_field'] as $row => $description) {
				if(isset($description['description'])) {
					foreach ($description['description'] as $language_id => $value) {
						if ((utf8_strlen($value['field_name']) < 1) || (utf8_strlen($value['field_name']) > 128)) {
							$this->error['field_name'][$row][$language_id] = $this->language->get('error_field_name');
						}
					}
				}

				if(isset($description['option_value']) && !in_array($description['type'], array('select', 'radio', 'checkbox')) ) {
					unset($this->request->post['page_form_pro_field'][$row]['option_value']);
					unset($description['option_value']);
				}

				if(isset($description['option_value'])) {
					foreach ($description['option_value'] as $option_value_row => $option_value) {
						foreach ($option_value['page_form_pro_option_value_description'] as $language_id => $option_value_description) {
							if ((utf8_strlen($option_value_description['name']) < 1) || (utf8_strlen($option_value_description['name']) > 128)) {
								$this->error['value_name'][$row][$option_value_row][$language_id] = $this->language->get('error_value_name');
							}
						}
					}
				}
			}
		}


		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'page/page_form_pro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}	

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_title'])) {
			if (isset($this->request->get['filter_title'])) {
				$filter_title = $this->request->get['filter_title'];
			} else {
				$filter_title = '';
			}

			$this->load->model('page/page_form_pro');

			$filter_data = array(
				'filter_title' => $filter_title,
				'start'        => 0,
				'limit'        => 5
			);

			$results = $this->model_page_page_form_pro->getPageFormPros($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'page_form_pro_id'       => $result['page_form_pro_id'],
					'title'              => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['title'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}