<?php

class ModelSmartbillCommon extends Model {
    private $VERSION               = '1.0.0';

    public  $DOMAIN_VALID          = '/.+(smartbill.ro)$/i';
    private $SSL_CERT_URL          = 'ssl://ws.smartbill.ro';
    private $LOGIN_URL             = 'https://ws.smartbill.ro/SBORO/api/company/ecs/login?version=';
    private $SETTINGS_URL          = 'https://ws.smartbill.ro/SBORO/api/company/ecs/info?version=';
    public  $INVOICE_URL           = 'https://ws.smartbill.ro/SBORO/api/invoice/ecs?version=';
    public  $PROFORMA_URL          = 'https://ws.smartbill.ro/SBORO/api/estimate/ecs?version=';

    private $DOCUMENT_DATE_NOW     = 0;
    private $DOCUMENT_DATE_ORDER   = 1;

    public  $INVOICE_VALUE         = 0;
    public  $PROFORMA_VALUE        = 1;

    public  $PROD_MODEL            = 'model';
    public  $SKU                   = 'sku';
    public  $UPC                   = 'upc';
    public  $EAN                   = 'ean';
    public  $JAN                   = 'jan';
    public  $ISBN                  = 'isbn';
    public  $MPN                   = 'mpn';

    // private $DEBUG_EMAIL_FROM      = 'support@smartbill.ro';
    private $DEBUG_EMAIL_SUBJECT   = 'DEBUG %s (opencart Smart Bill)';
    private $PUBLIC_KEY_FILENAME   = 'sbc_public_key.pem';
    private $CERT_FILENAME         = 'dwl-ws-test.crt';
    private $DEFAULT_LOGIN_ERROR   = 'Autentificare esuata. Va rugam verificati datele si incercati din nou.';
    private $CERT_URL_ERROR        = 'Accesul catre serviciul Smart Bill Cloud este restrictionat. Va rugam verificati configuratia serverului si incercati din nou.';
    private $SERVER_ERROR          = 'A intervenit o eroare la comunicarea cu Smart Bill Cloud. Va rugam verificati datele de conectare / reincercati o noua autentificare cu datele existente.';    
    public  $NO_WAREHOUSE          = 'fara gestiune';

    private $tOrders                = 'orders';
    private $tExtraFields           = array(
        'smartbill_document_url', 
        'smartbill_document_series', 
        'smartbill_document_number', 
        'smartbill_document_json', 
        'smartbill_order_items_prices', 
        'smartbill_tax_settings',
    );
    private $labelStatus            = 'Facturat in Smart Bill';

    public function _get($name) {
        return $this->$name;
    }

    public function index() {
        $this->load->model('setting/setting');
        $this->load->model('smartbill/common');
    }

