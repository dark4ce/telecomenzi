<?php
class ModelPagePageRequestPro extends Model {
	public function getPageRequestPro($page_request_pro_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "page_request_pro WHERE page_request_pro_id = '" . (int)$page_request_pro_id . "'");

		return $query->row;
	}

	public function deletePageRequestPro($page_request_pro_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_request_pro` WHERE page_request_pro_id = '" . (int)$page_request_pro_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "page_request_pro_option` WHERE page_request_pro_id = '" . (int)$page_request_pro_id . "'");
	}

	public function getPageRequestPros($data = array()) {
		$sql = "SELECT *, CONCAT(pg.firstname, ' ', pg.lastname) AS customer FROM " . DB_PREFIX . "page_request_pro pg WHERE pg.page_request_pro_id > 0";

		if (!empty($data['filter_page_form_pro_title'])) {
			$sql .= " AND pg.page_form_pro_title LIKE '%" . $this->db->escape($data['filter_page_form_pro_title']) . "%'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(pg.firstname, ' ', pg.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_ip'])) {
			$sql .= " AND pg.ip = '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(pg.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'customer',
			'pg.date_added',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pg.date_added";
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

	public function getTotalPageRequestPros() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "page_request_pro");

		return $query->row['total'];
	}

	public function getPageRequestProOptions($page_request_pro_id) {
		$query = $this->db->query("SELECT `name`, `value`, `type` FROM " . DB_PREFIX . "page_request_pro_option  WHERE page_request_pro_id = '" . (int)$page_request_pro_id . "' ORDER BY page_request_pro_option_id ASC");

		return $query->rows;
	}
}