<?php
class ModelCatalogInformation extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}

	public function getInformations() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");

		return $query->rows;
	}


	public function addStaticData($data) {
		//var_dump($data); 
	 
		//exit; 
		// $this->db->query("INSERT INTO  my_web_news  SET 
		//  title = '" . $this->db->escape($data['title']) . "', 
		//  description = '" . $this->db->escape($data['description']) . "'");
		$mysql_date_now = date("Y-m-d H:i:s");
		$timestamp = strtotime($mysql_date_now);
		
		 $this->db->query("INSERT INTO  my_web_news  SET 
		 title = '" . $this->db->escape($data['title']) . "', 
		 description = '" . $this->db->escape($data['description']) . "', 
		 date_added = '" . $timestamp. "'");

		 //var_dump($this); 
		 //exit; 

		//$address_id = $this->db->getLastId();

		//return $address_id;
	}

	public function getInformationLayoutId($information_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}
}