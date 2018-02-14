<?php
class ModelCatalogTodolist extends Model {
	public function addtodolist($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "todolist SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$todolist_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "todolist SET image = '" . $this->db->escape($data['image']) . "' WHERE todolist_id = '" . (int)$todolist_id . "'");
		}

		if (isset($data['todolist_store'])) {
			foreach ($data['todolist_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "todolist_to_store SET todolist_id = '" . (int)$todolist_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'todolist_id=" . (int)$todolist_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('todolist');

		return $todolist_id;
	}

	public function edittodolist($todolist_id, $data) {
		echo "dfdsf"; exit; //die.'dfsf';
		$this->db->query("UPDATE " . DB_PREFIX . "todolist SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE todolist_id = '" . (int)$todolist_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "todolist SET image = '" . $this->db->escape($data['image']) . "' WHERE todolist_id = '" . (int)$todolist_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "todolist_to_store WHERE todolist_id = '" . (int)$todolist_id . "'");

		if (isset($data['todolist_store'])) {
			foreach ($data['todolist_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "todolist_to_store SET todolist_id = '" . (int)$todolist_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'todolist_id=" . (int)$todolist_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'todolist_id=" . (int)$todolist_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('todolist');
	}

	public function deletetodolist($todolist_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "todolist WHERE todolist_id = '" . (int)$todolist_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "todolist_to_store WHERE todolist_id = '" . (int)$todolist_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'todolist_id=" . (int)$todolist_id . "'");

		$this->cache->delete('todolist');
	}

	public function gettodolist($todolist_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'todolist_id=" . (int)$todolist_id . "') AS keyword FROM " . DB_PREFIX . "todolist WHERE todolist_id = '" . (int)$todolist_id . "'");

		return $query->row;
	}

	public function gettodolists($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "todolist";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function gettodolistStores($todolist_id) {
		$todolist_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "todolist_to_store WHERE todolist_id = '" . (int)$todolist_id . "'");

		foreach ($query->rows as $result) {
			$todolist_store_data[] = $result['store_id'];
		}

		return $todolist_store_data;
	}

	public function getTotaltodolists() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "todolist");

		return $query->row['total'];
	}
}
