<?php
class ControllerSaleOrder extends Controller {
	private $error = array();

			public function ordersgls() {
		$this->load->language('sale/order_glslabel');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getListGls();
	}
	
	protected function getListGls() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_from'])) {
			$filter_date_from = $this->request->get['filter_date_from'];
		} else {
			$filter_date_from = null;
		}

		if (isset($this->request->get['filter_date_to'])) {
			$filter_date_to = $this->request->get['filter_date_to'];
		} else {
			$filter_date_to = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
		);

				$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], true);
		$data['aviz'] = $this->url->link('sale/order/aviz', 'token=' . $this->session->data['token'], true);

		$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'], true);
		$data['add'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'], true);

		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_order_status'  => $filter_order_status,
			'filter_total'         => $filter_total,
			'filter_date_from'     => $filter_date_from,
			'filter_date_to'	   => $filter_date_to,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_sale_order->getTotalOrders($filter_data);

		$results = $this->model_sale_order->getOrdersGls($filter_data);

		// GLS STATUS CODES START
		$data['status_code'][1] = 'APL- Registration';
		$data['status_code'][2] = 'HUB-Outbound scan';
		$data['status_code'][3] = 'Depot entry';
		$data['status_code'][4] = 'Delivery list scan';
		$data['status_code'][5] = 'Delivered';
		$data['status_code'][6] = 'HUB Storage';
		$data['status_code'][7] = 'Depot Storage';
		$data['status_code'][8] = 'picked up by recipient';
		$data['status_code'][9] = 'fixed delivery';
		$data['status_code'][11] = 'holiday';
		$data['status_code'][12] = 'notice left';
		$data['status_code'][13] = 'depo routing failure';
		$data['status_code'][14] = 'closed';
		$data['status_code'][15] = 'lack of time';
		$data['status_code'][16] = 'lack of money';
		$data['status_code'][17] = 'refused';
		$data['status_code'][18] = 'wrong address';
		$data['status_code'][19] = 'unreachable';
		$data['status_code'][20] = 'wrong ZIP';
		$data['status_code'][21] = 'missorted';
		$data['status_code'][22] = 'back to the HUB';
		$data['status_code'][23] = 'back to the shipper';
		$data['status_code'][24] = 'depot re-delivery';
		$data['status_code'][25] = 'misrouted';
		$data['status_code'][26] = 'HUB-Inbound';
		$data['status_code'][27] = 'Small Parcel';
		$data['status_code'][28] = 'HUB damaged';
		$data['status_code'][29] = 'no data available';
		$data['status_code'][30] = 'damaged';
		$data['status_code'][31] = 'totally damaged';
		$data['status_code'][32] = 'delivery in the evening';
		$data['status_code'][33] = 'too many waiting';
		$data['status_code'][34] = 'delivery too late';
		$data['status_code'][35] = 'not ordered';
		$data['status_code'][36] = 'closed entrance';
		$data['status_code'][37] = 'central ordered';
		$data['status_code'][38] = 'No delivery note';
		$data['status_code'][39] = 'Do not confirm the delivery note';
		$data['status_code'][43] = 'Lost';
		$data['status_code'][44] = 'Not Systemlike Parcel';
		$data['status_code'][46] = 'Change of delivery address';
		$data['status_code'][47] = 'transferred to subcontractor';
		$data['status_code'][51] = 'Data sent';
		$data['status_code'][52] = 'COD data sent';
		$data['status_code'][53] = 'DEPOT TRANSIT';
		$data['status_code'][55] = 'Parcelshop deposit';
		$data['status_code'][56] = 'Parcelshop storage';
		$data['status_code'][57] = 'ParcelSHOP return';
		$data['status_code'][58] = 'Delivered to neighbour';
		$data['status_code'][80] = 'CHANGD DLIVERYADRES';
		$data['status_code'][81] = 'RQINFO NORMAL';
		$data['status_code'][82] = 'REQFWD MISROUTED';
		$data['status_code'][83] = 'P&S/P&R registered';
		$data['status_code'][84] = 'P&S/P&R printed';
		$data['status_code'][85] = 'P&S/P&R on rollkarte';
		$data['status_code'][86] = 'P&S/P&R picked up';
		$data['status_code'][87] = 'no P&S/P&R parcel';
		$data['status_code'][88] = 'küldemény nem áll készen';
		$data['status_code'][89] = 'kevesebb csomagcímke';
		$data['status_code'][90] = 'feladva más úton';
		$data['status_code'][91] = 'P&S, P&R cancelled';
		$data['status_code'][94] = 'CsomagPont status info';
		// GLS STATUS CODES STOP


		foreach ($results as $result) {
			//echo $result['gls_track'];
			// ZAMFI MODIFICATION START
			//print_r($order_info);
			$gls_status = "";
			if(is_numeric($result['gls_track']) && $result['gls_track'] > 0){
				$xmlstring = file_get_contents('http://online.gls-romania.ro/tt_page_xml.php?pclid='.$result['gls_track']);
				if($xml = @simplexml_load_string ($xmlstring)){
					$json = json_encode($xml);
					$array = json_decode($json,TRUE);
					$tracking_array = $array['Parcel']['Statuses']['Status'];
					foreach($tracking_array as $tracking){
						$data['tracking_gls'][] = $tracking['@attributes'];
					}
				}
				if(isset($tracking_array[0]['@attributes']['StCode'])){
					$gls_status = $data['status_code'][$tracking_array[0]['@attributes']['StCode']];
				}
			}

			// ZAMFI MODIFICATION STOP

			$data['orders'][] = array(
				'gls_status'	=> $gls_status,
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'order_status'  => $result['order_status'],
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'shipping_code' => $result['shipping_code'],
				'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
				'edit'          => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_gls_status'] = $this->language->get('column_gls_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');
		$data['entry_date_from'] = $this->language->get('entry_date_from');
		$data['entry_date_to'] = $this->language->get('entry_date_to');

		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
			$data['buton_aviz'] = $this->language->get('buton_aviz');

		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, true);
		$data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);
		$data['sort_gls_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=gls_status' . $url, true);
		$data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_total'] = $filter_total;
		$data['filter_date_from'] = $filter_date_from;
		$data['filter_date_to'] = $filter_date_to;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

		// API login
		$this->load->model('user/api');

		$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

		if ($api_info) {
			$data['api_id'] = $api_info['api_id'];
			$data['api_key'] = $api_info['key'];
			$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
		} else {
			$data['api_id'] = '';
			$data['api_key'] = '';
			$data['api_ip'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_list_gls', $data));
	}

	public function gls_label() {

		$this->load->language('sale/order_glslabel');
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}


		$data['title'] = $this->language->get('text_invoice');
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_invoice'] = $this->language->get('text_invoice');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_payment_address'] = $this->language->get('text_payment_address');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');

		$data['glsform_name']               = $this->language->get('glsform_name');
		$data['glsform_address']            = $this->language->get('glsform_address');
		$data['glsform_postcode']           = $this->language->get('glsform_postcode');
		$data['glsform_city']               = $this->language->get('glsform_city');
		$data['glsform_country']            = $this->language->get('glsform_country');
		$data['glsform_contact']            = $this->language->get('glsform_contact');
		$data['glsform_phone']              = $this->language->get('glsform_phone');
		$data['glsform_email']              = $this->language->get('glsform_email');

		$data['glsform_pickupdate']         = $this->language->get('glsform_pickupdate');
		$data['glsform_info']               = $this->language->get('glsform_info');
		$data['glsform_clientref']          = $this->language->get('glsform_clientref');
		$data['glsform_codamount']          = $this->language->get('glsform_codamount');
		$data['glsform_codref']             = $this->language->get('glsform_codref');
		$data['glsform_date']               = $this->language->get('glsform_date');
		$data['glsform_document_number']    = $this->language->get('glsform_document_number');
		$data['glsform_max_insurance_value']= $this->language->get('glsform_max_insurance_value');
		$data['glsform_sender']             = $this->language->get('glsform_sender');
		$data['glsform_recipient']          = $this->language->get('glsform_recipient');
		$data['glsform_settings']           = $this->language->get('glsform_settings');
		$data['glsform_choose_sender']      = $this->language->get('glsform_choose_sender');
		$data['glsform_sms_msg']            = $this->language->get('glsform_sms_msg');
		$data['glsform_printlabel']         = $this->language->get('glsform_printlabel');
		$data['glsform_create_label_for']   = $this->language->get('glsform_create_label_for');
		$data['glsform_services']  		    = $this->language->get('glsform_services');


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'], true)
		);

		$this->load->model('sale/order');
		$this->load->model('setting/setting');


		$data['orders'] = array();

		$orders = array();

		

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);


			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}


				$this->load->model('tool/upload');
				$this->load->model('extension/module');
				$data['senders'] = $this->model_extension_module->getModulesByCode('gls_sender');
				//print_r($data['senders']);
				$sender_json = array();
				$i = 0;
				foreach($data['senders'] as $sender){
					$sender_setting = json_decode($sender['setting']);
					//print_r($sender_setting);

					if(!isset($gls_api_country)) { $gls_api_country = $sender_setting->gls_api; }
					if(!isset($gls_senderid)) { $gls_senderid = $sender_setting->gls_senderid; }
					if(!isset($gls_username)) { $gls_username = $sender_setting->gls_username; }
					if(!isset($gls_password)) { $gls_password = $sender_setting->gls_password; }


					$sender_json[$i]['sender_api_country'] = $sender_setting->gls_api;
					$sender_json[$i]['sender_senderid'] = $sender_setting->gls_senderid;
					$sender_json[$i]['sender_username'] = $sender_setting->gls_username;
					$sender_json[$i]['sender_password'] = $sender_setting->gls_password;

					$sender_json[$i]['sender_name'] = $sender_setting->name;
					$sender_json[$i]['sender_address'] = $sender_setting->address;
					$sender_json[$i]['sender_postcode'] = $sender_setting->zip;
					$sender_json[$i]['sender_city'] = $sender_setting->city;
					$sender_json[$i]['sender_country'] = $sender_setting->country;
					$sender_json[$i]['sender_contact'] = $sender_setting->contact;
					$sender_json[$i]['sender_phone'] = $sender_setting->phone;
					$sender_json[$i]['sender_email'] = $sender_setting->email;
					$i++;
				}
				$data['sender_json'] = json_encode($sender_json);
				//print_r($data['sender_json']);

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}

					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$voucher_data = array();

				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$total_data = array();

				$totals = $this->model_sale_order->getOrderTotals($order_id);

				foreach ($totals as $total) {
					$total_data[] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				// SET RAMBURS START
				if (isset($this->request->post['gls_codamount'])) {
					$data['gls_codamount'] = $this->floattostr($this->request->post['gls_codamount']);
				} else {
					if($order_info['payment_method'] == 'Cash On Delivery') {
						$data['gls_codamount'] = $this->floattostr((end($totals)['value']));
					} else {
						$data['gls_codamount'] = '';
					}
				}


				if (isset($this->request->post['gls_pickupdate'])) {
					$data['gls_pickupdate'] = $this->request->post['gls_pickupdate'];
				} else {
					$data['gls_pickupdate'] = date('Y-m-d');
				}
				if (isset($this->request->post['gls_content'])) {
					$data['gls_content'] = $this->request->post['gls_content'];
				} else {
					$data['gls_content'] = "";
				}
				if (isset($this->request->post['gls_clientref'])) {
					$data['gls_clientref'] = $this->request->post['gls_clientref'];
				} else {
					$data['gls_clientref'] = $order_id;
				}
				if (isset($this->request->post['gls_codref'])) {
					$data['gls_codref'] = $this->request->post['gls_codref'];
				} else {
					$data['gls_codref'] = "";
				}


				// SET RAMBURS STOP
				if (isset($this->request->post['sender_username'])) {
					$data['sender_username'] = $this->request->post['sender_username'];
				} else {
					$data['sender_username'] = $gls_username;
				}
				if (isset($this->request->post['sender_password'])) {
					$data['sender_password'] = $this->request->post['sender_password'];
				} else {
					$data['sender_password'] = $gls_password;
				}
				if (isset($this->request->post['sender_senderid'])) {
					$data['sender_senderid'] = $this->request->post['sender_senderid'];
				} else {
					$data['sender_senderid'] = $gls_senderid;
				}
				if (isset($this->request->post['sender_api_country'])) {
					$data['sender_api_country'] = $this->request->post['sender_api_country'];
				} else {
					$data['sender_api_country'] = $gls_api_country;
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
					$data['gls_flex_delivery_email'] = "";
				}
				if (isset($this->request->post['gls_flex_delivery_sms'])) {
					$data['gls_flex_delivery_sms'] = $this->request->post['gls_flex_delivery_sms'];
				} else {
					$data['gls_flex_delivery_sms'] = "";
				}
				if (isset($this->request->post['gls_pick_ship'])) {
					$data['gls_pick_ship'] = $this->request->post['gls_pick_ship'];
				} else {
					$data['gls_pick_ship'] = $this->config->get('gls_pick_ship');
				}
				if (isset($this->request->post['gls_pick_ship_date'])) {
					$data['gls_pick_ship_date'] = $this->request->post['gls_pick_ship_date'];
				} else {
					$data['gls_pick_ship_date'] = $this->config->get('gls_pick_ship_date');
				}
				if (isset($this->request->post['gls_pick_return'])) {
					$data['gls_pick_return'] = $this->request->post['gls_pick_return'];
				} else {
					$data['gls_pick_return'] = $this->config->get('gls_pick_return');
				}
				if (isset($this->request->post['gls_pick_return_date'])) {
					$data['gls_pick_return_date'] = $this->request->post['gls_pick_return_date'];
				} else {
					$data['gls_pick_return_date'] = $this->config->get('gls_pick_return_date');
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
				if (isset($this->request->post['gls_preadvice_phone'])) {
					$data['gls_preadvice_phone'] = $this->request->post['gls_preadvice_phone'];
				} else {
					$data['gls_preadvice_phone'] = "";
				}
				if (isset($this->request->post['gls_exchange_service'])) {
					$data['gls_exchange_service'] = $this->request->post['gls_exchange_service'];
				} else {
					$data['gls_exchange_service'] = "";
				}
				if (isset($this->request->post['gls_docreturn'])) {
					$data['gls_docreturn'] = $this->request->post['gls_docreturn'];
				} else {
					$data['gls_docreturn'] = $this->config->get('gls_docreturn');
				}
				if (isset($this->request->post['gls_docreturn_num'])) {
					$data['gls_docreturn_num'] = $this->request->post['gls_docreturn_num'];
				} else {
					$data['gls_docreturn_num'] = "";
				}
				if (isset($this->request->post['gls_declaredvalueinsurance'])) {
					$data['gls_declaredvalueinsurance'] = $this->request->post['gls_declaredvalueinsurance'];
				} else {
					$data['gls_declaredvalueinsurance'] = $this->config->get('gls_declaredvalueinsurance');
				}
				if (isset($this->request->post['gls_declaredvalueinsurance_num'])) {
					$data['gls_declaredvalueinsurance_num'] = $this->request->post['gls_declaredvalueinsurance_num'];
				} else {
					$data['gls_declaredvalueinsurance_num'] = "";
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => isset($this->request->post['shipping_phone']) ? $this->request->post['shipping_phone'] : $order_info['telephone'],
					'shipping_method'  => $order_info['shipping_method'],
					'payment_method'   => $order_info['payment_method'],
					'product'          => $product_data,
					'voucher'          => $voucher_data,
					'total'            => $total_data,
					'comment'          => nl2br($order_info['comment']),
					'shipping_name'		=> isset($this->request->post['shipping_name']) ? $this->request->post['shipping_name'] : $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
					'shipping_company'  => isset($this->request->post['shipping_company']) ? $this->request->post['shipping_company'] : $order_info['shipping_company'],
					'shipping_address'	=> isset($this->request->post['shipping_address']) ? $this->request->post['shipping_address'] : $order_info['shipping_address_1'] . $order_info['shipping_address_2'],
					'shipping_city'      => isset($this->request->post['shipping_city']) ? $this->request->post['shipping_city'] : $order_info['shipping_city'],
					'shipping_postcode'  => isset($this->request->post['shipping_postcode']) ? $this->request->post['shipping_postcode'] : $order_info['shipping_postcode'],
					'shipping_zone'      => isset($this->request->post['shipping_zone']) ? $this->request->post['shipping_zone'] : $order_info['shipping_zone'],
					'shipping_zone_code' => isset($this->request->post['shipping_zone_code']) ? $this->request->post['shipping_zone_code'] : $order_info['shipping_zone_code'],
					'shipping_contact'   => isset($this->request->post['shipping_contact']) ? $this->request->post['shipping_contact'] : "",
					'shipping_country'   => isset($this->request->post['shipping_country']) ? $this->request->post['shipping_country'] : $order_info['shipping_country']
				);

				// VALIDATE AND PRINT LABEL
				if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate_gls()) {
					date_default_timezone_set("Europe/Bucharest");

					$gls_services = array();
					if(isset($this->request->post['gls_express_parcel'])){
						array_push($gls_services,array('code'=>'T12','info'=>''));
					}
					if(isset($this->request->post['gls_flex_delivery']) && strlen($this->request->post['gls_flex_delivery_email']) > 1){
						array_push($gls_services,array('code'=>'FDS','info'=>$this->request->post['gls_flex_delivery_email']));
					}
					if(isset($this->request->post['gls_flex_delivery']) && strlen($this->request->post['gls_flex_delivery_sms']) > 1){
						array_push($gls_services,array('code'=>'FSS','info'=>$this->request->post['gls_flex_delivery_sms']));
					}
					if(isset($this->request->post['gls_sms']) && strlen($this->request->post['gls_sms_msg']) > 1 && strlen($this->request->post['shipping_phone']) > 1){
						array_push($gls_services,array('code'=>'SM1','info'=>$this->request->post['shipping_phone'] . '|' .$this->request->post['gls_sms_msg']));
					}
					if(isset($this->request->post['gls_preadvice']) && strlen($this->request->post['gls_preadvice_phone']) > 1){
						array_push($gls_services,array('code'=>'SM2','info'=>$this->request->post['gls_preadvice_phone']));
					}
					if(isset($this->request->post['gls_pick_ship']) && strlen($this->request->post['gls_pick_ship_date']) > 1){
						array_push($gls_services,array('code'=>'PSS','info'=>$this->request->post['gls_pick_ship_date']));
					}
					if(isset($this->request->post['gls_pick_return']) && strlen($this->request->post['gls_pick_return_date']) > 1){
						array_push($gls_services,array('code'=>'PRS','info'=>$this->request->post['gls_pick_return_date']));
					}
					if(isset($this->request->post['gls_exchange_service'])){
						array_push($gls_services,array('code'=>'XS','info'=>''));
					}
					if(isset($this->request->post['gls_docreturn']) && strlen($this->request->post['gls_docreturn_num']) > 0){
						array_push($gls_services,array('code'=>'SZL','info'=>$this->request->post['gls_docreturn_num']));
					}
					if(isset($this->request->post['gls_declaredvalueinsurance']) && strlen($this->request->post['gls_declaredvalueinsurance_num']) > 0){
						array_push($gls_services,array('code'=>'INS','info'=>$this->request->post['gls_declaredvalueinsurance_num']));
					}
					//print_r($gls_services);
					//die();

					require_once(DIR_APPLICATION.'lib/soap/nusoap.php');
					//$_HTTP = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
					//$wsdl_path = $_HTTP . $_SERVER['HTTP_HOST'] . '/webservices/soap_server.php?wsdl';
					$wsdl_path = 'https://online.gls-romania.ro/webservices/soap_server.php?wsdl';
					switch($data['sender_api_country']){
						case 'romania':
							$wsdl_path = 'https://online.gls-romania.ro/webservices/soap_server.php?wsdl';
							break;
						case 'hungary':
							$wsdl_path = 'https://online.gls-hungary.com/webservices/soap_server.php?wsdl';
							break;
						case 'slovakia':
							$wsdl_path = 'https://online.gls-slovakia.sk/webservices/soap_server.php?wsdl';
							break;
						case 'czech':
							$wsdl_path = 'https://online.gls-czech.com/webservices/soap_server.php?wsdl';
							break;
						case 'slovenia':
							$wsdl_path = 'https://connect.gls-slovenia.com/webservices/soap_server.php?wsdl';
							break;
						case 'croatia':
							$wsdl_path = 'https://online.gls-croatia.com/webservices/soap_server.php?wsdl';
							break;
					}
					$client = new nusoap_client($wsdl_path, 'wsdl');
					$client->soap_defencoding = 'UTF-8';
					$client->decode_utf8 = false;
					$in = array(
						'username' => $data['sender_username'],
						'password' => $data['sender_password'],
						'senderid' => $data['sender_senderid'],
						'sender_name' => $this->request->post['sender_name'],
						'sender_address' => $this->request->post['sender_address'],
						'sender_city' => $this->request->post['sender_city'],
						'sender_zipcode' => $this->request->post['sender_postcode'],
						'sender_country' => $this->request->post['sender_country'],
						'sender_contact' => $this->request->post['sender_contact'],
						'sender_phone' => $this->request->post['sender_phone'],
						'sender_email' => $this->request->post['sender_email'],
						'consig_name' => $this->request->post['shipping_name'],
						'consig_address' => $this->request->post['shipping_address'],
						'consig_city' => $this->request->post['shipping_city'],
						'consig_zipcode' => $this->request->post['shipping_postcode'],
						'consig_country' => $this->request->post['shipping_country'],
						'consig_contact' => $this->request->post['shipping_contact'],
						'consig_phone' => $this->request->post['shipping_phone'],
						'consig_email' => $this->request->post['shipping_email'],
						'pcount' => 1,
						'pickupdate' => $this->request->post['gls_pickupdate'],
						'content' => $this->request->post['gls_content'],
						'clientref' => $this->request->post['gls_clientref'],
						'codamount' => $this->request->post['gls_codamount'],
						'codref' => $this->request->post['gls_codref'],
						'services' => $gls_services,
						'printertemplate' => 'A4_2x2',
						'printit' => true,
						'timestamp' => date('YmdHis'),//'20140129150000',
						'hash' => 'xsd:string');



					$in['hash'] = $this->getHash($in);
					$return = $client->call('printlabel', $in);
					if ($return) {
						if (isset($return['successfull']) && $return['successfull']) {
							if(isset($return['pcls'][0])){
								$this->db->query("UPDATE `" . DB_PREFIX . "order` SET gls_track = '" . $return['pcls'][0] . "' WHERE order_id = '" . (int)$order_id . "'");
							}
							//print_r($return['pcls']);
							header('Content-type: application/pdf');
							die(base64_decode($return['pdfdata']));
						} else {
							$data['error_gls'] = $return['errdesc'];
							//print_r($return);
						}
					}


				}

				$validation_error_fields = array(
					'sender_name',
					'sender_address',
					'sender_postcode',
					'sender_city',
					'sender_country',
					'sender_contact',
					'sender_phone',
					'sender_email',
					'shipping_name',
					'shipping_address',
					'shipping_postcode',
					'shipping_city',
					'shipping_country',
					'shipping_contact',
					'shipping_phone',
					'shipping_email'
				);
				foreach ($validation_error_fields as $error_field){
					if (isset($this->error[$error_field])) {
						$data['error'][$error_field] = $this->error[$error_field];
					} else {
						$data['error'][$error_field] = '';
					}
				}



			}
		}

		$data['postcodes_url'] = $this->url->link('sale/order/get_orase&token='.$this->session->data['token']);
		//print_r($data['postcodes_url']);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_glslabel', $data));
	}

	public function get_orase()
	{
		$this->load->model('sale/order');
		$postcodes = $this->model_sale_order->getGlsPostcodes();
		$postcodefinal = array();
		echo json_encode($postcodes);

	}

	private function validate_gls()
	{
		$validation_error_fields = array(
			'sender_name',
			'sender_address',
			'sender_postcode',
			'sender_city',
			'sender_country',
			'shipping_name',
			'shipping_address',
			'shipping_postcode',
			'shipping_city',
			'shipping_country',
		);
		foreach ($validation_error_fields as $error_field) {
			if (strlen($this->request->post[$error_field]) < 1) {
				$this->error[$error_field] = 'This field is required';
			}

		}
		return !$this->error;
	}

	private function getHash($data) {
		$hashBase = '';
		foreach($data as $key => $value) {
			if ($key != 'services'
				&& $key != 'hash'
				&& $key != 'timestamp'
				&& $key != 'printit'
				&& $key != 'printertemplate') {
				$hashBase .= $value;
			}
		}
		return sha1($hashBase);
	}

	private function floattostr( $val )
	{
		preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
		return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}
			

	public function index() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getList();
	}

	public function add() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getForm();
	}

	public function edit() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getForm();
	}
	
	public function delete() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $order_id) {
				$this->model_sale_order->deleteOrder($order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
	
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
	
			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}
	
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}
	
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
	
			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			$this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
		);

				$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], true);
		$data['aviz'] = $this->url->link('sale/order/aviz', 'token=' . $this->session->data['token'], true);

		$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'], true);
		$data['add'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'], true);

		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_order_status'  => $filter_order_status,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_sale_order->getTotalOrders($filter_data);

		$results = $this->model_sale_order->getOrders($filter_data);

		foreach ($results as $result) {
			$data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'shipping_code' => $result['shipping_code'],
				'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
				'edit'          => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');

		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
			$data['buton_aviz'] = $this->language->get('buton_aviz');

		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, true);
		$data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_list', $data));
	}

	public function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
		$data['text_product'] = $this->language->get('text_product');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_order_detail'] = $this->language->get('text_order_detail');

		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_to_name'] = $this->language->get('entry_to_name');
		$data['entry_to_email'] = $this->language->get('entry_to_email');
		$data['entry_from_name'] = $this->language->get('entry_from_name');
		$data['entry_from_email'] = $this->language->get('entry_from_email');
		$data['entry_theme'] = $this->language->get('entry_theme');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
		$data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$data['entry_coupon'] = $this->language->get('entry_coupon');
		$data['entry_voucher'] = $this->language->get('entry_voucher');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_order_status'] = $this->language->get('entry_order_status');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_refresh'] = $this->language->get('button_refresh');
		$data['button_product_add'] = $this->language->get('button_product_add');
		$data['button_voucher_add'] = $this->language->get('button_voucher_add');
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['tab_order'] = $this->language->get('tab_order');
		$data['tab_customer'] = $this->language->get('tab_customer');
		$data['tab_payment'] = $this->language->get('tab_payment');
		$data['tab_shipping'] = $this->language->get('tab_shipping');
		$data['tab_product'] = $this->language->get('tab_product');
		$data['tab_voucher'] = $this->language->get('tab_voucher');
		$data['tab_total'] = $this->language->get('tab_total');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true);

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		}

		if (!empty($order_info)) {
			$data['order_id'] = $this->request->get['order_id'];
			$data['store_id'] = $order_info['store_id'];
			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

			$data['customer'] = $order_info['customer'];
			$data['customer_id'] = $order_info['customer_id'];
			$data['customer_group_id'] = $order_info['customer_group_id'];
			$data['firstname'] = $order_info['firstname'];
			$data['lastname'] = $order_info['lastname'];
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['fax'] = $order_info['fax'];
			$data['account_custom_field'] = $order_info['custom_field'];

			$this->load->model('customer/customer');

			$data['addresses'] = $this->model_customer_customer->getAddresses($order_info['customer_id']);

			$data['payment_firstname'] = $order_info['payment_firstname'];
			$data['payment_lastname'] = $order_info['payment_lastname'];
			$data['payment_company'] = $order_info['payment_company'];
			$data['payment_address_1'] = $order_info['payment_address_1'];
			$data['payment_address_2'] = $order_info['payment_address_2'];
			$data['payment_city'] = $order_info['payment_city'];
			$data['payment_postcode'] = $order_info['payment_postcode'];
			$data['payment_country_id'] = $order_info['payment_country_id'];
			$data['payment_zone_id'] = $order_info['payment_zone_id'];
			$data['payment_custom_field'] = $order_info['payment_custom_field'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['payment_code'] = $order_info['payment_code'];

			$data['shipping_firstname'] = $order_info['shipping_firstname'];
			$data['shipping_lastname'] = $order_info['shipping_lastname'];
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_address_1'] = $order_info['shipping_address_1'];
			$data['shipping_address_2'] = $order_info['shipping_address_2'];
			$data['shipping_city'] = $order_info['shipping_city'];
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_country_id'] = $order_info['shipping_country_id'];
			$data['shipping_zone_id'] = $order_info['shipping_zone_id'];
			$data['shipping_custom_field'] = $order_info['shipping_custom_field'];
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['shipping_code'] = $order_info['shipping_code'];

			// Products
			$data['order_products'] = array();

			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$data['order_products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']),
					'quantity'   => $product['quantity'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'reward'     => $product['reward']
				);
			}

			// Vouchers
			$data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';

			$data['order_totals'] = array();

			$order_totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			foreach ($order_totals as $order_total) {
				// If coupon, voucher or reward points
				$start = strpos($order_total['title'], '(') + 1;
				$end = strrpos($order_total['title'], ')');

				if ($start && $end) {
					$data[$order_total['code']] = substr($order_total['title'], $start, $end - $start);
				}
			}

			$data['order_status_id'] = $order_info['order_status_id'];
			$data['comment'] = $order_info['comment'];
			$data['affiliate_id'] = $order_info['affiliate_id'];
			$data['affiliate'] = $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'];
			$data['currency_code'] = $order_info['currency_code'];
		} else {
			$data['order_id'] = 0;
			$data['store_id'] = 0;
			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			
			$data['customer'] = '';
			$data['customer_id'] = '';
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$data['firstname'] = '';
			$data['lastname'] = '';
			$data['email'] = '';
			$data['telephone'] = '';
			$data['fax'] = '';
			$data['customer_custom_field'] = array();

			$data['addresses'] = array();

			$data['payment_firstname'] = '';
			$data['payment_lastname'] = '';
			$data['payment_company'] = '';
			$data['payment_address_1'] = '';
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_country_id'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_custom_field'] = array();
			$data['payment_method'] = '';
			$data['payment_code'] = '';

			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_custom_field'] = array();
			$data['shipping_method'] = '';
			$data['shipping_code'] = '';

			$data['order_products'] = array();
			$data['order_vouchers'] = array();
			$data['order_totals'] = array();

			$data['order_status_id'] = $this->config->get('config_order_status_id');
			$data['comment'] = '';
			$data['affiliate_id'] = '';
			$data['affiliate'] = '';
			$data['currency_code'] = $this->config->get('config_currency');

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
		}

		// Stores
		$this->load->model('setting/store');

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}

		// Customer Groups
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// Custom Fields
		$this->load->model('customer/custom_field');

		$data['custom_fields'] = array();

		$filter_data = array(
			'sort'  => 'cf.sort_order',
			'order' => 'ASC'
		);

		$custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);

		foreach ($custom_fields as $custom_field) {
			$data['custom_fields'][] = array(
				'custom_field_id'    => $custom_field['custom_field_id'],
				'custom_field_value' => $this->model_customer_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
				'name'               => $custom_field['name'],
				'value'              => $custom_field['value'],
				'type'               => $custom_field['type'],
				'location'           => $custom_field['location'],
				'sort_order'         => $custom_field['sort_order']
			);
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['voucher_min'] = $this->config->get('config_voucher_min');

		$this->load->model('sale/voucher_theme');

		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		// API login
		$data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
		
		$this->load->model('user/api');

		$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

		if ($api_info) {
			
			$data['api_id'] = $api_info['api_id'];
			$data['api_key'] = $api_info['key'];
			$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
		} else {
			$data['api_id'] = '';
			$data['api_key'] = '';
			$data['api_ip'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_form', $data));
	}

	public function info() {

                $orderData = $this->db->query("SELECT smartbill_document_url FROM `" . DB_PREFIX . "order` WHERE `order_id`=" . (int)$this->request->get['order_id']);
                $data['smartbill'] = $this->url->link('smartbill/document', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
                $data['button_smartbill'] = !empty($orderData->rows[0]['smartbill_document_url']) ? 'Vizualizeaza document' : 'Emite document';
            
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_customer_detail'] = $this->language->get('text_customer_detail');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_store'] = $this->language->get('text_store');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_customer_group'] = $this->language->get('text_customer_group');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_invoice'] = $this->language->get('text_invoice');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_affiliate'] = $this->language->get('text_affiliate');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_account_custom_field'] = $this->language->get('text_account_custom_field');
			$data['text_payment_custom_field'] = $this->language->get('text_payment_custom_field');
			$data['text_shipping_custom_field'] = $this->language->get('text_shipping_custom_field');
			$data['text_browser'] = $this->language->get('text_browser');
			$data['text_ip'] = $this->language->get('text_ip');
			$data['text_forwarded_ip'] = $this->language->get('text_forwarded_ip');
			$data['text_user_agent'] = $this->language->get('text_user_agent');
			$data['text_accept_language'] = $this->language->get('text_accept_language');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_history_add'] = $this->language->get('text_history_add');
			$data['text_loading'] = $this->language->get('text_loading');

			$data['column_product'] = $this->language->get('column_product');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['entry_order_status'] = $this->language->get('entry_order_status');
			$data['entry_notify'] = $this->language->get('entry_notify');
			$data['entry_override'] = $this->language->get('entry_override');
			$data['entry_comment'] = $this->language->get('entry_comment');

			$data['help_override'] = $this->language->get('help_override');

			$data['button_invoice_print'] = $this->language->get('button_invoice_print');
			$data['buton_aviz'] = $this->language->get('buton_aviz');

			$data['button_shipping_print'] = $this->language->get('button_shipping_print');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_generate'] = $this->language->get('button_generate');
			$data['button_reward_add'] = $this->language->get('button_reward_add');
			$data['button_reward_remove'] = $this->language->get('button_reward_remove');
			$data['button_commission_add'] = $this->language->get('button_commission_add');
			$data['button_commission_remove'] = $this->language->get('button_commission_remove');
			$data['button_history_add'] = $this->language->get('button_history_add');
			$data['button_ip_add'] = $this->language->get('button_ip_add');

			$data['tab_history'] = $this->language->get('tab_history');
			$data['tab_additional'] = $this->language->get('tab_additional');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
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

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
						$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			$data['aviz'] = $this->url->link('sale/order/aviz', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);


			$data['glslabel'] = $this->url->link('sale/order/gls_label', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true); // ZAMFI GLS MODIFICATION
			$data['glslabel_print'] = $this->url->link('sale/order/gls_label', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'].'&gls_printnow=true', true); // ZAMFI GLS MODIFICATION
			
			$data['edit'] = $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true);

			$data['token'] = $this->session->data['token'];

			$data['order_id'] = $this->request->get['order_id'];

			$data['store_id'] = $order_info['store_id'];
			$data['store_name'] = $order_info['store_name'];
			
			if ($order_info['store_id'] == 0) {
				$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			} else {
				$data['store_url'] = $order_info['store_url'];
			}

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

			$data['firstname'] = $order_info['firstname'];
			$data['lastname'] = $order_info['lastname'];

			if ($order_info['customer_id']) {
				$data['customer'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], true);
			} else {
				$data['customer'] = '';
			}

			$this->load->model('customer/customer_group');

			$customer_group_info = $this->model_customer_customer_group->getCustomerGroup($order_info['customer_group_id']);

			if ($customer_group_info) {
				$data['customer_group'] = $customer_group_info['name'];
			} else {
				$data['customer_group'] = '';
			}

			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];

			$data['shipping_method'] = $order_info['shipping_method'];
			$data['payment_method'] = $order_info['payment_method'];

			// Payment Address
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			// Shipping Address
			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			// Uploaded files
			$this->load->model('tool/upload');

			$data['products'] = array();

			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $upload_info['name'],
								'type'  => $option['type'],
								'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], true)
							);
						}
					}
				}

				$data['products'][] = array(
					'order_product_id' => $product['order_product_id'],
					'product_id'       => $product['product_id'],
					'name'    	 	   => $product['name'],
					'model'    		   => $product['model'],
					'option'   		   => $option_data,
					'quantity'		   => $product['quantity'],
					'price'    		   => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    		   => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'href'     		   => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], true)
				);
			}

			$data['vouchers'] = array();

			$vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					'href'        => $this->url->link('sale/voucher/edit', 'token=' . $this->session->data['token'] . '&voucher_id=' . $voucher['voucher_id'], true)
				);
			}

			$data['totals'] = array();

			$totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

						$data['comment'] = nl2br($order_info['comment']);
			$data['shipping_code'] = $order_info['shipping_code'];


			$this->load->model('customer/customer');

			$data['reward'] = $order_info['reward'];

			$data['reward_total'] = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

			$data['affiliate_firstname'] = $order_info['affiliate_firstname'];
			$data['affiliate_lastname'] = $order_info['affiliate_lastname'];

			if ($order_info['affiliate_id']) {
				$data['affiliate'] = $this->url->link('marketing/affiliate/edit', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], true);
			} else {
				$data['affiliate'] = '';
			}

			$data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

			$this->load->model('marketing/affiliate');

			$data['commission_total'] = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

			$this->load->model('localisation/order_status');

			$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);

			if ($order_status_info) {
				$data['order_status'] = $order_status_info['name'];
			} else {
				$data['order_status'] = '';
			}

			$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

			$data['order_status_id'] = $order_info['order_status_id'];

			$data['account_custom_field'] = $order_info['custom_field'];

			// Custom Fields
			$this->load->model('customer/custom_field');

			$data['account_custom_fields'] = array();

			$filter_data = array(
				'sort'  => 'cf.sort_order',
				'order' => 'ASC'
			);

			$custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'account' && isset($order_info['custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['account_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['account_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['custom_field'][$custom_field['custom_field_id']]
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name']
							);
						}
					}
				}
			}

			// Custom fields
			$data['payment_custom_fields'] = array();

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['payment_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['payment_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['payment_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['payment_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}

			// Shipping
			$data['shipping_custom_fields'] = array();

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['shipping_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['shipping_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['shipping_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['shipping_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}

			$data['ip'] = $order_info['ip'];
			$data['forwarded_ip'] = $order_info['forwarded_ip'];
			$data['user_agent'] = $order_info['user_agent'];
			$data['accept_language'] = $order_info['accept_language'];

			// Additional Tabs
			$data['tabs'] = array();

			if ($this->user->hasPermission('access', 'extension/payment/' . $order_info['payment_code'])) {
				if (is_file(DIR_CATALOG . 'controller/extension/payment/' . $order_info['payment_code'] . '.php')) {
					$content = $this->load->controller('extension/payment/' . $order_info['payment_code'] . '/order');
				} else {
					$content = null;
				}

				if ($content) {
					$this->load->language('extension/payment/' . $order_info['payment_code']);

					$data['tabs'][] = array(
						'code'    => $order_info['payment_code'],
						'title'   => $this->language->get('heading_title'),
						'content' => $content
					);
				}
			}

			$this->load->model('extension/extension');

			$extensions = $this->model_extension_extension->getInstalled('fraud');

			foreach ($extensions as $extension) {
				if ($this->config->get($extension . '_status')) {
					$this->load->language('extension/fraud/' . $extension);

					$content = $this->load->controller('extension/fraud/' . $extension . '/order');

					if ($content) {
						$data['tabs'][] = array(
							'code'    => $extension,
							'title'   => $this->language->get('heading_title'),
							'content' => $content
						);
					}
				}
			}
			
			// The URL we send API requests to
			$data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			
			// API login
			$this->load->model('user/api');

			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

			if ($api_info) {
				$data['api_id'] = $api_info['api_id'];
				$data['api_key'] = $api_info['key'];
				$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
			} else {
				$data['api_id'] = '';
				$data['api_key'] = '';
				$data['api_ip'] = '';
			}

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');


			// ZAMFI MODIFICATION START
			//print_r($order_info);
			if(is_numeric($order_info['gls_track']) && $order_info['gls_track'] > 0){
				$xmlstring = file_get_contents('http://online.gls-romania.ro/tt_page_xml.php?pclid='.$order_info['gls_track']);
				if($xml = @simplexml_load_string ($xmlstring)){
					$json = json_encode($xml);
					$array = json_decode($json,TRUE);
					$tracking_array = $array['Parcel']['Statuses']['Status'];
					foreach($tracking_array as $tracking){
						$data['tracking_gls'][] = $tracking['@attributes'];
					}
				}
				//print_r($data['tracking_gls']);
			}
			// GLS STATUS CODES START
			$data['status_code'][1] = 'APL- Registration';
			$data['status_code'][2] = 'HUB-Outbound scan';
			$data['status_code'][3] = 'Depot entry';
			$data['status_code'][4] = 'Delivery list scan';
			$data['status_code'][5] = 'Delivered';
			$data['status_code'][6] = 'HUB Storage';
			$data['status_code'][7] = 'Depot Storage';
			$data['status_code'][8] = 'picked up by recipient';
			$data['status_code'][9] = 'fixed delivery';
			$data['status_code'][11] = 'holiday';
			$data['status_code'][12] = 'notice left';
			$data['status_code'][13] = 'depo routing failure';
			$data['status_code'][14] = 'closed';
			$data['status_code'][15] = 'lack of time';
			$data['status_code'][16] = 'lack of money';
			$data['status_code'][17] = 'refused';
			$data['status_code'][18] = 'wrong address';
			$data['status_code'][19] = 'unreachable';
			$data['status_code'][20] = 'wrong ZIP';
			$data['status_code'][21] = 'missorted';
			$data['status_code'][22] = 'back to the HUB';
			$data['status_code'][23] = 'back to the shipper';
			$data['status_code'][24] = 'depot re-delivery';
			$data['status_code'][25] = 'misrouted';
			$data['status_code'][26] = 'HUB-Inbound';
			$data['status_code'][27] = 'Small Parcel';
			$data['status_code'][28] = 'HUB damaged';
			$data['status_code'][29] = 'no data available';
			$data['status_code'][30] = 'damaged';
			$data['status_code'][31] = 'totally damaged';
			$data['status_code'][32] = 'delivery in the evening';
			$data['status_code'][33] = 'too many waiting';
			$data['status_code'][34] = 'delivery too late';
			$data['status_code'][35] = 'not ordered';
			$data['status_code'][36] = 'closed entrance';
			$data['status_code'][37] = 'central ordered';
			$data['status_code'][38] = 'No delivery note';
			$data['status_code'][39] = 'Do not confirm the delivery note';
			$data['status_code'][43] = 'Lost';
			$data['status_code'][44] = 'Not Systemlike Parcel';
			$data['status_code'][46] = 'Change of delivery address';
			$data['status_code'][47] = 'transferred to subcontractor';
			$data['status_code'][51] = 'Data sent';
			$data['status_code'][52] = 'COD data sent';
			$data['status_code'][53] = 'DEPOT TRANSIT';
			$data['status_code'][55] = 'Parcelshop deposit';
			$data['status_code'][56] = 'Parcelshop storage';
			$data['status_code'][57] = 'ParcelSHOP return';
			$data['status_code'][58] = 'Delivered to neighbour';
			$data['status_code'][80] = 'CHANGD DLIVERYADRES';
			$data['status_code'][81] = 'RQINFO NORMAL';
			$data['status_code'][82] = 'REQFWD MISROUTED';
			$data['status_code'][83] = 'P&S/P&R registered';
			$data['status_code'][84] = 'P&S/P&R printed';
			$data['status_code'][85] = 'P&S/P&R on rollkarte';
			$data['status_code'][86] = 'P&S/P&R picked up';
			$data['status_code'][87] = 'no P&S/P&R parcel';
			$data['status_code'][88] = 'küldemény nem áll készen';
			$data['status_code'][89] = 'kevesebb csomagcímke';
			$data['status_code'][90] = 'feladva más úton';
			$data['status_code'][91] = 'P&S, P&R cancelled';
			$data['status_code'][94] = 'CsomagPont status info';
			// GLS STATUS CODES STOP
			// ZAMFI MODIFICATION STOP
			
			$this->response->setOutput($this->load->view('sale/order_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function createInvoiceNo() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} elseif (isset($this->request->get['order_id'])) {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$invoice_no = $this->model_sale_order->createInvoiceNo($order_id);

			if ($invoice_no) {
				$json['invoice_no'] = $invoice_no;
			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addReward() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info && $order_info['customer_id'] && ($order_info['reward'] > 0)) {
				$this->load->model('customer/customer');

				$reward_total = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($order_id);

				if (!$reward_total) {
					$this->model_customer_customer->addReward($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['reward'], $order_id);
				}
			}

			$json['success'] = $this->language->get('text_reward_added');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeReward() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('customer/customer');

				$this->model_customer_customer->deleteReward($order_id);
			}

			$json['success'] = $this->language->get('text_reward_removed');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addCommission() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('marketing/affiliate');

				$affiliate_total = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($order_id);

				if (!$affiliate_total) {
					$this->model_marketing_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['commission'], $order_id);
				}
			}

			$json['success'] = $this->language->get('text_commission_added');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeCommission() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('marketing/affiliate');

				$this->model_marketing_affiliate->deleteTransaction($order_id);
			}

			$json['success'] = $this->language->get('text_commission_removed');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function history() {
		$this->load->language('sale/order');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$this->load->model('sale/order');

		$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('sale/order/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('sale/order_history', $data));
	}

	public function invoice() {
		$this->load->language('sale/order');

		$data['title'] = $this->language->get('text_invoice');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['text_invoice'] = $this->language->get('text_invoice');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_payment_address'] = $this->language->get('text_payment_address');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_comment'] = $this->language->get('text_comment');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');

		$this->load->model('sale/order');

		$this->load->model('setting/setting');

		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}

					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$voucher_data = array();

				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$total_data = array();

				$totals = $this->model_sale_order->getOrderTotals($order_id);

				foreach ($totals as $total) {
					$total_data[] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'payment_address'  => $payment_address,
					'payment_method'   => $order_info['payment_method'],
					'product'          => $product_data,
					'voucher'          => $voucher_data,
					'total'            => $total_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}

		$this->response->setOutput($this->load->view('sale/order_invoice', $data));
	}

	public function shipping() {
		$this->load->language('sale/order');

		$data['title'] = $this->language->get('text_shipping');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['text_shipping'] = $this->language->get('text_shipping');
		$data['text_picklist'] = $this->language->get('text_picklist');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_sku'] = $this->language->get('text_sku');
		$data['text_upc'] = $this->language->get('text_upc');
		$data['text_ean'] = $this->language->get('text_ean');
		$data['text_jan'] = $this->language->get('text_jan');
		$data['text_isbn'] = $this->language->get('text_isbn');
		$data['text_mpn'] = $this->language->get('text_mpn');
		$data['text_comment'] = $this->language->get('text_comment');

		$data['column_location'] = $this->language->get('column_location');
		$data['column_reference'] = $this->language->get('column_reference');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_weight'] = $this->language->get('column_weight');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');

		$this->load->model('sale/order');

		$this->load->model('catalog/product');

		$this->load->model('setting/setting');

		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			// Make sure there is a shipping method
			if ($order_info && $order_info['shipping_code']) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_weight = '';

					$product_info = $this->model_catalog_product->getProduct($product['product_id']);

					if ($product_info) {
						$option_data = array();

						$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

						foreach ($options as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

								if ($upload_info) {
									$value = $upload_info['name'];
								} else {
									$value = '';
								}
							}

							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $value
							);

							$product_option_value_info = $this->model_catalog_product->getProductOptionValue($product['product_id'], $option['product_option_value_id']);

							if ($product_option_value_info) {
								if ($product_option_value_info['weight_prefix'] == '+') {
									$option_weight += $product_option_value_info['weight'];
								} elseif ($product_option_value_info['weight_prefix'] == '-') {
									$option_weight -= $product_option_value_info['weight'];
								}
							}
						}

						$product_data[] = array(
							'name'     => $product_info['name'],
							'model'    => $product_info['model'],
							'option'   => $option_data,
							'quantity' => $product['quantity'],
							'location' => $product_info['location'],
							'sku'      => $product_info['sku'],
							'upc'      => $product_info['upc'],
							'ean'      => $product_info['ean'],
							'jan'      => $product_info['jan'],
							'isbn'     => $product_info['isbn'],
							'mpn'      => $product_info['mpn'],
							'weight'   => $this->weight->format(($product_info['weight'] + $option_weight) * $product['quantity'], $product_info['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point'))
						);
					}
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'product'          => $product_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}

		$this->response->setOutput($this->load->view('sale/order_shipping', $data));
	}

			public function aviz() {
		function convertor($s){	 
			$k1=array('una','doua','trei','patru','cinci','sase','sapte','opt','noua'); 
			$k2=array('unu','doi','trei','patru','cinci','sase','sapte','opt','noua'); 
			$w1=array('','mii','milioane','miliarde'); 
			$w2=array('','mie','milion','miliard'); 
			$s0=''; 
			$a=preg_split('//', $s, -1, PREG_SPLIT_NO_EMPTY); 
			$L=count($a); 
			$c=$L>3 ? round($L/3) : 0; 
			$d = $L % 3; 
			if ($d== 1){ 
				$a=array_reverse($a);
				array_push($a,'0');
				array_push($a,'0');
				$a=array_reverse($a); 
			} else if ($d== 2){ 
				$a=array_reverse($a); 
				array_push($a,'0'); 
				$a=array_reverse($a); 
				} 
			$k=0; 
			while ($k<$L){ 
				$p1=intval($a[$k]); 
				$p2=intval($a[$k+1]); 
				$p3=intval($a[$k+2]); 
				if ($p1>0) $s0.= ($p1==1) ? 'unasuta' : ($k1[$p1-1].'sute'); 
				if ($p2>0) $s0.= ($p2==1) ? (($p3>0)? $k2[$p3-1].'sprezece' : 'zece') : ($k1[$p2-1].'zeci'); 
				if ($p3>0) $s0.= ($p2==1) ? '' : (($p2==0) ? (($c==0) ? $k2[$p3-1] : (($c>=2 && $p3==1) ? 'un' : $k1[$p3-1]) )  : ('si'.$k2[$p3-1])); 
				if ($p1!=0 || $p2!=0 || $p3!=0){ 
				if ($p3==1 && $p2==0 && $p1==0) $s0.=$w2[$c]; 
				else $s0.=$w1[$c]; 
			} 
			$k+=3; 
			$c--; 
			} 
		return $s0; 
		} 

		function convertToLetters($n){ 
			$ar=explode('.',$n); 
			$nr = count($ar);
			if ($nr < 2)
				if ($ar[0]=='1') 
					$a = 'unleu'; 
				else 
					$a = convertor($ar[0]).'lei'; 

			else
				if ($ar[1]=='00')
					$a = convertor($ar[0]).'lei';		
				else	
				     	$a = convertor($ar[0]).'leisi'.convertor($ar[1]).'bani';
			return $a; 
		} 
        function convertToLettersP($n){ 
			$ar=explode('.',$n); 
			$nr = count($ar);
			if ($nr < 2)
				if ($ar[0]=='1') 
					$a = 'unleu'; 
				else 
					$a = convertor($ar[0]).'lei'; 

			else
				if ($ar[1]=='00')
					$a = convertor($ar[0]).'lei';		
				else	
				     	$a = convertor($ar[0]).'leisi'.$ar[1].'bani';
			return $a; 
		} 

		$this->load->model('sale/order');
				
		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}
		
		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);
		};

		require_once('fpdf/fpdf.php');
		require_once('fpdf/fpdi.php');
		$transdia = array("ă" => "a", "î" => "i", "ș" => "s", "ş" => "s","ț" => "t", "â" => "a","Ă" => "A", "Î" => "I", "Ș" => "S", "Ț" => "T", "Â" => "A");
		$insurance = number_format($this->config->get('posta_valoare'),2);
		$sir_insurance = convertToLetters($insurance);
		if ($order_info['payment_code']=='cod')
		$ramburs = number_format(round($order_info['total'],2),2);
		else
		$ramburs = "";
		if ($order_info['payment_code']=='cod')
		$sir_ramburs = convertToLetters($ramburs);
		else
		$sir_ramburs = "";
		if ($order_info['payment_code']=='cod')
        $sim_ramburs = convertToLettersP($ramburs);
		else
		$sim_ramburs = "";
		if ($order_info['payment_code']=='cod')
        $warn = "";
		else
		$warn = "ATENTIE! Comanda nu are ramburs! Taie si distruge partea de mai jos.";
		$exp_name = $this->config->get('posta_exp_name');
        $exp_cui = $this->config->get('posta_exp_cui');
		$exp_tel = $this->config->get('config_telephone');
		$exp_adr = $this->config->get('posta_exp_adr');
		$exp_code = $this->config->get('posta_exp_code');
		$exp_oras = $this->config->get('posta_exp_oras');
		$exp_jud = $this->config->get('posta_exp_jud');
		$exp_mail = $this->config->get('config_email');
		$exp_banca = $this->config->get('posta_exp_banca');
		$exp_sucursala = $this->config->get('posta_exp_sucursala');
		$exp_iban = $this->config->get('posta_exp_iban');
			
		$dest_name = strtr($order_info['shipping_firstname'], $transdia) .' '. strtr($order_info['shipping_lastname'], $transdia);

		$dest_tel = $order_info['telephone'];
		$dest_adr = strtr($order_info['shipping_address_1'], $transdia) .' '. strtr($order_info['shipping_address_2'], $transdia);
		$dest_cod = $order_info['shipping_postcode'];
		$dest_jud = $order_info['shipping_zone'];
		$dest_oras = strtr($order_info['shipping_city'], $transdia);
		$filename = $order_info['invoice_no'].'-C'. $order_info['order_id'].".pdf";
		$comanda = $order_info['order_id'];
		$factura = $order_info['invoice_no'];
		$serie = $order_info['invoice_prefix'];
		
		$pdf = new FPDI();
		$pdf->AddPage();
		$pdf->setSourceFile('controller/extension/shipping/form.compressed.pdf');
		$tplIdx = $pdf->importPage(1);

		$pdf->useTemplate($tplIdx);
		$pdf->SetFont('Arial');
		$pdf->SetFontSize(10);
        $pdf->RotatedText(177,45,"COLET",270);
		$pdf->RotatedText(177,100, "DIVERSE",270);
        $pdf->RotatedText(168,39, $insurance,270);
		$pdf->SetFont('Arial','B',8);
		$pdf->RotatedText(168,60, $sir_insurance,270);
        $pdf->SetFont('Arial','',10);
		$pdf->RotatedText(162,39, $ramburs,270);
        $pdf->SetFont('Arial','B',8);
		$pdf->RotatedText(162,60, $sir_ramburs,270);
        $pdf->SetFont('Arial','',10);
		$pdf->RotatedText(155,31, $dest_name,270);
		$pdf->RotatedText(155,112, $dest_tel,270);
		$pdf->SetFillColor(250,250,250);
        $pdf->SetXY(153, 15); 
        $pdf->Rotate(270);
		$pdf->Cell(127, 6, $dest_adr, 1, 0, 'c', true);
		$pdf->Rotate(0);
		$pdf->RotatedText(143,33, $dest_cod,270);
        $pdf->RotatedText(143,83, $dest_oras,270);
		$pdf->RotatedText(134,27, $dest_jud,270);			
		$pdf->RotatedText(127,31, $exp_name,270);
        $pdf->SetFontSize(8);
		$pdf->RotatedText(127,97, $exp_tel,270);
        $pdf->SetFont('Arial','',10);
		$pdf->SetFillColor(253,253,253);
        $pdf->SetXY(126, 15); 
        $pdf->Rotate(270);
		$pdf->Cell(99, 6, $exp_adr, 1, 0, 'c', true);
        $pdf->Rotate(0);
        $pdf->SetFont('Arial','',8);
		$pdf->RotatedText(116,31, $exp_code,270);
        $pdf->SetFont('Arial','',10);
		$pdf->RotatedText(116,60, $exp_oras,270);
		$pdf->RotatedText(116,97, $exp_jud,270);
		$pdf->RotatedText(112,45, $exp_mail,270);
		$pdf->RotatedText(73,31, $dest_name,270);
		$pdf->RotatedText(73,117, $dest_tel,270);
        $pdf->SetXY(69, 15); 
        $pdf->Rotate(270);
		$pdf->Cell(127, 6, $dest_adr, 1, 0, 'c', true);
		$pdf->Rotate(0);
		$pdf->RotatedText(60,73, "COLET",270);
		$pdf->RotatedText(54,67, $insurance,270);
		$pdf->RotatedText(54,116, $ramburs,270);
		$pdf->RotatedText(47,31, $exp_name,270);
        $pdf->SetXY(45, 15); 
        $pdf->Rotate(270);
        $pdf->SetFont('Arial','',8);
		$pdf->Cell(63, 6, $exp_adr, 1, 0, 'c', true);
        $pdf->Rotate(0);
        $pdf->SetFont('Arial','',10);
        $pdf->RotatedText(41,84, $exp_code,270);
        $pdf->RotatedText(41,113, $exp_oras,270);
        $pdf->SetFont('Arial','B',14);
        $pdf->SetXY(10,167);
        $pdf->Write(0, $warn);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(4,213);
        $pdf->Write(0, $dest_name);
        $pdf->SetXY(4,218); 
        $pdf->SetFont('Arial','',6);
		$pdf->Cell(58, 4, $dest_adr, 1, 0, 'c', true);
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(10,223);
        $pdf->Write(0, $dest_cod);
        $pdf->SetXY(37,223);
        $pdf->Write(0, $dest_oras);
        $pdf->SetXY(18,240);
        $pdf->Write(0, $dest_tel);
        $pdf->SetXY(24,252);
        $pdf->SetFont('Arial','B',13);
        $pdf->Write(0, $ramburs);
        $pdf->SetXY(69,208);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(0, $exp_name);
        $pdf->SetXY(86,212);
        $pdf->SetFont('Arial','',9);
        $pdf->Write(0, $exp_cui);
        $pdf->SetXY(70,213); 
        $pdf->SetFont('Arial','',6);
		$pdf->Cell(62, 4, $exp_adr, 1, 0, 'c', true);
        $pdf->SetXY(76,218); 
        $pdf->Write(0, $exp_code);
        $pdf->SetXY(104,218); 
        $pdf->Write(0, $exp_oras);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY(80,221); 
        $pdf->Write(0, $exp_iban);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY(83,227); 
        $pdf->Write(0, $exp_banca);
        $pdf->SetXY(93,230); 
        $pdf->Write(0, $exp_sucursala);
        $pdf->SetXY(84,233); 
        $pdf->Write(0, $dest_name);
        $pdf->SetXY(84,236); 
        $pdf->Write(0, $dest_oras);
        $pdf->SetXY(93,245);
        $pdf->SetFont('Arial','B',13);
        $pdf->Write(0, $ramburs);
        $pdf->SetXY(68,256);
        $pdf->SetFont('Arial','B',9);
        $pdf->Write(0, $sim_ramburs);

		$pdf->AddPage();
		$pdf->setSourceFile('controller/extension/shipping/form.compressed.pdf');
		$tplIdx = $pdf->importPage(2);
		$pdf->useTemplate($tplIdx,0,0);
		$pdf->RotatedText(185,279, $exp_name,180);
		$pdf->RotatedText(185,279, $exp_name,180);
		$pdf->RotatedText(185,274, $exp_cui,180);
		$pdf->SetXY(206,272); 
		$pdf->Rotate(180);
        $pdf->SetFont('Arial','',6);
		$pdf->Cell(58, 4, $exp_adr, 1, 0, 'c', true);
		$pdf->Rotate(0);
        $pdf->SetFont('Arial','B',8);
		$pdf->RotatedText(191,265, $exp_iban,180);
		$pdf->RotatedText(203,257, $exp_banca,180);
		$pdf->RotatedText(203,253, $exp_sucursala,180);
        $pdf->SetFont('Arial','',10);
		$pdf->RotatedText(187,248, $exp_oras,180);
		$pdf->RotatedText(178,244, $exp_jud,180);
		$pdf->RotatedText(189,239, $exp_tel,180);
		$pdf->RotatedText(177,235, "Contravaloare",180);
		$pdf->RotatedText(203,231, "Comanda #",180);
		$pdf->RotatedText(177,231, $comanda,180);
		$pdf->RotatedText(203,227, "Factura",180);
		$pdf->RotatedText(177,227, $serie,180);
		$pdf->RotatedText(167,227, $factura,180);

		$pdf->Output($filename, 'D'); 
	}

}
