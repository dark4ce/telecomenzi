<?php
class ModelExtensionShippingPosta extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/posta');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('posta_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
		if (!$this->config->get('posta_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
	
		if ($status) {
			$quote_data = array();
			$total = $this->cart->getTotal();
			$weight = $this->cart->getWeight();
			$cost = $this->config->get('posta_cost') + $this->config->get('posta_valoare')*0.011 + $total*0.011 + $this->config->get('posta_kg')*ceil($weight);

      		$quote_data['posta'] = array(
        		'code'         => 'posta.posta',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => $cost,
        		'tax_class_id' => $this->config->get('posta_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('posta_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
      		);

      		$method_data = array(
        		'code'       => 'posta',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
			'sort_order' => $this->config->get('posta_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
	}
}
?>