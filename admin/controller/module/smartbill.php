<?php

class ControllerModuleSmartbill extends Controller {
	// private $vqmodPath = '/../../../vqmod/xml/';

	public function index() {
		$this->language->load('module/smartbill'); // Loading the language file of smartbill 

	    $data['heading_title'] 	= $this->language->get('heading_title');
		$data['button_cancel'] 	= $this->language->get('button_back');
		$data['status'] 		= file_exists($this->vqmodPath . 'smartbill.xml') ? 1 : 0;
		$data['action'] 		= $this->url->link('module/smartbill', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] 		= $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
	
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('smartbill/module.tpl', $data));
	}

	/*public function uninstall() {
	 	$this->vqmodPath = dirname(__FILE__) . $this->vqmodPath;

        if (file_exists($this->vqmodPath . 'smartbill.xml')) {
            rename($this->vqmodPath . 'smartbill.xml', $this->vqmodPath . 'smartbill.xml.bak');
        }
	}*/

	public function install() {
	 	// $this->vqmodPath = dirname(__FILE__) . $this->vqmodPath;

        $schema = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order`");
        if ( !empty($schema->rows) ) {
          	if ( !$this->inFields('smartbill_document_url', $schema->rows) ) {
          		$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `smartbill_document_url` VARCHAR( 255 ) NULL ");
          	}
          	if ( !$this->inFields('smartbill_document_series', $schema->rows) ) {
          		$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `smartbill_document_series` VARCHAR( 15 ) NULL ");
          	}
          	if ( !$this->inFields('smartbill_document_number', $schema->rows) ) {
          		$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `smartbill_document_number` VARCHAR( 25 ) NULL ");
          	}
          	if ( !$this->inFields('smartbill_document_json', $schema->rows) ) {
          		$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `smartbill_document_json` TEXT NULL ");
          	}
          	if ( !$this->inFields('smartbill_order_items_prices', $schema->rows) ) {
          		$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `smartbill_order_items_prices` TEXT NULL ");
          	}
          	if ( !$this->inFields('smartbill_tax_settings', $schema->rows) ) {
          		$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `smartbill_tax_settings` TEXT NULL ");
          	}
        }

        // if (file_exists($this->vqmodPath . 'smartbill.xml.bak')) {
        //     rename($this->vqmodPath . 'smartbill.xml.bak', $this->vqmodPath . 'smartbill.xml');
        // }
	}

	private function inFields($field, $fields) {
		if ( is_array($fields) ) {
			foreach ($fields as $item) {
				if ( $field == $item['Field'] ) {
					return true;
				}
			}
		}

		return false;
	}

}