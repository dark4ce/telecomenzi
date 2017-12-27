<?php
class ModelPagePageFormPro extends Model {
	public function addPageFormPro($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "page_form_pro` SET show_guest = '" . (int)$data['show_guest'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', customer_email_status = '" . (int)$data['customer_email_status'] . "', admin_email_status = '" . (int)$data['admin_email_status'] . "', top = '" . (isset($data['top']) ? (int)$data['top'] : '') . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : '') . "', captcha = '" . (int)$data['captcha'] . "', css = '" . $this->db->escape($data['css']) . "', producttype = '" . $this->db->escape($data['producttype']) . "'");

		$page_form_pro_id = $this->db->getLastId();

		foreach ($data['page_form_pro_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_description SET page_form_pro_id = '" . (int)$page_form_pro_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', bottom_description = '" . $this->db->escape($value['bottom_description']) . "', pbutton_title = '" . $this->db->escape($value['pbutton_title']) . "', customer_subject = '" . $this->db->escape($value['customer_subject']) . "', customer_message = '" . $this->db->escape($value['customer_message']) . "', admin_subject = '" . $this->db->escape($value['admin_subject']) . "', admin_message = '" . $this->db->escape($value['admin_message']) . "', success_title = '" . $this->db->escape($value['success_title']) . "', success_description = '" . $this->db->escape($value['success_description']) . "', fieldset_title = '" . $this->db->escape($value['fieldset_title']) . "', submit_button = '" . $this->db->escape($value['submit_button']) . "'");
		}

		if (isset($data['page_form_pro_store'])) {
			foreach ($data['page_form_pro_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_store SET page_form_pro_id = '" . (int)$page_form_pro_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if ($data['producttype'] == 'choose') {
			if (isset($data['page_form_pro_product'])) {
				foreach ($data['page_form_pro_product'] as $product_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_product SET page_form_pro_id = '" . (int)$page_form_pro_id . "', product_id = '" . (int)$product_id . "'");
				}
			}
		} else if ($data['producttype'] == 'all') {
			$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_product SET page_form_pro_id = '" . (int)$page_form_pro_id . "', product_id = '" . $this->db->escape($data['producttype']) . "'");
		}

		if (isset($data['page_form_pro_customer_group'])) {
			foreach ($data['page_form_pro_customer_group'] as $customer_group_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_customer_group SET page_form_pro_id = '" . (int)$page_form_pro_id . "', customer_group_id = '" . (int)$customer_group_id . "'");
			}
		}

		if (isset($data['page_form_pro_field'])) {
			foreach ($data['page_form_pro_field'] as $page_form_pro_field) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option SET page_form_pro_id = '" . (int)$page_form_pro_id . "', required = '" . (int)$page_form_pro_field['required'] . "', status = '" . (int)$page_form_pro_field['status'] . "', type = '" . $this->db->escape($page_form_pro_field['type']) . "', sort_order = '" . $this->db->escape($page_form_pro_field['sort_order']) . "'");

				$page_form_pro_option_id = $this->db->getLastId();

				if(isset($page_form_pro_field['description'])) {
					foreach ($page_form_pro_field['description'] as $language_id => $page_form_pro_option_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option_description SET page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "', page_form_pro_id = '" . (int)$page_form_pro_id . "', language_id = '" . (int)$language_id . "', field_name = '" . $this->db->escape($page_form_pro_option_description['field_name']) . "', field_help = '" . $this->db->escape($page_form_pro_option_description['field_help']) . "', field_error = '" . $this->db->escape($page_form_pro_option_description['field_error']) . "', field_placeholder = '" . $this->db->escape($page_form_pro_option_description['field_placeholder']) . "'");
					}
				}

				if (isset($page_form_pro_field['option_value'])) {
					if ($page_form_pro_field['type'] == 'select' || $page_form_pro_field['type'] == 'radio' || $page_form_pro_field['type'] == 'checkbox') {
						foreach ($page_form_pro_field['option_value'] as $page_form_pro_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option_value SET page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "', page_form_pro_id = '" . (int)$page_form_pro_id . "', sort_order = '" . (int)$page_form_pro_option_value['sort_order'] . "'");

							$page_form_pro_option_value_id = $this->db->getLastId();

							if(isset($page_form_pro_option_value['page_form_pro_option_value_description'])) {

								foreach ($page_form_pro_option_value['page_form_pro_option_value_description'] as $language_id => $page_form_pro_option_value_description) {
									$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option_value_description SET page_form_pro_option_value_id = '" . (int)$page_form_pro_option_value_id . "', page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "', page_form_pro_id = '" . (int)$page_form_pro_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($page_form_pro_option_value_description['name']) . "'");
								}
							}
						}
					}
				}
			}
		}
		
