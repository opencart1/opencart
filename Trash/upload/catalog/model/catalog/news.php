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
 
   public function getAllNews() {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "my_web_news ORDER BY date_added DESC");
 
      return $query->rows;
   }
}
?>