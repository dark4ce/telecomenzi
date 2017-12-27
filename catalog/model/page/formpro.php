<?php
class ModelPageFormPro extends Model {
	public function getPageFormPro($page_form_pro_id) {
		$forms_data = array();
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "page_form_pro p LEFT JOIN " . DB_PREFIX . "page_form_pro_description pd ON (p.page_form_pro_id = pd.page_form_pro_id) LEFT JOIN " . DB_PREFIX . "page_form_pro_store p2s ON (p.page_form_pro_id = p2s.page_form_pro_id) WHERE p.page_form_pro_id = '" . (int)$page_form_pro_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.status = '1'";

		if(!$this->customer->isLogged()) {
			$sql .= " AND p.show_guest = '1'";
		}

		$row = $this->db->query($sql)->row;

		if($row) {
			// Customer Group
			$find_mygroup = false;
			if($this->customer->isLogged()) {
				// This is Customer
				$customer_group_id = $this->customer->getGroupId();
				$customer_group_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."page_form_pro_customer_group WHERE page_form_pro_id = '". (int)$row['page_form_pro_id'] ."' AND customer_group_id = '". (int)$customer_group_id ."'");

				if($customer_group_query->num_rows) {
					$find_mygroup = true;
				}
			} else{
				// This is Guest
				$find_mygroup = true;
			}

			if($find_mygroup) {
				$forms_data = $row;
			}
		}

		return $forms_data;
	}

	public function getPageFormPros() {
		$this->load->model('page/page_buildtable_pro');
		$this->model_page_page_buildtable_pro->Buildtable();
		
		$forms_data = array();
		$sql = "SELECT * FROM " . DB_PREFIX . "page_form_pro p LEFT JOIN " . DB_PREFIX . "page_form_pro_description pd ON (p.page_form_pro_id = pd.page_form_pro_id) LEFT JOIN " . DB_PREFIX . "page_form_pro_store p2s ON (p.page_form_pro_id = p2s.page_form_pro_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.status = '1'";

		if(!$this->customer->isLogged()) {
			$sql .= " AND p.show_guest = '1'";
		}

		$sql .= " ORDER BY p.sort_order, LCASE(pd.title) ASC";

		$query = $this->db->query($sql);

		foreach($query->rows as $row) {
			// Customer Group
			$find_mygroup = false;
			if($this->customer->isLogged()) {
				// This is Customer
				$customer_group_id = $this->customer->getGroupId();
				$customer_group_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."page_form_pro_customer_group WHERE page_form_pro_id = '". (int)$row['page_form_pro_id'] ."' AND customer_group_id = '". (int)$customer_group_id ."'");

				if($customer_group_query->num_rows) {
					$find_mygroup = true;
				}
			} else{
				// This is Guest
				$find_mygroup = true;
			}

			if($find_mygroup) {
				$forms_data[] = $row;
			}

		}

		return $forms_data;
	}

	public function getPageFormProOptions($page_form_pro_id) {
		$page_form_pro_option_data = array();

		$page_form_pro_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_form_pro_option pfo LEFT JOIN " . DB_PREFIX . "page_form_pro_option_description pfod ON (pfo.page_form_pro_option_id = pfod.page_form_pro_option_id) WHERE pfo.page_form_pro_id = '" . (int)$page_form_pro_id . "' AND pfod.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pfo.status ORDER BY pfo.sort_order ASC");

		foreach ($page_form_pro_option_query->rows as $page_form_pro_option) {
			
			$page_form_pro_option_value_data = array();

			$page_form_pro_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_form_pro_option_value pfov LEFT JOIN " . DB_PREFIX . "page_form_pro_option_value_description pfovd ON (pfov.page_form_pro_option_value_id = pfovd.page_form_pro_option_value_id) WHERE pfov.page_form_pro_option_id = '" . (int)$page_form_pro_option['page_form_pro_option_id'] . "' AND pfovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pfov.sort_order ASC");

			foreach ($page_form_pro_option_value_query->rows as $page_form_pro_option_value) {
				$page_form_pro_option_value_data[] = array(
					'page_form_pro_option_value_id'      => $page_form_pro_option_value['page_form_pro_option_value_id'],
					'name'                    	=> $page_form_pro_option_value['name'],
				);
			}
	
			$page_form_pro_option_data[] = array(
				'page_form_pro_option_id'    => $page_form_pro_option['page_form_pro_option_id'],
				'page_form_pro_option_value' => $page_form_pro_option_value_data,
				'field_name'             => $page_form_pro_option['field_name'],
				'field_help'             => $page_form_pro_option['field_help'],
				'type'                	 => $page_form_pro_option['type'],
				'field_value'            => $page_form_pro_option['field_value'],
				'field_placeholder'      => $page_form_pro_option['field_placeholder'],
				'field_error'      		 => $page_form_pro_option['field_error'],
				'required'             	 => $page_form_pro_option['required']
			);
		}

		return $page_form_pro_option_data;
	}

	public function getPageFormProOptionsCountry($page_form_pro_id) {
		$query = $this->db->query("SELECT count(*) as total_country_exists FROM " . DB_PREFIX . "page_form_pro_option pfo WHERE pfo.page_form_pro_id = '" . (int)$page_form_pro_id . "' AND pfo.type = 'country'");

		return $query->row['total_country_exists'];
	}

	public function getPageRequestEmailByPageFormProID($email, $page_form_pro_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "page_request_pro_option` WHERE LOWER(`value`) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND `page_form_pro_id` = '" . (int)$page_form_pro_id . "' AND (`type` = 'email' OR `type` = 'email_exists')");

		return $query->row;
	}

	public function getAllPageFormsByProduct($product_id) {
		$forms_data = array();
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "page_form_pro p LEFT JOIN " . DB_PREFIX . "page_form_pro_description pd ON (p.page_form_pro_id = pd.page_form_pro_id) LEFT JOIN " . DB_PREFIX . "page_form_pro_store p2s ON (p.page_form_pro_id = p2s.page_form_pro_id) LEFT JOIN " . DB_PREFIX . "page_form_pro_product p2p ON (p.page_form_pro_id = p2p.page_form_pro_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.status = '1' AND ( p2p.product_id = '" . (int)$product_id . "' OR product_id = 'all') ";

		if(!$this->customer->isLogged()) {
			$sql .= " AND p.show_guest = '1'";
		}

		$query = $this->db->query($sql);

		foreach($query->rows as $row) {
			// Customer Group
			$find_mygroup = false;
			if($this->customer->isLogged()) {
				// This is Customer
				$customer_group_id = $this->customer->getGroupId();
				$customer_group_query = $this->db->query("SELECT * FROM ". DB_PREFIX ."page_form_pro_customer_group WHERE page_form_pro_id = '". (int)$row['page_form_pro_id'] ."' AND customer_group_id = '". (int)$customer_group_id ."'");

				if($customer_group_query->num_rows) {
					$find_mygroup = true;
				}
			} else{
				// This is Guest
				$find_mygroup = true;
			}

			if($find_mygroup) {
				$forms_data[] = $row;
			}

		}

		return $forms_data;
	}
}