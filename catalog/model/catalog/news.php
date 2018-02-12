<?php
class ModelCatalogNews extends Model { // Model - type of file this is. Catalog - the folder. News - the file name.
   public function getNews($news_id) { // Function to call for from other files. Name it anything you like, but always remember what you named it!
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "my_web_news WHERE news_id = '" . $news_id . "'"); // Running query to retrieve information from your database table.
 
      if ($query->num_rows) { // If row exists
         return $query->row; // I retrieved the information, now I must pass it back to the file that calls for it.
      } else {
         return false;
      }
   }
 
   


   public function getAllNews($data) {
    $sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON n.news_id = nd.news_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY date_added DESC";

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

public function countNews() {
    $count = $this->db->query("SELECT * FROM " . DB_PREFIX . "news");

    return $count->num_rows;
}

}
?>