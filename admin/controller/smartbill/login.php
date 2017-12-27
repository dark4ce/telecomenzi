<?php

class ControllerSmartbillLogin extends Controller {
	public function index() {   // Default function 
	    $this->load->model('setting/setting');
        $this->load->model('smartbill/common');

        $this->model_smartbill_common->validateSettingsValues();

        $this->_labels($data);
        $this->_breadcrumbs($data);
	    $this->document->setTitle($this->language->get('heading_title')); // Set the title of the page to the heading title in the Language file i.e., Smart Bill

        if ( !empty($this->request->post['submitSmartBill']) )
        {
        	try {
        		$this->saveUser();
        	} catch (Exception $ex) {
        		$data['warning'] = $ex->getMessage();
                // $data['warning'] = 'Autentificare esuata. Va rugam verificati datele si incercati din nou.';
        	}
        } else {
            if ( !$this->model_smartbill_common->isConnected() ) {
                $data['warning'] = 'Nu s-a reusit conectarea la Smart Bill Cloud. Verificati numele de utilizator si parola';
            }            
        }

        if ( $this->model_smartbill_common->isConnected() ) {
            $data['success'] = 'Conectat cu succes la Smart Bill Cloud';
        }

        $data += $this->model_smartbill_common->getSettings();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('smartbill/login.tpl', $data));
	}

	private function _labels(&$data) {
	    $this->language->load('module/smartbill'); // Loading the language file of smartbill 
	 
		$data['warning'] = '';
		$data['success'] = '';

	    $data['heading_title'] = $this->language->get('heading_title');
	 
	    $data['button_login'] = $this->language->get('button_login');
	    $data['button_save'] = $this->language->get('button_save');
	    $data['button_cancel'] = $this->language->get('button_cancel');
	    $data['button_add_module'] = $this->language->get('button_add_module');
	    $data['button_remove'] = $this->language->get('button_remove');		

	    $data['action'] = $this->url->link('smartbill/login', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed	 
	    $data['cancel'] = $this->url->link('smartbill/login', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed
	}

	private function _breadcrumbs(&$data) {
	    $data['breadcrumbs'] = array(
	    	array(
		        'text'      => $this->language->get('text_home'),
		        'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
		        'separator' => false,
		    ),
		    array(
		        'text'      => $this->language->get('text_module'),
		        'href'      => $this->url->link('module/smartbill', 'token=' . $this->session->data['token'], 'SSL'),
		        'separator' => ' :: ',
		    ),
		    array(
		        'text'      => $this->language->get('heading_title'),
		        'href'      => $this->url->link('smartbill/login', 'token=' . $this->session->data['token'], 'SSL'),
		        'separator' => ' :: ',
		    )
	    );
	}

    private function saveUser() {
    	$this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_USER', $this->request->post['smartbill_user']);

        if ( !empty($this->request->post['smartbill_pass']) ) {
        	try {
        		$this->model_smartbill_common->connectToCloud();
        	} catch (Exception $ex) {
        		throw $ex;
        	}
        }
    }
}