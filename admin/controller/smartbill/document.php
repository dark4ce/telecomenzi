<?php

class ControllerSmartbillDocument extends Controller {
    private $tOrders = 'order';
    private $allTaxRates;

    private function _initTaxRates() {
        $this->allTaxRates = array();

        foreach ($this->model_localisation_tax_rate->getTaxRates() as $key => $value) {
            $this->allTaxRates[$value['tax_rate_id']] = $value;
        }
    }

    public function index() {
        $this->load->model('setting/setting');
        $this->load->model('sale/order');
        // $this->load->model('checkout/order');
        $this->load->model('catalog/product');
        $this->load->model('localisation/tax_class');
        $this->load->model('localisation/tax_rate');
        $this->load->model('smartbill/common');

        if ( !$this->model_smartbill_common->isConnected() )  return;

        $this->_initTaxRates();

        try {
            $order = $this->model_sale_order->getOrder((int)$this->request->get['order_id']);

            if ( !empty($order) ) {
                $orderData = $this->db->query("SELECT smartbill_document_url FROM `" . DB_PREFIX . "order` WHERE `order_id`=" . $order['order_id']);
                if (!empty($orderData->rows[0]['smartbill_document_url'])) {
                    $this->response->redirect($orderData->rows[0]['smartbill_document_url']);
                    // header('Location: '.$orderData['smartbill_document_url']);
                    exit;
                }
            }

            $this->_saveOrderTaxSettings($order);

            $postData = new stdClass;
            $postData->companyVatCode       = $this->config->get('SMARTBILL_COMPANY');
            $postData->client               = $this->_getOrderClientData($order);
            $postData->isDraft              = true;
            $postData->issueDate            = date('Y-m-d', time());
            $postData->seriesName           = $this->_getDocumentSeriesName();
            if ( $this->model_smartbill_common->exportInvoice() ) {
                $postData->type = 'n';
            }
            $postData->currency             = $this->config->get('SMARTBILL_DOCUMENT_CURRENCY_DOC');
            $postData->currency             = $postData->currency=='9998' ? '' : $postData->currency;
            $postData->exchangeRate         = 1;
            $postData->language             = 'RO';
            $postData->precision            = 2;
            $postData->issuerName           = '';
            $postData->issuerCnp            = '';
            $postData->aviz                 = '';
            $postData->dueDate              = '';
            $postData->mentions             = 'comanda online #'.$order['order_id'];
            $postData->delegateAuto         = '';
            $postData->delegateIdentityCard = '';
            $postData->delegateName         = '';
            $postData->deliveryDate         = '';
            $postData->paymentDate          = '';
            $postData->usePaymentTax        = $this->_getCompanyUsePaymentTax();
            $postData->paymentTotal         = 0;
            $postData->paymentBase          = 0;
            $postData->colectedTax          = 0;
            $postData->orderNumber          = $order['order_id'];
            $postData->trackingNumber       = '';
            $postData->products             = $this->_getOrderProducts($order);
            $postData->documentTotal        = $order['total'];
            if ( $this->model_smartbill_common->exportInvoice() ) {
                $postData->useStock         = $this->_getUseStock();
            }
            if (empty($postData->currency)
             && !empty($postData->products[0])) {
                $postData->currency         = $postData->products[0]->currency;
            }

            // update order status
            $this->_updateOrderStatus($order);

            // attach last JSON data to order
            $this->_saveOrderDataJSON($postData, $order);

            // send the data to Smart Bill Cloud
            $apiURL = $this->model_smartbill_common->exportProforma() ? $this->model_smartbill_common->_get('PROFORMA_URL') : $this->model_smartbill_common->_get('INVOICE_URL');

            $invoiceResponse = $this->model_smartbill_common->curl(
                $apiURL, 
                $postData, 
                array("Content-Type: application/json; charset=utf-8","Accept:application/json","Authorization: ECSDigest ".$this->model_smartbill_common->getAuthorization()), 
                false, 
                false
            );

            $invoiceResponse = json_decode($invoiceResponse);
            if (!empty($invoiceResponse->url)) {
                $this->response->redirect($invoiceResponse->url);
                // header('Location: '.$invoiceResponse->url);
                exit;
            }
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    private function _saveOrderTaxSettings($order)
    {
        $taxSettings = array(
            // 'SMARTBILL_DISCOUNT_INCLUDE_TAX'     => $this->config->get('SMARTBILL_DISCOUNT_INCLUDE_TAX'),
            // 'SMARTBILL_CALCULATION_ALGORITHM'    => $this->config->get('SMARTBILL_CALCULATION_ALGORITHM'),
            // 'SMARTBILL_CALCULATION_BASED_ON'     => $this->config->get('SMARTBILL_CALCULATION_BASED_ON'),
            'SMARTBILL_PRICE_INCLUDE_TAX'           => $this->config->get('config_tax'),
            // 'SMARTBILL_SHIPPING_INCLUDE_TAX'     => $this->config->get('SMARTBILL_SHIPPING_INCLUDE_TAX'),
            // 'SMARTBILL_APPLY_AFTER_DISCOUNT'     => $this->config->get('SMARTBILL_APPLY_AFTER_DISCOUNT'),
            // 'SMARTBILL_APPLY_TAX_ON'             => $this->config->get('SMARTBILL_APPLY_TAX_ON'),
            // 'SMARTBILL_DISPLAY_TYPE'             => $this->config->get('SMARTBILL_DISPLAY_TYPE'),
            // 'SMARTBILL_DISPLAY_SHIPPING'         => $this->config->get('SMARTBILL_DISPLAY_SHIPPING'),
            // 'SMARTBILL_CART_DISPLAY_PRICE'       => $this->config->get('SMARTBILL_CART_DISPLAY_PRICE'),
            // 'SMARTBILL_CART_DISPLAY_SUBTOTAL'    => $this->config->get('SMARTBILL_CART_DISPLAY_SUBTOTAL'),
            // 'SMARTBILL_CART_DISPLAY_SHIPPING'    => $this->config->get('SMARTBILL_CART_DISPLAY_SHIPPING'),
            // 'SMARTBILL_CART_DISPLAY_GRANDTOTAL'  => $this->config->get('SMARTBILL_CART_DISPLAY_GRANDTOTAL'),
            // 'SMARTBILL_SALES_DISPLAY_PRICE'      => $this->config->get('SMARTBILL_SALES_DISPLAY_PRICE'),
            // 'SMARTBILL_SALES_DISPLAY_SUBTOTAL'   => $this->config->get('SMARTBILL_SALES_DISPLAY_SUBTOTAL'),
            // 'SMARTBILL_SALES_DISPLAY_SHIPPING'   => $this->config->get('SMARTBILL_SALES_DISPLAY_SHIPPING'),
            // 'SMARTBILL_SALES_DISPLAY_GRANDTOTAL' => $this->config->get('SMARTBILL_SALES_DISPLAY_GRANDTOTAL'),
        );

        // TODO:
        // attach taxes to order
        // $sql = 'UPDATE '.DB_PREFIX.$this->tOrders.' SET smartbill_tax_settings="'.str_replace('"', '\"', json_encode($taxSettings)).'" WHERE order_id='.(int)$order['order_id'];
        // $this->db->query($sql);
    }
    private function _updateOrderStatus($order) {
        // TODO:
        // $this->model_checkout_order->confirm($order['order_id'], (int)$this->config->get('SMARTBILL_ORDER_STATUS'));
    }
    private function _saveOrderDataJSON($postData, $order) {
        // TODO:
        // $sql = 'UPDATE '.DB_PREFIX.$this->tOrders.' SET smartbill_document_json="'.str_replace('"', '\"', json_encode($postData)).'" WHERE order_id='.(int)$order['order_id'];
        // $this->db->query($sql);
    }
    private function _getDocumentSeriesName() 
    {
        $seriesName = $this->config->get('SMARTBILL_INVOICE_SERIES');

        switch ( $this->config->get('SMARTBILL_DOCUMENT_TYPE') ) {
            case $this->model_smartbill_common->_get('PROFORMA_VALUE'):
                $seriesName = $this->config->get('SMARTBILL_PROFORMA_SERIES');
                break;
        }

        return $seriesName;
    }
    private function _getUseStock() 
    {
        $warehouseName  = strtolower( $this->config->get('SMARTBILL_WAREHOUSE') );
        $useStock       = $this->model_smartbill_common->_get('NO_WAREHOUSE') == $warehouseName ? false : (bool)$this->config->get('SMARTBILL_COMPANY_ENABLE_STOCK');

        return $useStock;
    }
    private function _getCompanyUsePaymentTax() {
        return (bool)$this->config->get('SMARTBILL_COMPANY_USE_PAYMENT_TAX');
    }
    private function _getOrderClientData($order) {
        $client = new stdClass;
        $client->vatCode    = !empty($order['payment_company_id']) ? $order['payment_company_id'] : '-';
        $client->name       = trim($order['payment_company']);
        $clientClean        = preg_replace('/[^a-z0-9]+/i', '',$client->name);
        $client->name       = empty($client->name) || empty($clientClean) ? $order['payment_lastname'].' '.$order['payment_firstname'] : $client->name;
        $client->code       = ''; // TODO (doesn't exist)
        $client->address    = $order['payment_address_1'].', '.$order['payment_address_2'].', '.$order['payment_postcode'];
        $client->regCom     = ''; // TODO (doesn't exist)
        $client->isTaxPayer = false; // TODO (doesn't exist/might be based on VIES check but not 100% correct)
        $client->contact    = $order['payment_lastname'].' '.$order['payment_firstname'];
        $client->phone      = $order['telephone'];
        $client->city       = $order['payment_city'];
        $client->county     = $order['payment_zone'];
        $client->email      = $order['email'];
        $client->bank       = '';
        $client->iban       = '';
        $client->saveToDb   = (bool)$this->config->get('SMARTBILL_COMPANY_SAVE_CLIENT'); // TODO (cateodata daca este trimis se primeste measj "Clientul exista deja pe server.")

        return $client;
    }
    private function _getOrderProducts($order) {
        $products = array();

        foreach ( $this->model_sale_order->getOrderProducts($order['order_id']) as $product ) {
            // based on initial price of the product (if happens that in prestashop is configured price catalog rules)
            $productDiscountBasePrice = $this->createOrderProductDiscountFromBasePrice($product);
            if (!empty($productDiscountBasePrice)) {
                // update the product price with the discount that will be applied separately
                $orderProduct = $this->createOrderProduct($product, false);
                // $orderProduct->price += abs($productDiscountBasePrice->discountValue / $orderProduct->quantity);
                $products[] = $orderProduct;
                $products[] = $productDiscountBasePrice;
                $extraProducts = 1;
            } else {
                $products[] = $this->createOrderProduct($product);
                $extraProducts = 0;
            }

            $productDiscountDistributed = $this->createOrderProductDiscountDistributed($product, $order, $extraProducts);
            if (!empty($productDiscountDistributed)) {
                $products[] = $productDiscountDistributed;
            }
        }

        // order discount (sum of all discounts)
        // $orderDiscount = $this->createOrderDiscount($order, count($products));
        // if (!empty($orderDiscount)) {
        //     $products[] = $orderDiscount;
        // }

        // order discounts
        // foreach ( $order->getCartRules() as $cartRule ) {
        //     $products[] = $this->createOrderCartRule($cartRule);
        // }

        // shipping
        if ($this->config->get('SMARTBILL_ORDER_INCLUDE_TRANSPORT')) {
            $transport = $this->createOrderTransport($order);

            if ( !empty($transport) ) {
                $products[] = $transport;
            }
        }

        return $products;
    }
    private function createOrderProduct($orderItem, $withVAT=true) {
        $itemDetails = $this->model_catalog_product->getProduct($orderItem['product_id']);

        $product = new stdClass;
        $product->code                      = $this->config->get('SMARTBILL_PRODUCT_SKU_TYPE');
        $product->code                      = !empty($product->code) ? $itemDetails[$product->code] : $itemDetails['product_id'];
        if ( empty($product->code) ) {
            $product->code                  = !empty($itemDetails['model']) ? $itemDetails['model'] : (!empty($itemDetails['sku']) ? $itemDetails['sku'] : (!empty($itemDetails['upc']) ? $itemDetails['upc'] : (!empty($itemDetails['ean']) ? $itemDetails['ean'] : (!empty($itemDetails['jan']) ? $itemDetails['jan'] : (!empty($itemDetails['isbn']) ? $itemDetails['isbn'] : (!empty($itemDetails['mpn']) ? $itemDetails['mpn'] : $itemDetails['product_id']))))));
        }
        $product->currency                  = $this->config->get('SMARTBILL_DOCUMENT_CURRENCY');
        $product->exchangeRate              = 1;
        $product->isDiscount                = false;
        $product->isTaxIncluded             = $withVAT ? (bool)$this->config->get('SMARTBILL_PRICE_INCLUDE_VAT') : false;
        $product->measuringUnitName         = $this->config->get('SMARTBILL_ORDER_UNIT_TYPE');
        $product->measuringUnitName         = trim($product->measuringUnitName)=='' ? 'buc' : $product->measuringUnitName;
        $product->name                      = $orderItem['name'];
        // $product->price                     = floatval($orderItem['price']);
        $product->price                     = floatval($itemDetails['price']);
        $product->quantity                  = $orderItem['quantity'];
        $product->saveToDb                  = (bool)$this->config->get('SMARTBILL_COMPANY_SAVE_PRODUCT');
        $product->taxName                   = ''; // TODO (daca este trimisa se primeste mesaj "Cota tva a produsului XXX nu a fost gasita pe server!")
        $product->taxPercentage             = floatval($this->config->get('SMARTBILL_PRODUCTS_VAT'));
        $product->taxPercentage             = $product->taxPercentage=='' && $this->model_smartbill_common->isTaxPayer() ? '9999' : $product->taxPercentage;
        $product->translatedMeasuringUnit   = '';
        $product->translatedName            = '';
        $product->warehouseName             = $this->config->get('SMARTBILL_WAREHOUSE');

        if ( 9998 == $product->currency ) {
            $product->currency = $order['currency_code'];
        }

        switch ($product->taxPercentage) {
            // din prestashop pe produse
            case 9998:
                foreach ($this->model_localisation_tax_class->getTaxRules($itemDetails['tax_class_id']) as $taxRule) {
                    if ( !empty($this->allTaxRates[$taxRule['tax_rate_id']]['type'])
                      && 'P' == $this->allTaxRates[$taxRule['tax_rate_id']]['type'] ) {
                        $product->taxPercentage = floatval($this->allTaxRates[$taxRule['tax_rate_id']]['rate']);
                        break;
                    }
                }
                break;

            // din smartbill pe produse
            case 9999:
                $product->taxName = '@@@@@';
                $product->taxPercentage = 0;
                break;
        }

        return $product;
    }
    private function createOrderProductDiscountFromBasePrice($orderItem) {
        $itemDetails = $this->model_catalog_product->getProduct($orderItem['product_id']);

        $product = null;
        $baseItemPrice = $itemDetails['price'];
        $thisItemPrice = $orderItem['price'];

        // if (!empty($baseItemPrice)
        if ( 0.01 <= abs($thisItemPrice-$baseItemPrice)
          && $baseItemPrice!=$thisItemPrice ) {
            $product = $this->createOrderProduct($orderItem);
            $product->isDiscount                = true;
            $product->discountPercentage        = 0;
            $product->discountValue             = -abs($orderItem['quantity']*($thisItemPrice-$baseItemPrice));
            $product->discountType              = 1;
            $product->isTaxIncluded             = (bool)$this->config->get('SMARTBILL_PRICE_INCLUDE_VAT');
            // $product->isTaxIncluded             = false;
            $product->name                      = 'Discount (pret special): '.$orderItem['name'];
            $product->price                     = 0;
            $product->numberOfItems             = 1;
            $product->saveToDb                  = false;
            $product->discountTaxValue          = $product->discountValue*$product->taxPercentage/100; // TODO: why needed to be calculated on the client side? as long as we have isTaxIncluded :)

            switch ($product->taxPercentage) {
                // din prestashop pe produse
                case 9998:
                    $product->taxPercentage = floatval($orderItem['tax_rate']);
                    if ($product->isTaxIncluded) {
                        $product->discountTaxValue = $product->discountValue-$product->discountValue/(1+$product->taxPercentage/100);
                    } else {
                        $product->discountTaxValue = $product->discountValue*$product->taxPercentage/100;
                    }
                    break;

                // din smartbill pe produse
                case 9999:
                    $product->discountTaxValue = 0;
                    break;
            }

            $product->discountTaxValue = (float)number_format($product->discountTaxValue, 2);
        }

        return $product;
    }
    private function createOrderProductDiscountDistributed($product, $order, $extraProducts=0) {
        $discTotal  = $this->_getOrderDiscount($order);

        if ( empty($discTotal) )   return false;

        $orderItem  = $this->createOrderProduct($product);
        $orderItem->price = $product['price']; // overwrite the original price with the discounted one (if that's the case)
        $prodPrice  = $orderItem->quantity * $orderItem->price;
        $orderTotal = $this->_getOrderSubTotal($order);

        if ( empty($orderTotal)
         || 0 > $orderTotal )   return false;

        $discount   = round($discTotal * $prodPrice/$orderTotal, 2);
        $discountTax= 0;
        if ( $orderItem->isTaxIncluded
          && !empty($orderItem->taxPercentage) ) {
            $discountTax = $discount - $discount/(1 + $orderItem->taxPercentage/100);
        } else {
            $discountTax = $discount * $orderItem->taxPercentage/100;
        }

        $product = new stdClass;
        $product->code                      = '';
        $product->currency                  = $orderItem->currency;
        $product->exchangeRate              = 1;
        $product->isDiscount                = true;
        $product->discountPercentage        = 0;
        $product->isTaxIncluded             = $orderItem->isTaxIncluded;
        // $product->isTaxIncluded             = false;
        $product->discountValue             = -floatval($discount);
        $product->discountType              = 1;
        $product->measuringUnitName         = $this->config->get('SMARTBILL_ORDER_UNIT_TYPE');
        $product->name                      = 'Discount: ' . $orderItem->name;
        $product->price                     = 0;
        $product->quantity                  = 1;
        $product->numberOfItems             = 1+$extraProducts;
        $product->saveToDb                  = false;
        $product->taxName                   = ''; // TODO (daca este trimisa se primeste mesaj "Cota tva a produsului XXX nu a fost gasita pe server!")
        $product->taxPercentage             = $orderItem->taxPercentage;
        $product->discountTaxValue          = -$discountTax; // TODO: why needed to be calculated on the client side? as long as we have isTaxIncluded :)
        $product->translatedMeasuringUnit   = '';
        $product->translatedName            = '';
        $product->warehouseName             = $this->config->get('SMARTBILL_WAREHOUSE');

        return $product;
    }
    private function _getOrderSubTotal($order) {
        $subTotal = 0;

        foreach ( $this->model_sale_order->getOrderTotals($order['order_id']) as $total ) {
            if ( 'sub_total' == $total['code'] ) {
                $subTotal = (float)$total['value'];
                break;
            }
        }

        return $subTotal;
    }
    private function _getOrderDiscount($order) {
        $discount = 0;

        foreach ( $this->model_sale_order->getOrderTotals($order['order_id']) as $total ) {
            if ( in_array($total['code'], array('coupon', 'voucher')) ) {
                $discount += (float)$total['value'];
            }
        }

        return abs($discount);
    }
    private function createOrderDiscount($order, $productsCount) {
        if ( empty($order->total_discounts) )   return false;
        $order->total_discounts = (float)$order->total_discounts;
        if ( empty($order->total_discounts) )   return false;

        $product = new stdClass;
        $product->code                      = 'order_discount';
        $product->currency                  = $this->config->get('SMARTBILL_DOCUMENT_CURRENCY');
        $product->exchangeRate              = 1;
        $product->isDiscount                = true;
        $product->discountPercentage        = 0;
        // $product->isTaxIncluded             = (bool)$this->config->get('SMARTBILL_PRICE_INCLUDE_VAT');
        $product->isTaxIncluded             = false;
        // $product->discountValue             = -floatval($order->total_discounts);
        $product->discountValue             = -floatval($order->total_discounts_tax_excl);
        $product->discountType              = !empty($product->discountValue) ? 1 : 2;
        $product->measuringUnitName         = $this->config->get('SMARTBILL_ORDER_UNIT_TYPE');
        $product->name                      = 'Discount comanda';
        $product->price                     = 0;
        $product->quantity                  = 1;
        $product->numberOfItems             = $productsCount;
        $product->saveToDb                  = false;
        $product->taxName                   = ''; // TODO (daca este trimisa se primeste mesaj "Cota tva a produsului XXX nu a fost gasita pe server!")
        // $product->taxPercentage             = floatval($this->config->get('SMARTBILL_PRODUCTS_VAT'));
        // $product->taxPercentage             = $product->taxPercentage=='' && self::isTaxPayer() ? '9999' : $product->taxPercentage;
        // $product->discountTaxValue          = $product->discountValue*$product->taxPercentage/100; // TODO: why needed to be calculated on the client side? as long as we have isTaxIncluded :)
        // if ( $product->isTaxIncluded ) {
        //     $product->discountTaxValue      = $product->discountValue-$product->discountValue/(1+$product->taxPercentage/100);
        // }
        $product->discountTaxValue          = -($order->total_discounts_tax_incl-$order->total_discounts_tax_excl); // TODO: why needed to be calculated on the client side? as long as we have isTaxIncluded :)
        $product->translatedMeasuringUnit   = '';
        $product->translatedName            = '';
        $product->warehouseName             = $this->config->get('SMARTBILL_WAREHOUSE');

        $product->taxPercentage             = abs($product->discountTaxValue/$product->discountValue)*100;

        if ( 9998 == $product->currency ) {
            $product->currency = $order['currency_code'];
        }

        /*switch ($product->taxPercentage) {
            // din prestashop pe produse
            case 9998:
                $product->taxPercentage = floatval($orderItem['tax_rate']);
                if ($product->isTaxIncluded) {
                    $product->discountTaxValue = $product->discountValue-$product->discountValue/(1+$product->taxPercentage/100);
                } else {
                    $product->discountTaxValue = $product->discountValue*$product->taxPercentage/100;
                }
                break;

            // din smartbill pe produse
            case 9999:
                $product->taxName = '@@@@@';
                $product->taxPercentage = 0;
                $product->discountTaxValue = 0;
                break;
        }*/
        return $product;
    }
    private function createOrderCartRule($cartRule) {
        $product = new stdClass;
        $product->code                      = 'order_discount';
        $product->currency                  = $this->config->get('SMARTBILL_DOCUMENT_CURRENCY');
        $product->exchangeRate              = 1;
        $product->isDiscount                = true;
        // $product->discountedProductsNb      = $productsCount;
        $product->discountPercentage        = 0;
        $product->discountValue             = -floatval($cartRule['value']);
        $product->discountType              = !empty($product->discountValue) ? 1 : 2;
        $product->isTaxIncluded             = (bool)$this->config->get('SMARTBILL_PRICE_INCLUDE_VAT');
        $product->measuringUnitName         = $this->config->get('SMARTBILL_ORDER_UNIT_TYPE');
        $product->measuringUnitName         = 'buc';
        $product->name                      = $cartRule['name'];
        $product->price                     = 0;
        $product->quantity                  = 1;
        $product->numberOfItems             = 1;
        $product->saveToDb                  = false;
        $product->taxName                   = ''; // TODO (daca este trimisa se primeste mesaj "Cota tva a produsului XXX nu a fost gasita pe server!")
        $product->taxPercentage             = floatval($this->config->get('SMARTBILL_PRODUCTS_VAT'));
        $product->taxPercentage             = $product->taxPercentage=='' && $this->model_smartbill_common->isTaxPayer() ? '9999' : $product->taxPercentage;
        $product->discountTaxValue          = $product->discountValue*$product->taxPercentage/100; // TODO: why needed to be calculated on the client side? as long as we have isTaxIncluded :)
        if ( $product->isTaxIncluded ) {
            $product->discountTaxValue      = $product->discountValue-$product->discountValue/(1+$product->taxPercentage/100);
        }
        $product->translatedMeasuringUnit   = '';
        $product->translatedName            = '';
        $product->warehouseName             = $this->config->get('SMARTBILL_WAREHOUSE');

        if ( 9998 == $product->currency ) {
            $product->currency = $order['currency_code'];
        }

        switch ($product->taxPercentage) {
            // din prestashop pe produse
            case 9998:
                $product->taxPercentage = floatval($orderItem['tax_rate']);
                if ($product->isTaxIncluded) {
                    $product->discountTaxValue = $product->discountValue-$product->discountValue/(1+$product->taxPercentage/100);
                } else {
                    $product->discountTaxValue = $product->discountValue*$product->taxPercentage/100;
                }
                break;

            // din smartbill pe produse
            case 9999:
                $product->taxName = '@@@@@';
                $product->taxPercentage = 0;
                $product->discountTaxValue = 0;
                break;
        }

        return $product;
    }    
    private function createOrderTransport($order) {
        $transport = $this->_getOrderTransport($order);
        if ( empty($transport) )    return false;

        $transportTaxDetails = $this->_getTransportTaxDetails();

        $product = new stdClass;
        $product->code                      = 'shipping';
        $product->currency                  = $this->config->get('SMARTBILL_DOCUMENT_CURRENCY');
        $product->exchangeRate              = 1;
        $product->isDiscount                = false;
        $product->isTaxIncluded             = (bool)$this->config->get('SMARTBILL_PRICE_INCLUDE_VAT');
        $product->measuringUnitName         = 'buc';
        $product->name                      = 'Transport';
        $product->price                     = floatval($transport['value']);
        $product->quantity                  = 1;
        $product->saveToDb                  = false;
        $product->taxName                   = $transportTaxDetails[0];
        $product->taxPercentage             = floatval($transportTaxDetails[1]);
        $product->translatedMeasuringUnit   = '';
        $product->translatedName            = '';
        $product->warehouseName             = $this->config->get('SMARTBILL_WAREHOUSE');
        $product->isService                 = true;

        if ( 9998 == $product->currency ) {
            $product->currency = $order['currency_code'];
        }

        return $product;
    }
    private function _getOrderTransport($order) {
        $transport = false;

        foreach ( $this->model_sale_order->getOrderTotals($order['order_id']) as $total ) {
            if ( 'shipping' == $total['code'] ) {
                $transport = $total;
                break;
            }
        }

        return $transport;
    }
    private function _getTransportTaxDetails() {
        $details = array('', null);

        $taxes = $this->_getTransportTaxes();
        if (!empty($taxes[$this->config->get('SMARTBILL_TRANSPORT_VAT')])) {
            $details = $taxes[$this->config->get('SMARTBILL_TRANSPORT_VAT')];

            if ($details[1]==null || $details[1]=='') {
                $details[1] = '9999';
            }
        }

        return $details;
    }
    private function _getTransportTaxes() {
        $taxes      = array();
        $settings   = $this->model_smartbill_common->getCloudSettings(true);
        $company    = $this->model_smartbill_common->getCompanyDetailsByVatCode($settings);

        if (!empty($company->taxes)
         && is_array($company->taxes)) {
            foreach ($company->taxes as $key => $value) {
                $taxes[$value->id] = array($value->name, $value->percentage);
            }
        }

        return $taxes;
    }   
}