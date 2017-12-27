<?php
class ControllerPagePageRequestPro extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('page/page_request_pro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('page/page_buildtable_pro');
		$this->model_page_page_buildtable_pro->Buildtable();

		$this->load->model('page/page_request_pro');

		$this->getList();
	}

	public function delete() {
		$this->load->language('page/page_request_pro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('page/page_request_pro');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $page_request_pro_id) {
				$this->model_page_page_request_pro->deletePageRequestPro($page_request_pro_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_page_form_pro_title'])) {
				$url .= '&filter_page_form_pro_title=' . urlencode(html_entity_decode($this->request->get['filter_page_form_pro_title'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . urlencode(html_entity_decode($this->request->get['filter_ip'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_page_form_pro_title'])) {
			$filter_page_form_pro_title = $this->request->get['filter_page_form_pro_title'];
		} else {
			$filter_page_form_pro_title = '';
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = '';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pg.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
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

		if (isset($this->request->get['filter_page_form_pro_title'])) {
			$url .= '&filter_page_form_pro_title=' . urlencode(html_entity_decode($this->request->get['filter_page_form_pro_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . urlencode(html_entity_decode($this->request->get['filter_ip'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('page/page_request_pro/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('page/page_request_pro/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['page_request_pros'] = array();

		$filter_data = array(
			'filter_page_form_pro_title'  => $filter_page_form_pro_title,
			'filter_customer'  => $filter_customer,
			'filter_ip'  => $filter_ip,
			'filter_date_added'  => $filter_date_added,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$page_request_pro_total = $this->model_page_page_request_pro->getTotalPageRequestPros();

		$results = $this->model_page_page_request_pro->getPageRequestPros($filter_data);

		$this->load->model('setting/store');
		foreach ($results as $result) {
			$data['page_request_pros'][] = array(
				'page_request_pro_id' 	=> $result['page_request_pro_id'],
				'page_form_pro_title' 	=> $result['page_form_pro_title'],
				'customer'         	=> $result['customer'],
				'ip'          		=> $result['ip'],
				'date_added'        => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'           	=> $this->url->link('page/page_request_pro/info', 'token=' . $this->session->data['token'] . '&page_request_pro_id=' . $result['page_request_pro_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['entry_page_form_pro_title'] = $this->language->get('entry_page_form_pro_title');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_view'] = $this->language->get('button_view');
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

		if (isset($this->request->get['filter_page_form_pro_title'])) {
			$url .= '&filter_page_form_pro_title=' . urlencode(html_entity_decode($this->request->get['filter_page_form_pro_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . urlencode(html_entity_decode($this->request->get['filter_ip'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . '&sort=pg.page_form_pro_title' . $url, true);
		$data['sort_customer'] = $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_ip'] = $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . '&sort=pg.ip' . $url, true);
		$data['sort_date_added'] = $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . '&sort=pg.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_page_form_pro_title'])) {
			$url .= '&filter_page_form_pro_title=' . urlencode(html_entity_decode($this->request->get['filter_page_form_pro_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . urlencode(html_entity_decode($this->request->get['filter_ip'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $page_request_pro_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($page_request_pro_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($page_request_pro_total - $this->config->get('config_limit_admin'))) ? $page_request_pro_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $page_request_pro_total, ceil($page_request_pro_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['filter_page_form_pro_title'] = $filter_page_form_pro_title;
		$data['filter_ip'] = $filter_ip;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_customer'] = $filter_customer;

		$data['token'] = $this->session->data['token'];

		if(VERSION > '2.0.3.1') {
			$data['customer_action'] = str_replace('&amp;', '&', $this->url->link('customer/customer', 'token='. $this->session->data['token'], true));
		} else{
			$data['customer_action'] = str_replace('&amp;', '&', $this->url->link('sale/customer', 'token='. $this->session->data['token'], true));
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('page/page_request_pro_list.tpl', $data));
	}

	public function info() {
		$this->load->model('page/page_request_pro');
		$this->load->model('setting/store');
		$this->load->model('localisation/language');

		if (isset($this->request->get['page_request_pro_id'])) {
			$page_request_pro_id = $this->request->get['page_request_pro_id'];
		} else {
			$page_request_pro_id = 0;
		}

		$page_request_pro_info = $this->model_page_page_request_pro->getPageRequestPro($page_request_pro_id);

		if ($page_request_pro_info) {
			$this->load->language('page/page_request_pro');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_page_detail'] = $this->language->get('text_page_detail');
			$data['text_customer_detail'] = $this->language->get('text_customer_detail');
			$data['text_store'] = $this->language->get('text_store');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_customer_group'] = $this->language->get('text_customer_group');
			$data['text_ip'] = $this->language->get('text_ip');
			$data['text_user_agent'] = $this->language->get('text_user_agent');
			$data['text_page_form_pro_title'] = $this->language->get('text_page_form_pro_title');
			$data['text_language_name'] = $this->language->get('text_language_name');
			$data['text_fields'] = $this->language->get('text_fields');
			$data['text_field_name'] = $this->language->get('text_field_name');
			$data['text_field_value'] = $this->language->get('text_field_value');

			$data['text_product_detail'] = $this->language->get('text_product_detail');
			$data['text_product'] = $this->language->get('text_product');
			
			$data['button_back'] = $this->language->get('button_back');

			$url = '';

			if (isset($this->request->get['filter_page_request_pro_id'])) {
				$url .= '&filter_page_request_pro_id=' . $this->request->get['filter_page_request_pro_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['back'] = $this->url->link('page/page_request_pro', 'token=' . $this->session->data['token'] . $url, true);

			$data['token'] = $this->session->data['token'];

			$store_info = $this->model_setting_store->getStore($page_request_pro_info['store_id']);
			if($store_info) {
				$data['store_name'] = $store_info['name'];
			} else{
				$data['store_name'] = $this->language->get('text_default');
			}

			$language_info = $this->model_localisation_language->getLanguage($page_request_pro_info['language_id']);
			if($language_info) {
				$data['language_name'] = $language_info['name'];
			} else{
				$data['language_name'] = '';
			}

			$data['date_added'] = date($this->language->get('datetime_format'), strtotime($page_request_pro_info['date_added']));

			$data['page_form_pro_title'] = $page_request_pro_info['page_form_pro_title'];

			$data['product_name']= $page_request_pro_info['product_name'];
			$data['product_id']  = $page_request_pro_info['product_id'];
			if($page_request_pro_info['product_id']) {
				$data['product_url'] = $this->url->link('catalog/product/edit&token='. $this->session->data['token'] .'&product_id='. $page_request_pro_info['product_id']);
			} else{
				$data['product_url'] = '';
			}

			$data['ip'] = $page_request_pro_info['ip'];
			$data['user_agent'] = $page_request_pro_info['user_agent'];
			$data['firstname'] = $page_request_pro_info['firstname'];
			$data['lastname'] = $page_request_pro_info['lastname'];

			if ($page_request_pro_info['customer_id']) {
				$data['customer'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $page_request_pro_info['customer_id'], true);
			} else {
				$data['customer'] = '';
			}

			if ($page_request_pro_info['page_form_pro_id']) {
				$data['page_form_pro_href'] = $this->url->link('page/page_form_pro/edit', 'token=' . $this->session->data['token'] . '&page_form_pro_id=' . $page_request_pro_info['page_form_pro_id'], true);
			} else {
				$data['page_form_pro_href'] = '';
			}

			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

			if(VERSION > '2.0.3.1') {
				$this->load->model('customer/customer_group');
				$customer_group_info = $this->model_customer_customer_group->getCustomerGroup($page_request_pro_info['customer_group_id']);
			} else{
				$this->load->model('sale/customer_group');
				$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($page_request_pro_info['customer_group_id']);
			}

			if ($customer_group_info) {
				$data['customer_group'] = $customer_group_info['name'];
			} else {
				$data['customer_group'] = '';
			}

			// Uploaded files
			$this->load->model('tool/upload');

			$data['page_request_pro_id'] = $this->request->get['page_request_pro_id'];

			$page_request_pro_options = $this->model_page_page_request_pro->getPageRequestProOptions($page_request_pro_id);

			$data['page_request_pro_options'] = array();
			foreach($page_request_pro_options as $page_request_pro_option) {
				if($page_request_pro_option['type'] == 'password' || $page_request_pro_option['type'] == 'confirm_password') {
					$page_request_pro_option['value'] = unserialize(base64_decode($page_request_pro_option['value']));
				}

				if ($page_request_pro_option['type'] != 'file') {
					$data['page_request_pro_options'][] = array(
						'name'		=> $page_request_pro_option['name'],
						'value'		=> $page_request_pro_option['value'],
						'type'		=> $page_request_pro_option['type'],
					);
				} else{
					$upload_info = $this->model_tool_upload->getUploadByCode($page_request_pro_option['value']);
					if ($upload_info) {
						$data['page_request_pro_options'][] = array(
							'name'  => $page_request_pro_option['name'],
							'value' => $upload_info['name'],
							'type'  => $page_request_pro_option['type'],
							'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], true)
						);
					}
				}
			}

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('page/page_request_pro_info.tpl', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'page/page_request_pro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}