		$page_form_pro_id = $this->db->getLastId();

		return $page_form_pro_id;
	}

	public function editPageFormPro($page_form_pro_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "page_form_pro` SET show_guest = '" . (int)$data['show_guest'] . "', status = '" . $this->db->escape($data['status']) . "', sort_order = '" . (int)$data['sort_order'] . "', customer_email_status = '" . (int)$data['customer_email_status'] . "', admin_email_status = '" . (int)$data['admin_email_status'] . "', top = '" . (isset($data['top']) ? (int)$data['top'] : '') . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : '') . "', captcha = '" . (int)$data['captcha'] . "', css = '" . $this->db->escape($data['css']) . "', producttype = '" . $this->db->escape($data['producttype']) . "' WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "page_form_pro_description WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		foreach ($data['page_form_pro_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_description SET page_form_pro_id = '" . (int)$page_form_pro_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', bottom_description = '" . $this->db->escape($value['bottom_description']) . "', pbutton_title = '" . $this->db->escape($value['pbutton_title']) . "', customer_subject = '" . $this->db->escape($value['customer_subject']) . "', customer_message = '" . $this->db->escape($value['customer_message']) . "', admin_subject = '" . $this->db->escape($value['admin_subject']) . "', admin_message = '" . $this->db->escape($value['admin_message']) . "', success_title = '" . $this->db->escape($value['success_title']) . "', success_description = '" . $this->db->escape($value['success_description']) . "', fieldset_title = '" . $this->db->escape($value['fieldset_title']) . "', submit_button = '" . $this->db->escape($value['submit_button']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "page_form_pro_store WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		if (isset($data['page_form_pro_store'])) {
			foreach ($data['page_form_pro_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_store SET page_form_pro_id = '" . (int)$page_form_pro_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "page_form_pro_product WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		if ($data['producttype'] == 'choose') {
			if (isset($data['page_form_pro_product'])) {
				foreach ($data['page_form_pro_product'] as $product_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_product SET page_form_pro_id = '" . (int)$page_form_pro_id . "', product_id = '" . (int)$product_id . "'");
				}
			}
		} else if ($data['producttype'] == 'all') {
			$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_product SET page_form_pro_id = '" . (int)$page_form_pro_id . "', product_id = '" . $this->db->escape($data['producttype']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "page_form_pro_customer_group WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		if (isset($data['page_form_pro_customer_group'])) {
			foreach ($data['page_form_pro_customer_group'] as $customer_group_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_customer_group SET page_form_pro_id = '" . (int)$page_form_pro_id . "', customer_group_id = '" . (int)$customer_group_id . "'");
			}
		}


		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option_description` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option_value` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option_value_description` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		if (isset($data['page_form_pro_field'])) {
			foreach ($data['page_form_pro_field'] as $page_form_pro_field) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option SET page_form_pro_option_id = '". (int)$page_form_pro_field['page_form_pro_option_id'] ."', page_form_pro_id = '" . (int)$page_form_pro_id . "', required = '" . (int)$page_form_pro_field['required'] . "', status = '" . (int)$page_form_pro_field['status'] . "', type = '" . $this->db->escape($page_form_pro_field['type']) . "', sort_order = '" . $this->db->escape($page_form_pro_field['sort_order']) . "'");

				$page_form_pro_option_id = $this->db->getLastId();

				if(isset($page_form_pro_field['description'])) {
					foreach ($page_form_pro_field['description'] as $language_id => $page_form_pro_option_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option_description SET page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "', page_form_pro_id = '" . (int)$page_form_pro_id . "', language_id = '" . (int)$language_id . "', field_name = '" . $this->db->escape($page_form_pro_option_description['field_name']) . "', field_help = '" . $this->db->escape($page_form_pro_option_description['field_help']) . "', field_error = '" . $this->db->escape($page_form_pro_option_description['field_error']) . "', field_placeholder = '" . $this->db->escape($page_form_pro_option_description['field_placeholder']) . "'");
					}
				}

				if (isset($page_form_pro_field['option_value'])) {
					if ($page_form_pro_field['type'] == 'select' || $page_form_pro_field['type'] == 'radio' || $page_form_pro_field['type'] == 'checkbox') {
						foreach ($page_form_pro_field['option_value'] as $page_form_pro_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option_value SET page_form_pro_option_value_id = '". (int)$page_form_pro_option_value['page_form_pro_option_value_id'] ."', page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "', page_form_pro_id = '" . (int)$page_form_pro_id . "', sort_order = '" . (int)$page_form_pro_option_value['sort_order'] . "'");

							$page_form_pro_option_value_id = $this->db->getLastId();

							if(isset($page_form_pro_option_value['page_form_pro_option_value_description'])) {

								foreach ($page_form_pro_option_value['page_form_pro_option_value_description'] as $language_id => $page_form_pro_option_value_description) {
									$this->db->query("INSERT INTO " . DB_PREFIX . "page_form_pro_option_value_description SET page_form_pro_option_value_id = '" . (int)$page_form_pro_option_value_id . "', page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "', page_form_pro_id = '" . (int)$page_form_pro_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($page_form_pro_option_value_description['name']) . "'");
								}
							}
						}
					}
				}
			}
		}
	}

	public function deletePageFormPro($page_form_pro_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_customer_group` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_description` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option_description` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option_value` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_option_value_description` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_store` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_form_pro_product` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");
	}

	public function getPageFormPro($page_form_pro_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "page_form_pro` o WHERE o.page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		return $query->row;
	}

	public function getPageFormPros($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "page_form_pro` p LEFT JOIN " . DB_PREFIX . "page_form_pro_description pd ON (p.page_form_pro_id = pd.page_form_pro_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_title'])) {
			$sql .= " AND pd.title LIKE '%" . $this->db->escape($data['filter_title']) . "%'";
		}

		$sort_data = array(
			'pd.title',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.title";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getPageFormProDescriptions($page_form_pro_id) {
		$page_form_pro_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_form_pro_description WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		foreach ($query->rows as $result) {
			$page_form_pro_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'bottom_description'      => $result['bottom_description'],
				'pbutton_title'      => $result['pbutton_title'],
				'admin_subject'     	=> $result['admin_subject'],
				'admin_message'     	=> $result['admin_message'],
				'customer_subject'    	=> $result['customer_subject'],
				'customer_message'     	=> $result['customer_message'],
				'success_title'     	=> $result['success_title'],
				'success_description' 	=> $result['success_description'],
				'fieldset_title' 	=> $result['fieldset_title'],
				'submit_button' 	=> $result['submit_button'],
			);
		}

		return $page_form_pro_description_data;
	}

	public function getTotalPageFormPros() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "page_form_pro`");

		return $query->row['total'];
	}

	public function getPageFormProStores($page_form_pro_id) {
		$page_form_pro_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_form_pro_store WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		foreach ($query->rows as $result) {
			$page_form_pro_store_data[] = $result['store_id'];
		}

		return $page_form_pro_store_data;
	}

	public function getPageFormProProducts($page_form_pro_id) {
		$page_form_pro_product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_form_pro_product WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		foreach ($query->rows as $result) {
			$page_form_pro_product_data[] = $result['product_id'];
		}

		return $page_form_pro_product_data;
	}

	public function getPageFormProCustomerGroups($page_form_pro_id) {
		$page_form_pro_customer_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_form_pro_customer_group WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "'");

		foreach ($query->rows as $result) {
			$page_form_pro_customer_group_data[] = $result['customer_group_id'];
		}

		return $page_form_pro_customer_group_data;
	}

	public function getPageFormProOptions($page_form_pro_id) {
		$page_form_pro_option_data = array();

		$page_form_pro_option_query = $this->db->query("SELECT *, pfo.sort_order as sort_order FROM `" . DB_PREFIX . "page_form_pro_option` pfo LEFT JOIN `" . DB_PREFIX . "page_form_pro_option_description` pfod ON (pfo.page_form_pro_option_id = pfod.page_form_pro_option_id) WHERE pfo.page_form_pro_id = '" . (int)$page_form_pro_id . "' AND pfod.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pfo.sort_order ASC");

		foreach ($page_form_pro_option_query->rows as $page_form_pro_option) {
			$page_form_pro_description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "page_form_pro_option_description` WHERE page_form_pro_id = '" . (int)$page_form_pro_option['page_form_pro_id'] . "' AND  page_form_pro_option_id = '". (int)$page_form_pro_option['page_form_pro_option_id']  ."'");

			$page_form_pro_description_data = array();
			foreach ($page_form_pro_description_query->rows as $page_form_pro_description_value) {
				$page_form_pro_description_data[$page_form_pro_description_value['language_id']] = array(
					'field_name' 	 	=> $page_form_pro_description_value['field_name'],
					'field_help' 	 	=> $page_form_pro_description_value['field_help'],
					'field_placeholder' => $page_form_pro_description_value['field_placeholder'],
					'field_error'    	=> $page_form_pro_description_value['field_error'],
				);
			}

			$page_form_pro_option_value_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "page_form_pro_option_value` pfov WHERE pfov.page_form_pro_id = '" . (int)$page_form_pro_id . "' AND pfov.page_form_pro_option_id = '". (int)$page_form_pro_option['page_form_pro_option_id'] ."' ORDER BY pfov.sort_order ASC");

			$page_form_pro_option_values = array();
			$page_form_pro_option_values = array();
			foreach ($page_form_pro_option_value_query->rows as $page_form_pro_option_value) {
				$page_form_pro_option_value_description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "page_form_pro_option_value_description` WHERE page_form_pro_id = '" . (int)$page_form_pro_id . "' AND page_form_pro_option_id = '". (int)$page_form_pro_option_value['page_form_pro_option_id'] ."' AND page_form_pro_option_value_id = '". (int)$page_form_pro_option_value['page_form_pro_option_value_id'] ."'");

				$page_form_pro_option_value_description_data = array();
				foreach ($page_form_pro_option_value_description_query->rows as $page_form_pro_option_value_description_value) {
					$page_form_pro_option_value_description_data[$page_form_pro_option_value_description_value['language_id']] = array(
						'name'    			 => $page_form_pro_option_value_description_value['name'],
					);

				}

				$page_form_pro_option_values[] = array(
					'page_form_pro_option_value_id'  => $page_form_pro_option_value['page_form_pro_option_value_id'],
					'page_form_pro_option_id'  		 => $page_form_pro_option_value['page_form_pro_option_id'],
					'sort_order'    			 => $page_form_pro_option_value['sort_order'],
					'page_form_pro_option_value_description'		 		 => $page_form_pro_option_value_description_data,
				);
			}

			$page_form_pro_option_data[] = array(
				'page_form_pro_option_id'  => $page_form_pro_option['page_form_pro_option_id'],
				'type'                 => $page_form_pro_option['type'],				
				'required'             => $page_form_pro_option['required'],
				'status'               => $page_form_pro_option['status'],
				'sort_order'           => $page_form_pro_option['sort_order'],
				'field_name'           => $page_form_pro_option['field_name'],
				'field_help'           => $page_form_pro_option['field_help'],
				'description'		   => $page_form_pro_description_data,
				'option_value'	=> $page_form_pro_option_values,
			);
		}

		return $page_form_pro_option_data;
	}
}