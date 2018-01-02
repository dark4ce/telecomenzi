<?php
class ModelExtensionModuleFgo extends Model {
	
	public function generateInvoice($connectionData, $invoiceData) {

		// update invoice number in DB
		$result = null;

		$result = $this->callService("/factura/emitere", $connectionData, $invoiceData);
		
		if (!empty($result['Success'])) {
				
			if (empty($result['Factura']['Serie']) || empty($result['Factura']['Numar'])) {
				throw new Exception("Eroare facturare. Raspuns invalid.", 1);
			}
			
			$invoice_no =  $result['Factura']['Numar'];
			$invoice_prefix = $result['Factura']['Serie'];
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($invoice_prefix) . "' WHERE order_id = '" . (int)$order_id . "'");
		} 
			
		return $result;
		
	}
	
	protected function callService($path, $connectionData, $serviceData) {

		$url = $connectionData['fgo_url'] . $path;
		 
		$hash = strtoupper(SHA1($connectionData['fgo_id'] . $connectionData['fgo_pass'] . $serviceData['Client']['Denumire']));
		
		$serviceData['Hash'] = $hash;
		$serviceData['CodUnic'] = $connectionData['fgo_id'];
		
		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($serviceData)
		    )
		);
		$context  = stream_context_create($options);
	
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) {
			
			$this->load->language('extension/module/fgo');
		 
			return array('Success' => false, 'Message' => $this->language->get('error_server_network'));
		}
		else{
			return json_decode($result, true);
		}
		
	}
	
	public function convertOrderToInvoice($orderInfo, $orderProducts) {
				
		$data = array();
		
		/** ORDER **/
		$data['CodUnic'] = '';
		$data['Hash'] = '';
		$data['Explicatii'] = '';
		$data['Valuta'] = $orderInfo['currency_code'];
		$data['TipFactura'] = 'Factura';
		
		
		/** CLIENT **/
		$codUnic = ''; $userType = '';
		// validate user id
		if (!empty($orderInfo['custom_field']['2'])) {
			$userType = 'PJ';
			$data['Client']['Denumire'] = $codUnic = $orderInfo['custom_field']['2']; // CUI / PJ
		}
		if (!empty($orderInfo['custom_field']['1'])) {
			$codUnic = $orderInfo['custom_field']['1']; // ID / PF
			$userType = 'PF';
			$data['Client']['Denumire'] = $orderInfo['firstname'] . ' ' . $orderInfo['lastname']; // CUI / PJ
		}
		
		// FOR TESTING
		// $codUnic = '1850724330925'; // ID / PF
		// $userType = 'PF';
		// $data['Client']['Denumire'] = $orderInfo['firstname'] . ' ' . $orderInfo['lastname']; // CUI / PJ
		
		$data['Client']['CodUnic'] = $codUnic;
		$data['Client']['Tip'] = $userType;
		$data['Client']['Judet'] = $orderInfo['payment_zone'];
		$data['Client']['Adresa'] = 'Loc. ' . $orderInfo['payment_city'] . ' ' . $orderInfo['payment_address_1'] . ' ' . $orderInfo['payment_address_2'];
		$data['Text'] = 'Posta / Curier'; // delegate name
		
		/** PRODUCTS **/
		if (!count($orderProducts)>0) {
			throw new Exception("No products in order.", 1);
			
		}
		$i=0;
		foreach ($orderProducts as $product) {
			$data['Continut'][$i]['Denumire']= $product['model'];
			$data['Continut'][$i]['PretUnitar']= $product['price'];
			$data['Continut'][$i]['UM'] = 'BUC';
			$data['Continut'][$i]['NrProduse'] = $product['quantity'];
			$data['Continut'][$i]['CotaTVA'] = $product['tax'];
			
			$i++;
		}
		
		return $data;
		
	}
		
	

}
