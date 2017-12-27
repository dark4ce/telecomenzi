<?php
class ControllerAccountOrder extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/order');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/order', $url, true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['orders'] = array();

		$this->load->model('account/order');

		$order_total = $this->model_account_order->getTotalOrders();

		$results = $this->model_account_order->getOrders(($page - 1) * 10, 10);

		foreach ($results as $result) {
			$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
			$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);

			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['firstname'] . ' ' . $result['lastname'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'products'   => ($product_total + $voucher_total),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'view'       => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], true),
			);
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/order', 'page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($order_total - 10)) ? $order_total : ((($page - 1) * 10) + 10), $order_total, ceil($order_total / 10));

		$data['continue'] = $this->url->link('account/account', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/order_list', $data));
	}

	public function info() {
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);


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
            
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/account', '', true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/order', $url, true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_order'),
				'href' => $this->url->link('account/order/info', 'order_id=' . $this->request->get['order_id'] . $url, true)
			);

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_no_results'] = $this->language->get('text_no_results');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reorder'] = $this->language->get('button_reorder');
			$data['button_return'] = $this->language->get('button_return');
			$data['button_continue'] = $this->language->get('button_continue');

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

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

			$data['payment_method'] = $order_info['payment_method'];

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

			$data['shipping_method'] = $order_info['shipping_method'];

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

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
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], true);
				} else {
					$reorder = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'reorder'  => $reorder,
					'return'   => $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], true)
				);
			}

			// Voucher
			$data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();

			$totals = $this->model_account_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}

			$data['comment'] = nl2br($order_info['comment']);

			// History
			$data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}

			$data['continue'] = $this->url->link('account/order', '', true);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('account/order_info', $data));
		} else {
			$this->document->setTitle($this->language->get('text_order'));

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/account', '', true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/order', '', true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_order'),
				'href' => $this->url->link('account/order/info', 'order_id=' . $order_id, true)
			);

			$data['continue'] = $this->url->link('account/order', '', true);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function reorder() {
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);


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
            
		if ($order_info) {
			if (isset($this->request->get['order_product_id'])) {
				$order_product_id = $this->request->get['order_product_id'];
			} else {
				$order_product_id = 0;
			}

			$order_product_info = $this->model_account_order->getOrderProduct($order_id, $order_product_id);

			if ($order_product_info) {
				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($order_product_info['product_id']);

				if ($product_info) {
					$option_data = array();

					$order_options = $this->model_account_order->getOrderOptions($order_product_info['order_id'], $order_product_id);

					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio' || $order_option['type'] == 'image') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}

					$this->cart->add($order_product_info['product_id'], $order_product_info['quantity'], $option_data);

					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_info['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				} else {
					$this->session->data['error'] = sprintf($this->language->get('error_reorder'), $order_product_info['name']);
				}
			}
		}

		$this->response->redirect($this->url->link('account/order/info', 'order_id=' . $order_id));
	}
}