<?php

class ControllerSmartbillSettings extends Controller {
    private $error = array(); // This is used to set the errors, if any.
     
    public function index() {   // Default function 
        $this->load->model('setting/setting');
        $this->load->model('smartbill/common');
        
        $this->model_smartbill_common->validateSettingsValues();

        $this->_labels($data);
        $this->_breadcrumbs($data);
        $this->document->setTitle($this->language->get('heading_title')); // Set the title of the page to the heading title in the Language file i.e., Smart Bill

        if ( !empty($this->request->post['submitSmartBill']) )
        {
            if ( !$this->saveSettings() ) {
                $data['warning'] = 'Va rugam completati campurile marcate cu *.';
            }
        }

        if ( $this->model_smartbill_common->isConnected() ) {
            $settings = $this->model_smartbill_common->getCloudSettings(true);
            $company  = $this->model_smartbill_common->getCompanyDetailsByVatCode($settings);
            $this->rewriteDataForForm($company);

            $data += $this->model_smartbill_common->getSettings();
            $data['settings'] = $settings;
            $data['company']  = $company;
        } else {
            $this->response->redirect($this->url->link('smartbill/login', 'token=' . $this->session->data['token'], 'SSL'));
            exit;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['thisSettings'] = $this;
        $this->response->setOutput($this->load->view('smartbill/settings.tpl', $data));
    }

    public function _renderSelect($values, $keyValue, $keyLabel, $selectedValue) {
        $html = '';

        if ( is_array($values) ) {
            foreach ($values as $item) {
                $item     = (array)$item;
                $selected = isset($item[$keyValue]) && $item[$keyValue] == $selectedValue ? ' selected="selected"' : '';
                $html    .= sprintf('<option value="%s"%s>%s</option>', $item[$keyValue], $selected, $item[$keyLabel]);
            }
        }

        return $html;
    }

    private function _labels(&$data) {
        $this->language->load('module/smartbill'); // Loading the language file of smartbill 
     
        $data['warning'] = '';
        $data['success'] = '';

        $data['heading_title'] = $this->language->get('heading_title');
     
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_content_top'] = $this->language->get('text_content_top');
        $data['text_content_bottom'] = $this->language->get('text_content_bottom');      
        $data['text_column_left'] = $this->language->get('text_column_left');
        $data['text_column_right'] = $this->language->get('text_column_right');
     
        $data['entry_code'] = $this->language->get('entry_code');
        $data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_position'] = $this->language->get('entry_position');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
     
        $data['button_login'] = $this->language->get('button_login');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');       

        $data['action'] = $this->url->link('smartbill/settings', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed     
        $data['cancel'] = $this->url->link('smartbill/settings', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed
    }

    private function _breadcrumbs(&$data) {
        $data['breadcrumbs'] = array();
     
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
     
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
     
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/smartbill', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );   
    }

    private function saveSettings() {
        $return = true;

        if ( $this->model_smartbill_common->isConnected() ) {
            $return = $this->saveFormSettings();
            $data = $this->model_smartbill_common->getCloudSettings();
            $this->saveCloudSettings($data);
            // $this->uppdateCompanySettings();
        }

        return $return;
    }
    private function saveFormSettings() {
        if ( isset($this->request->post['smartbill_company']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY', $this->request->post['smartbill_company']);
        }
        if ( isset($this->request->post['smartbill_price_include_vat']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_PRICE_INCLUDE_VAT', (int)$this->request->post['smartbill_price_include_vat']);
        }
        if ( isset($this->request->post['smartbill_products_vat']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_PRODUCTS_VAT', (int)$this->request->post['smartbill_products_vat']);
        }
        if ( isset($this->request->post['smartbill_transport_vat']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_TRANSPORT_VAT', (int)$this->request->post['smartbill_transport_vat']);
        }
        if ( isset($this->request->post['smartbill_document_type']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_DOCUMENT_TYPE', $this->request->post['smartbill_document_type']);
        }
        if ( isset($this->request->post['smartbill_invoice_series']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_INVOICE_SERIES', $this->request->post['smartbill_invoice_series']);
        }
        if ( isset($this->request->post['smartbill_proforma_series']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_PROFORMA_SERIES', $this->request->post['smartbill_proforma_series']);
        }
        // if ( isset($this->request->post['smartbill_order_qty_source']) ) {
        //     $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_ORDER_QTY_SOURCE', $this->request->post['smartbill_order_qty_source']);
        // }
        if ( isset($this->request->post['smartbill_product_sku_type']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_PRODUCT_SKU_TYPE', $this->request->post['smartbill_product_sku_type']);
        }
        if ( isset($this->request->post['smartbill_order_unit_type']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_ORDER_UNIT_TYPE', $this->request->post['smartbill_order_unit_type']);
        }
        if ( isset($this->request->post['smartbill_document_currency']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_DOCUMENT_CURRENCY', $this->request->post['smartbill_document_currency']);
        }
        if ( isset($this->request->post['smartbill_document_currency_doc']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_DOCUMENT_CURRENCY_DOC', $this->request->post['smartbill_document_currency_doc']);
        }
        if ( isset($this->request->post['smartbill_order_include_transport']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_ORDER_INCLUDE_TRANSPORT', $this->request->post['smartbill_order_include_transport']);
        }
        if ( isset($this->request->post['smartbill_company_save_client']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY_SAVE_CLIENT', $this->request->post['smartbill_company_save_client']);
        }
        if ( isset($this->request->post['smartbill_warehouse']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_WAREHOUSE', !empty($this->request->post['smartbill_warehouse']) ? $this->request->post['smartbill_warehouse'] : $this->model_smartbill_common->_get('NO_WAREHOUSE'));
        }
        if ( isset($this->request->post['smartbill_order_status']) ) {
            $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_ORDER_STATUS', $this->request->post['smartbill_order_status']);
        }

        $settings = $this->model_smartbill_common->getSettings();
        if ( !empty($settings['SMARTBILL_COMPANY_IS_TAX_PAYER']) ) {
            $productsVAT    = $settings['SMARTBILL_PRODUCTS_VAT'];
            $transportVAT   = $settings['SMARTBILL_TRANSPORT_VAT'];
            $invoiceSeries  = $settings['SMARTBILL_INVOICE_SERIES'];
            $proformaSeries = $settings['SMARTBILL_PROFORMA_SERIES'];

            if ( empty($productsVAT)
              || empty($transportVAT)
              || ( $this->model_smartbill_common->exportInvoice() && empty($invoiceSeries) )
              || ( $this->model_smartbill_common->exportProforma() && empty($proformaSeries) ) ) {
                return false;
            }            
        }

        return true;
    }
    private function saveCloudSettings($company) {
        if (!empty($company)) {
            if (isset($company->name)) {
                $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY_NAME', $company->name);
            }
            if (isset($company->vatCode)) {
                $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY', $company->vatCode);
                // $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY_VAT_CODE', $company->vatCode);
            }
            if (isset($company->isTaxPayer)) {
                $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY_IS_TAX_PAYER', (int)$company->isTaxPayer);

                if (empty($company->isTaxPayer)) {
                    $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_PRICE_INCLUDE_VAT', 1);
                    $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_PRODUCTS_VAT', 0);
                    $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_TRANSPORT_VAT', 0);
                }
            }
            if (isset($company->usePaymentTax)) {
                $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY_USE_PAYMENT_TAX', (int)$company->usePaymentTax);
            }
            if (isset($company->saveProductToDb)) {
                $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY_SAVE_PRODUCT', (int)$company->saveProductToDb);
            }
            if (isset($company->isStockEnabled)) {
                $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_COMPANY_ENABLE_STOCK', (int)$company->isStockEnabled);
            }
            if (isset($settingsResponse->supportEmail)) {
                $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_SUPPORT_EMAIL', $settingsResponse->supportEmail);
            }
        }
    }

    // TODO: finish
    private function updateCompanySettings() {

    }

    private function rewriteDataForForm(&$company) {
        $settings = $this->model_smartbill_common->getSettings();

        if ( !empty($company) ) {
            $this->_rewriteTaxes($company->taxes);
            $this->_updateOptionsWithNotFound($company->taxes, $settings['SMARTBILL_TRANSPORT_VAT']);
            $this->_rewriteValueValue($company->invoiceSeries);
            $this->_updateOptionsWithNotFound($company->invoiceSeries, $settings['SMARTBILL_INVOICE_SERIES']);
            $this->_rewriteValueValue($company->estimateSeries);
            $this->_updateOptionsWithNotFound($company->estimateSeries, $settings['SMARTBILL_PROFORMA_SERIES']);
            $this->_rewriteMeasureUnits($company->measureUnits);
            $this->_updateOptionsWithNotFound($company->measureUnits, $settings['SMARTBILL_ORDER_UNIT_TYPE']);
            $this->_rewriteWarehouses($company->warehouses);
            $this->_updateOptionsWithNotFound($company->warehouses, $settings['SMARTBILL_WAREHOUSE'], false);
            $this->_rewriteDefaultVAT($company->defaultVatCode);
            $this->_updateOptionsWithNotFound($company->defaultVatCode, $settings['SMARTBILL_PRODUCTS_VAT']);
        }
    }
    private function _rewriteValueValue(&$data) {
        if ( is_array($data) ) {
            $newData = array();

            foreach ($data as $key => &$value) {
                $newData[] = array(
                    'id'    => $value,
                    'name'  => $value,
                );
            }

            $data = $newData;
        }
    }
    private function _rewriteTaxes(&$data) {
        if ( is_array($data) ) {
            foreach ($data as $key => &$value) {
                $value->name = $value->name . ' (' . $value->percentage . '%)';
            }
        }
    }
    private function _rewriteMeasureUnits(&$data) {
        $this->_rewriteValueValue($data);
        $data[] = array(
            'id'    => '@@@@@',
            'name'  => 'Preluat din SmartBill, pe produse'
        );
    }
    private function _rewriteDefaultVAT(&$data) {
        $data = array(
            array(
                'id'    => $data,
                'name'  => $data . '%',
            ),
            array(
                'id'    => 9998,
                'name'  => 'Preluat din PrestaShop, pe produse',
            ),
            array(
                'id'    => 9999,
                'name'  => 'Preluat din SmartBill, pe produse',
            ),
        );
    }
    private function _rewriteWarehouses(&$data) {
        if ( empty($data) ) {
            $data[] = $this->model_smartbill_common->_get('NO_WAREHOUSE');
        }

        $this->_rewriteValueValue($data);
    }
    private function _updateOptionsWithNotFound(&$data, $findItem, $withChooseOption=true) {
        $found = false;
        $choose= array();
        if ( $withChooseOption ) {
            $choose[] = array(
                'id'    => 0,
                'name'  => 'Alegeti',
            ); 
        }

        if ( !empty($findItem) ) {
            foreach ($data as $key => $item) {
                if ( (is_array($item) && !empty($item['id']) && $item['id'] == $findItem)
                  || (is_object($item) && !empty($item->id) && $item->id == $findItem) ) {
                    $found = true;
                    break;
                }
            }
        } else {
            $found = false;
        }

        // prepend only if not found
        if ( !$found ) {
            $data = array_merge($choose, $data);            
        }
    }
    public function yesNoOptions() {
        return array(
            array(
                'id'    => 1,
                'name'  => 'Da',
            ),
            array(
                'id'    => 0,
                'name'  => 'Nu',
            ),
        );
    }
    public function documentTypeOptions() {
        return array(
            array(
                'id'    => $this->model_smartbill_common->_get('INVOICE_VALUE'),
                'name'  => 'Factura',
            ),
            array(
                'id'    => $this->model_smartbill_common->_get('PROFORMA_VALUE'),
                'name'  => 'Proforma',
            ),
        );
    }
    public function productSKUTypes() {
        return array(
            array(
                'id'    => $this->model_smartbill_common->_get('PROD_MODEL'),
                'name'  => 'Model',
            ),
            array(
                'id'    => $this->model_smartbill_common->_get('SKU'),
                'name'  => 'SKU',
            ),
            array(
                'id'    => $this->model_smartbill_common->_get('UPC'),
                'name'  => 'UPC',
            ),
            array(
                'id'    => $this->model_smartbill_common->_get('EAN'),
                'name'  => 'EAN',
            ),
            array(
                'id'    => $this->model_smartbill_common->_get('JAN'),
                'name'  => 'JAN',
            ),
            array(
                'id'    => $this->model_smartbill_common->_get('ISBN'),
                'name'  => 'ISBN',
            ),
            array(
                'id'    => $this->model_smartbill_common->_get('MPN'),
                'name'  => 'MPN',
            ),
        );
    }
    public function qtySourceOptions() {
        return array(
            array(
                'id'    => 0,
                'name'  => 'Comandata',
            ),
            // array(
            //  'id'    => 1,
            //  'name'  => 'Facturata',
            // ),
            // array(
            //  'id'    => 2,
            //  'name'  => 'Livrata',
            // ),
        );
    }
    public function docCurrencyOptions() {
        return array(
            array(
                'id'    => 9998,
                'name'  => 'Moneda produselor',
            ),
            array(
                'id'    => 'RON',
                'name'  => 'RON - Leu',
            ),
        );
    }
    // TODO: finish
    public function orderStatusOptions() {
        return array(
            array(
                'id_order_state' => 0,
                'name' => 'Nu schimba',
            ),
        );

        // $lang       = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        // $statuses   = OrderState::getOrderStates($lang->id);
        // $statuses   = array_merge(array(array(
        //     'id_order_state' => 0,
        //     'name' => 'Nu schimba',
        // )), $statuses);

        // return $statuses;
    }

}