    public function isConnected() {
        $token = $this->getLoginToken();
        return !empty($token);
    }
    public function isTaxPayer() {
        return (int)$this->config->get('SMARTBILL_PRODUCTS_VAT');
    }
    public function getSettings() {
        // $this->load->model('setting/setting');

        return $this->model_setting_setting->getSetting('SMARTBILL');
    }
    private function updateLoginToken($token='') {
        // $this->load->model('setting/setting');

        $this->model_setting_setting->editSettingValue('SMARTBILL', 'SMARTBILL_TOKEN', $token);
    }
    private function getLoginToken() {
        $settings = $this->getSettings();
        return !empty($settings['SMARTBILL_TOKEN']) ? $settings['SMARTBILL_TOKEN'] : '';
    }
    private function getLoginUser() {
        $settings = $this->getSettings();
        return !empty($settings['SMARTBILL_USER']) ? $settings['SMARTBILL_USER'] : '';
    }
    private function getCompany() {
        $settings = $this->getSettings();
        return !empty($settings['SMARTBILL_COMPANY']) ? $settings['SMARTBILL_COMPANY'] : '';
    }
    public function getDocumentType() {
        $settings = $this->getSettings();
        return !empty($settings['SMARTBILL_DOCUMENT_TYPE']) ? $settings['SMARTBILL_DOCUMENT_TYPE'] : '';
    }
    private function getCertificatePath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->CERT_FILENAME;
    }
    private function getSSLCertificate() {
        $g = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
        $r = stream_socket_client($this->SSL_CERT_URL, $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $g);
        $cont = stream_context_get_params($r);

        $sss = "_";
        openssl_x509_export($cont["options"]["ssl"]["peer_certificate"], $sss);

        if ( '_' !== $sss ) {
            $file = fopen($this->getCertificatePath(), "w");
            fwrite($file, $sss);
            fclose($file);
        }
    }

    public function curl($url, $data=null, $httpHeaders=null, $noSSL=false, $checkToken=true, $throwError=true) 
    {
        if ( empty($url)
         || ($url!=$this->LOGIN_URL && !$this->isConnected() && $checkToken))   return FALSE;

        $urlToCall = $url;
        switch ($url) {
            case $this->LOGIN_URL:
            case $this->SETTINGS_URL:
            case $this->INVOICE_URL:
            case $this->PROFORMA_URL:
                $urlToCall .= $this->VERSION;
                break;
        }
// echo $urlToCall;
// print_r($data);
// print_r($httpHeaders);
// die();
        $ch = curl_init($urlToCall);
        // $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        // curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if (!empty($data))
        {
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8","Accept:application/json"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        if (!empty($httpHeaders)
         && is_array($httpHeaders)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
        }

        // disable it, use the embed certificate delivered with the extension/plugin
        // if ($url==$this->LOGIN_URL) {
        //     $this->getSSLCertificate();
        // }

        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_CAINFO, $this->getCertificatePath());

        $return = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_status==200) {
        } else {
            $errorMessage = $return;
            $returnJSON   = json_decode($return);
            $errorMessage = empty($returnJSON->errorText) ? $errorMessage : $returnJSON->errorText;

            switch ($url) {
                case $this->LOGIN_URL:
                    // reset token
                    $this->updateLoginToken();

                    if ( empty($http_status) ) {
                        $return = $this->CERT_URL_ERROR;
                    } else {
                        $return = !empty($errorMessage) ? $errorMessage : $this->DEFAULT_LOGIN_ERROR;
                    }

                    throw new Exception($return, 1);
                    break;

                case $this->SETTINGS_URL:
                    // reset token
                    // $this->updateLoginToken();

                default:
                    $http_status = empty($http_status) ? '' : $http_status;
                    $errorMessage = empty($errorMessage) ? $this->SERVER_ERROR : $errorMessage;
                    throw new Exception($http_status . ': ' . $errorMessage);
                    break;
            }

            // empty response
            $return = '';
        }

        return $return;
    }
    public function getAuthorization()  {
        return base64_encode($this->getLoginUser() . ':' . $this->getLoginToken());
    }

    public function getCompanyDetailsByVatCode($settings, $vatCode='') {
        $vatCode = empty($vatCode) ? $this->getCompany() : $vatCode;
        $company = null;

        if ( !empty($settings->companies)
          && is_array($settings->companies) ) {
            $company = $settings->companies[0];

            if ( !empty($vatCode) ) {
                foreach ($settings->companies as $key => $value) {
                    if (!empty($value->vatCode)
                     && $value->vatCode==$vatCode) {
                        $company = $value;
                        break;
                    }
                }            
            }
        }

        return $company;
    }

    public function getCloudSettings($allSettings=false) {
        $settings = '';

        if ( $this->isConnected() ) {
            $settingsResponse = $this->curl(
                $this->SETTINGS_URL, 
                null, 
                array("Content-Type: application/json; charset=utf-8","Accept:application/json","Authorization: ECSDigest " . $this->getAuthorization()), 
                false, 
                false
            );
            if (!empty($settingsResponse)) {
                $settingsResponse   = json_decode($settingsResponse);
                $settings           = !$allSettings ? $this->getCompanyDetailsByVatCode($settingsResponse) : $settingsResponse;
            }
        }

        return $settings;
    }

    public function connectToCloud() {
        // reset token
        $this->updateLoginToken();

        try {
            $loginData = $this->curl($this->LOGIN_URL, $this->prepareLoginData());
            $token     = $this->_extractLoginToken($loginData);
            $this->updateLoginToken($token);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    private function prepareLoginData() {
        $config = $this->model_setting_setting->getSetting('config');

        $loginData = new stdClass;
        $loginData->version            = $this->VERSION;
        $loginData->username           = $this->request->post['smartbill_user'];
        $loginData->password           = $this->request->post['smartbill_pass'];
        $loginData->domainName         = $this->_getStoreURL();
        $loginData->statusCallbackUrl  = $this->_getCallbackURL();
        $loginData->name               = !empty($config['config_title']) ? $config['config_title'] : '';
        $loginData->ecsId              = 1;

        return $loginData;        
    }
    private function _getStoreURL()
    {
        $url = $this->url->link('/');
        $url = str_replace(array('http://', 'https://'), '', $url);
        $url = explode('/', $url);

        return $url[0];
    }
    private function _getCallbackURL() {
        $url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
        return $url->link('module/smartbill');
    }
    private function _extractLoginToken($loginData) {
        $loginData = json_decode($loginData);
        $token     = !empty($loginData->token) ? $loginData->token : '';

        return $token;
    }    

    public function ajaxProcessSendErrors() {
        $requestOrderIDs = Tools::getValue('id_order');

        if (!empty($requestOrderIDs)) {
            $orderIDs = explode(',', $requestOrderIDs);
            foreach ($orderIDs as $key => $orderID) {
                $sql    = 'SELECT smartbill_document_json, smartbill_tax_settings, reference FROM '._DB_PREFIX_.$this->tOrders.' WHERE id_order='.(int)$orderID;
                $order  =  Db::getInstance()->executeS($sql);

                if (!empty($order[0]['smartbill_document_json'])) {
                    $this->emailDebug($order[0]['smartbill_document_json'], $order[0]['smartbill_tax_settings'], $order[0]['reference']);
                }
            }

            $this->context->controller->confirmations[] = 'Datele au fost trimise ptr debugging';
        } else {
            $this->context->controller->errors[] = 'Selectati comenzile care contin erori';
        }

        Tools::redirectAdmin($this->context->link->getAdminLink('AdminOrders', true)."&id_order=$orderID&vieworder");
    }
    private function emailDebug($dataJSON, $taxesJSON, $orderID) {
        $toEmails = explode(',', Configuration::get('SMARTBILL_SUPPORT_EMAIL'));

        if (empty($toEmails)) {
            $this->context->controller->errors[] = 'Lipsa adresa email ptr debug';
            // Tools::displayError('Lipsa adresa email ptr debug');
            return;
        }

        $langID         = (int)Configuration::get('PS_LANG_DEFAULT');
        $templatePath   = dirname(__FILE__).DIRECTORY_SEPARATOR.'mails'.DIRECTORY_SEPARATOR;
        $templateVars   = array(
          '{LOGIN_EMAIL}'   => Configuration::get('SMARTBILL_USER'),
          '{URL}'           => self::_getStoreURL(),
          '{ORDER}'         => $orderID,
          '{JSON_TAXES}'    => $taxesJSON,
          '{JSON}'          => $dataJSON,
        );

        foreach ($toEmails as $key => $emalTo) {
            $emailSubject = sprintf(self::DEBUG_EMAIL_SUBJECT, '#'.$orderID);
            $sent = Mail::Send($langID, 'debug', $emailSubject, $templateVars, $emalTo, NULL, NULL, NULL, NULL, NULL, $templatePath);

            if ( empty($sent) ) {
                $this->context->controller->errors[] = 'Probleme la trimiterea datelor';
                // Tools::displayError('Probleme la trimiterea datelor');
            }
        }
    }

    public function exportInvoice() {
        return $this->getDocumentType()==$this->INVOICE_VALUE;
    }
    public function exportProforma() {
        return $this->getDocumentType()==$this->PROFORMA_VALUE;
    }

    public function decryptData($data) {
        $decrypted = '';

        try {
            $publicKey = $this->_getPublicKey();
            $res = openssl_get_publickey($publicKey);
            openssl_public_decrypt($this->_hex2bin($data), $decrypted, $res);
        } catch(Exception $e) {}
        
        return $decrypted;
    }
    private function _getPublicKey() {
        $publicKey = @file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->PUBLIC_KEY_FILENAME);

        return $publicKey;        
    }
    private function _hex2bin($hexdata) {
        $bindata = "";

        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }

    public function validateSettingsValues() {
        $settings = $this->getSettings();
        $defaults = array(
            'SMARTBILL_USER'                    => '',
            'SMARTBILL_TOKEN'                   => '',
            'SMARTBILL_COMPANY'                 => '',
            'SMARTBILL_COMPANY_NAME'            => '',
            'SMARTBILL_PRICE_INCLUDE_VAT'       => '',
            'SMARTBILL_PRODUCTS_VAT'            => '',
            'SMARTBILL_TRANSPORT_VAT'           => '',
            'SMARTBILL_DOCUMENT_TYPE'           => '',
            'SMARTBILL_INVOICE_SERIES'          => '',
            'SMARTBILL_PROFORMA_SERIES'         => '',
            'SMARTBILL_ORDER_QTY_SOURCE'        => '',
            'SMARTBILL_PRODUCT_SKU_TYPE'        => '',
            'SMARTBILL_ORDER_UNIT_TYPE'         => '',
            'SMARTBILL_DOCUMENT_CURRENCY'       => '',
            'SMARTBILL_DOCUMENT_CURRENCY_DOC'   => '',
            'SMARTBILL_ORDER_INCLUDE_TRANSPORT' => '',
            'SMARTBILL_COMPANY_SAVE_CLIENT'     => '',
            'SMARTBILL_WAREHOUSE'               => '',
            'SMARTBILL_ORDER_STATUS'            => '',
            'SMARTBILL_COMPANY_IS_TAX_PAYER'    => '',
            'SMARTBILL_COMPANY_USE_PAYMENT_TAX' => '',
            'SMARTBILL_COMPANY_SAVE_PRODUCT'    => '',
            'SMARTBILL_COMPANY_ENABLE_STOCK'    => '',
            'SMARTBILL_SUPPORT_EMAIL'           => '',
        );

        if ( array_keys($settings) != array_keys($defaults) ) {
            $settings += $defaults;
            $this->model_setting_setting->editSetting('SMARTBILL', $settings);
        }
    }
}