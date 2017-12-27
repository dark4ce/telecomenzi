<?php
class ControllerPageFormPro extends Controller {
	public function index() {
		$json = array();

		$this->load->language('page/formpro');

		$this->load->model('page/formpro');

		if (isset($this->request->post['form_id'])) {
			$page_form_pro_id = (int)$this->request->post['form_id'];
		} else {
			$page_form_pro_id = 0;
		}

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $product_id = (int)$this->request->post['product_id'];
		} else {
			$data['product_id'] = $product_id = '';
		}

		$page_form_pro_info = $this->model_page_formpro->getPageFormPro($page_form_pro_id);

		if ($page_form_pro_info) {
			$data['page_form_pro_id'] = $page_form_pro_info['page_form_pro_id'];
			$data['css'] = $page_form_pro_info['css'];
			
			$data['text_processing'] = $this->language->get('text_processing');
			$data['text_select'] = $this->language->get('text_select');
			$data['button_upload'] = $this->language->get('button_upload');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_none'] = $this->language->get('text_none');			

			$data['heading_title'] = $page_form_pro_info['title'];

			$data['description'] = html_entity_decode($page_form_pro_info['description'], ENT_QUOTES, 'UTF-8');
			$data['bottom_description'] = html_entity_decode($page_form_pro_info['bottom_description'], ENT_QUOTES, 'UTF-8');

			$data['fieldset_title'] = $page_form_pro_info['fieldset_title'];
			$data['button_continue'] = ($page_form_pro_info['submit_button']) ? $page_form_pro_info['submit_button'] :  $this->language->get('button_continue');


			// Page Form Options
			$data['page_form_pro_options'] = $this->model_page_formpro->getPageFormProOptions($page_form_pro_id);
			$data['country_exists'] = $this->model_page_formpro->getPageFormProOptionsCountry($page_form_pro_id);

			$this->load->model('localisation/country');
			$data['countries'] = $this->model_localisation_country->getCountries();


			$this->load->model('localisation/zone');
			$data['zones'] = $this->model_localisation_zone->getZonesByCountryId($this->config->get('config_country_id'));

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && $page_form_pro_info['captcha']) {
				if (VERSION <= '2.2.0.0') {
					$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
				} else {
					$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
				}
			} else {
				$data['captcha'] = '';
			}

