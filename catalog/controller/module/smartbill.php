<?php  

class ControllerModuleSmartbill extends Controller {

	public function index() {
		require('admin/model/smartbill/common.php');
		$adminCommon = new ModelSmartbillCommon($this->registry);

    $inputData = file_get_contents("php://input");
    $inputData = $adminCommon->decryptData($inputData);
    $dataJSON  = json_decode($inputData);

    if ( empty($inputData)
      || empty($dataJSON->orderNumber) )  return;

    if ( empty($dataJSON->url)
      || empty($dataJSON->seriesName)
      || empty($dataJSON->documentNumber) ) {
      $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `smartbill_document_url` = '', `smartbill_document_series` = '', `smartbill_document_number` = '' WHERE `order_id`=" . (int)$dataJSON->orderNumber);
echo 'deleted';
      return;
    }

    $urlDetails = parse_url($dataJSON->url);
    if ( !empty($urlDetails['host'])
      && !preg_match($adminCommon->DOMAIN_VALID, $urlDetails['host']) ) return;

    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `smartbill_document_url` = '" . $this->db->escape($dataJSON->url) . "', `smartbill_document_series` = '" . $this->db->escape($dataJSON->seriesName) . "', `smartbill_document_number` = '" . $this->db->escape($dataJSON->documentNumber) . "' WHERE `order_id`=" . (int)$dataJSON->orderNumber);
echo 'updated';
	}

}