<?php
set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new \Exception($errstr, $errno);
});
class ControllerExtensionModulefgo extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/fgo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->validateConnectionData($this->request->post)) {
						
			$this->model_setting_setting->editSetting('fgo', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
		else{
			$this->error['warning'] = $this->language->get('error_dataValidationSave');
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_url'] = $this->language->get('entry_url');
		$data['entry_pass'] = $this->language->get('entry_pass');
		$data['entry_id'] = $this->language->get('entry_id');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/fgo', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/fgo', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['fgo_status'])) {
			$data['fgo_status'] = $this->request->post['fgo_status'];
		} else {
			$data['fgo_status'] = $this->config->get('fgo_status');
		}
		
		if (isset($this->request->post['fgo_url'])) {
			$data['fgo_url'] = $this->request->post['fgo_url'];
		} else {
			$data['fgo_url'] = $this->config->get('fgo_url');
		}
		
		if (isset($this->request->post['fgo_pass'])) {
			$data['fgo_pass'] = $this->request->post['fgo_pass'];
		} else {
			$data['fgo_pass'] = $this->config->get('fgo_pass');
		}
		
		if (isset($this->request->post['fgo_id'])) {
			$data['fgo_id'] = $this->request->post['fgo_id'];
		} else {
			$data['fgo_id'] = $this->config->get('fgo_id');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/fgo', $data));
	}

	public function generateInvoice() {
		
		$this->load->language('extension/module/fgo');
		
		$connectionData = $this->getConnectionData();
		
		if (!$this->validateConnectionData($connectionData)) {
			echo '{"error":"' . $this->language->get('error_dataValidation') . '"}';
			exit;
		}

		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);
		$order_products = $this->model_sale_order->getOrderProducts($order_id);
		$totals = $this->model_sale_order->getOrderTotals($order_id);

		foreach ($totals as $total) {
			if ($total['code'] == 'shipping') {
				$order_products[] = array(
					'model' => 'Transport',
					'price' => $total['value'],
					'quantity' => 1,
					'tax' => 19
				);
			}
		}
		
		$this->load->model('extension/module/fgo');
		
		$response = array();$result = null;
		
		try {
			
			$invoiceData = $this->model_extension_module_fgo->convertOrderToInvoice($order_info, $order_products);
			
			$result = $this->model_extension_module_fgo->generateInvoice($connectionData, $invoiceData);
			
			
		}
		catch (Exception $e) {
			$result['Success'] = false;
			$result['Message'] = $this->language->get('error_server_network');
		}
		
		if(!empty($result['Success'])) {
			$response['invoice_no'] = $result['Factura']['Serie'] . ' ' . $result['Factura']['Numar'];
			$response['invoice_url'] = $result['Factura']['Link'];
		}
		else{
			$response['error'] = $result['Message'];
		}
		
		echo json_encode($response);
		exit;
	}

	protected function getConnectionData() {
		
		$this->load->model('setting/setting');
		
		$connectionData = $this->model_setting_setting->getSetting('fgo');
		
		return $connectionData;
		
	}
	
	protected function validateConnectionData($connectionData) {

		if (!$connectionData['fgo_status']) {
			return false;
		}
		
		if (empty($connectionData['fgo_url']) ) {//|| filter_var($connectionData['fgo_url'], FILTER_VALIDATE_URL)
			return false;
		}
		
		if (empty($connectionData['fgo_pass']) || strlen($connectionData['fgo_pass'])<=30 || strlen($connectionData['fgo_pass'])>=34) {
			return false;
		}
		
		if (!$connectionData['fgo_id']) {
			return false;
		}
		$cif = $connectionData['fgo_id'];
		if (!is_numeric($cif)) return false;
		if ( strlen($cif)>10 ) return false;
		
		$control_digit=substr($cif, -1);
		$cif=substr($cif, 0, -1);
		while (strlen($cif)!=9){
			$cif='0'.$cif;
		}
		$sum=$cif[0] * 7 + $cif[1] * 5 + $cif[2] * 3 + $cif[3] * 2 + $cif[4] * 1 + $cif[5] * 7 + $cif[6] * 5 + $cif[7] * 3 + $cif[8] * 2;
		$sum=$sum*10;
		$rest=fmod($sum, 11);
		if ( $rest==10 ) $rest=0;
		
		if ($rest==$control_digit) return true;
		else return false;

		return true;		
		
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/fgo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}