			if(VERSION < '2.2.0.0') {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/page/formpro.tpl')) {
					$json['html'] = $this->load->view($this->config->get('config_template') . '/template/page/formpro.tpl', $data);
				} else {
					$json['html'] = $this->load->view('default/template/page/formpro.tpl', $data);
				}
			} else{
				$json['html'] = $this->load->view('page/formpro', $data);
			}
		} else{
			$json['redirect'] = $this->url->link('error/not_found');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function add() {
		if(VERSION < '2.2.0.0') {
			require_once(DIR_SYSTEM.'library/pageformpro.php');
			global $registry;

			$this->pageformpro = new pageformpro($registry); 
		} else{
			$this->load->library('pageformpro');
		}

		$this->load->language('page/formpro');

		$this->load->model('page/formpro');
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');

		$json = array();

		if (isset($this->request->post['form_id'])) {
			$page_form_pro_id = (int)$this->request->post['form_id'];
		} else {
			$page_form_pro_id = 0;
		}

		$page_form_pro_info = $this->model_page_formpro->getPageFormPro($page_form_pro_id);

		if($page_form_pro_info) {
			if (isset($this->request->post['field'])) {
				$field = $this->request->post['field'];
			} else {
				$field = array();
			}


			// Page Form Options
			$page_form_pro_options = $this->model_page_formpro->getPageFormProOptions($page_form_pro_id);

			$password = '';
			foreach ($page_form_pro_options as $page_form_pro_option) {
				// Text
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'text' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateText($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Textarea
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'textarea' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateTextarea($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Number
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'number' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateNumber($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}


				// Telephone
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'telephone' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateTelephone($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Email
				if ($page_form_pro_option['required'] && ($page_form_pro_option['type'] == 'email' || $page_form_pro_option['type'] == 'email_exists') && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateEmail($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : $this->language->get('error_email');
				}

				// Email Exists
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'email_exists' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->model_page_formpro->getPageRequestEmailByPageFormProID($field[$page_form_pro_option['page_form_pro_option_id']], $page_form_pro_id)) {
						
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : $this->language->get('error_exists');
						
						$json['error']['warning'] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : $this->language->get('error_exists');
				}

				// Password
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'password' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validatePassword($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : $this->language->get('error_password');
				}

				// Get First Passowrd
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'password' && isset($field[$page_form_pro_option['page_form_pro_option_id']])) {
					$password = $field[$page_form_pro_option['page_form_pro_option_id']];
				}
				
				// Confirm Passowrd
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'confirm_password' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateConfirmPassword($field[$page_form_pro_option['page_form_pro_option_id']], $password)) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : $this->language->get('error_confirm');
				}

				// File
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'file' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateFile($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Date
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'date' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateDate($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Time
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'time' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateTime($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// DateTime
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'datetime' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateDateTime($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Country
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'country' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateCountry($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Zone
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'zone' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateZone($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Postcode
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'postcode' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validatePostcode($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Address
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'address' && isset($field[$page_form_pro_option['page_form_pro_option_id']]) && $this->pageformpro->validateAddress($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Select
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'select' && empty($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// Radio
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'radio' && empty($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}

				// checkbox
				if ($page_form_pro_option['required'] && $page_form_pro_option['type'] == 'checkbox' && empty($field[$page_form_pro_option['page_form_pro_option_id']])) {
						$json['error']['field'][$page_form_pro_option['page_form_pro_option_id']] = ($page_form_pro_option['field_error']) ? $page_form_pro_option['field_error'] : sprintf($this->language->get('error_required'), $page_form_pro_option['field_name']);
				}
			}
 
			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && $page_form_pro_info['captcha']) {
				if (VERSION <= '2.2.0.0') {
					$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');
				} else {
					$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');
				}

				if ($captcha) {
					$json['error']['captcha'] = $captcha;
					
					if (VERSION <= '2.2.0.0') {
						$json['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'), $json['error']);
					} else {
						$json['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $json['error']);
					}

					$json['error']['warning'] = $captcha;
				}
			}
		} else {
			$json['error']['warning'] = $this->language->get('error_not_found');
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if(!$json) {
			$form_data = array();
			$form_data['page_form_pro_id'] = $page_form_pro_id;
			$form_data['customer_id'] = $this->customer->getId();
			$form_data['customer_group_id'] = $this->customer->getGroupId();			
			$form_data['firstname'] = ($this->customer->getId()) ? $this->customer->getFirstName() .' '. $this->customer->getLastName() : 'Guest';
			$form_data['lastname'] = ($this->customer->getId()) ? $this->customer->getLastName() : '';
			$form_data['store_id'] = $this->config->get('config_store_id');
			$form_data['language_id'] = $this->config->get('config_language_id');
			$form_data['ip'] = $this->request->server['REMOTE_ADDR'];
			$form_data['page_form_pro_title'] = isset($page_form_pro_info['title']) ? $page_form_pro_info['title'] : '';
			
			// Fields
			$field_data = array();
			if(isset($field)) {
				foreach ($field as $page_form_pro_option_id => $value) {
					$page_form_pro_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "page_form_pro_option pfo LEFT JOIN " . DB_PREFIX . "page_form_pro_option_description pfod ON (pfo.page_form_pro_option_id = pfod.page_form_pro_option_id) WHERE pfo.page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "' AND pfo.page_form_pro_id = '" . (int)$page_form_pro_id . "' AND pfod.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					if ($page_form_pro_option_query->num_rows) {
						if ($page_form_pro_option_query->row['type'] == 'select' || $page_form_pro_option_query->row['type'] == 'radio') {
							$page_form_pro_option_value_query = $this->db->query("SELECT pfovd.name FROM " . DB_PREFIX . "page_form_pro_option_value pfov LEFT JOIN " . DB_PREFIX . "page_form_pro_option_value_description pfovd ON (pfov.page_form_pro_option_value_id = pfovd.page_form_pro_option_value_id) WHERE pfov.page_form_pro_option_value_id = '" . (int)$value . "' AND pfov.page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "' AND pfovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

							if ($page_form_pro_option_value_query->num_rows) {
								$field_data[] = array(
									'name'                    => $page_form_pro_option_query->row['field_name'],
									'value'                   => $page_form_pro_option_value_query->row['name'],
									'type'                    => $page_form_pro_option_query->row['type'],
								);
							}
						} elseif ($page_form_pro_option_query->row['type'] == 'checkbox' && is_array($value)) {
							$checkbox_value = array();
							foreach ($value as $page_form_pro_option_value_id) {
								$page_form_pro_option_value_query = $this->db->query("SELECT pfovd.name FROM " . DB_PREFIX . "page_form_pro_option_value pfov LEFT JOIN " . DB_PREFIX . "page_form_pro_option_value_description pfovd ON (pfov.page_form_pro_option_value_id = pfovd.page_form_pro_option_value_id) WHERE pfov.page_form_pro_option_value_id = '" . (int)$page_form_pro_option_value_id . "' AND pfov.page_form_pro_option_id = '" . (int)$page_form_pro_option_id . "' AND pfovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

								if ($page_form_pro_option_value_query->num_rows) {
									$checkbox_value[] = $page_form_pro_option_value_query->row['name'];
								}
							}

							if((array)$checkbox_value) {
								$field_data[] = array(
									'name'                    => $page_form_pro_option_query->row['field_name'],
									'value'                   => implode(', ', $checkbox_value),
									'type'                    => $page_form_pro_option_query->row['type'],
								);
							}

						} else if ($page_form_pro_option_query->row['type'] == 'country') {
							$country_info = $this->model_localisation_country->getCountry($value);
							if($country_info) {
								$field_data[] = array(
									'name'                    => $page_form_pro_option_query->row['field_name'],
									'value'                   => $country_info['name'],
									'type'                    => $page_form_pro_option_query->row['type'],
								);
							}

						} else if ($page_form_pro_option_query->row['type'] == 'zone') {
							$zone_info = $this->model_localisation_zone->getZone($value);
							if($zone_info) {
								$field_data[] = array(
									'name'                    => $page_form_pro_option_query->row['field_name'],
									'value'                   => $zone_info['name'],
									'type'                    => $page_form_pro_option_query->row['type'],
								);
							}
						} else if ($page_form_pro_option_query->row['type'] == 'password' || $page_form_pro_option_query->row['type'] == 'confirm_password') {
							$field_data[] = array(
								'name'                    => $page_form_pro_option_query->row['field_name'],
								'value'                   => base64_encode(serialize($value)),
								'type'                    => $page_form_pro_option_query->row['type'],
							);
						} else {
							$field_data[] = array(
								'name'                    => $page_form_pro_option_query->row['field_name'],
								'value'                   => $value,
								'type'                    => $page_form_pro_option_query->row['type'],
							);
						}
					}
				}
			}

			$form_data['field_data'] = $field_data;
			
			if (isset($this->request->post['product_id'])) {
				$product_id = (int)$this->request->post['product_id'];
			} else {
				$product_id = '';
			}

			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if($product_info) {
				$form_data['product_id'] = $product_info['product_id'];
				$form_data['product_name'] = $product_info['name'];
			} else{
				$form_data['product_id'] = '';
				$form_data['product_name'] = '';
			}			
			
			// Page Request
			$this->load->model('page/requestpro');
			$this->model_page_requestpro->addPageRequestPro($form_data);


			// Success
			$json['success'] = true;

			$json['success_title'] = ($page_form_pro_info['success_title']) ? $page_form_pro_info['success_title'] : '';
			
			$json['success_message'] = html_entity_decode($page_form_pro_info['success_description'], ENT_QUOTES, 'UTF-8');

			$json['success_button_continue'] = $this->language->get('button_close');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}