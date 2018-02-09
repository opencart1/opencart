<?php
class ModelBaseModel extends Model {
	
	protected $table;
	protected $primary_key = 'id';
    protected $enum_values;
	protected $query;
			
    public function __construct($registry) {
		parent::__construct($registry);
	}
	
	
	public function get($value) {	
		$this->query = "SELECT * FROM " . DB_PREFIX . "" . $this->table . " WHERE " . $this->primary_key . " = '" . $this->db->escape($value) . "'";
		return $this;
	}
	
		
	public function get_all() {		
		$this->query = "SELECT * FROM " . DB_PREFIX . "" . $this->table;
		return $this;		
	}
	
	
	public function get_many($values) {
	    $in_values = array();
		
		foreach ($values as $key=>$value) {		   	
			   $in_values[] = '"' . $this->db->escape($value) . '"';
			}
		$this->query = 'SELECT ' . $this->primary_key . ' FROM ' . DB_PREFIX . ' ' . $this->table . ' WHERE ' . $this->primary_key . ' IN (' . implode(', ', $in_values) . ')';	 
		return $this;
	}
	
	
    public function insert($data) {
    	
		foreach ($data as $field=>$value) {			
			$fields[] = '`' . $field . '`';
			$values[] = "'" . $this->db->escape($value) . "'";	
		}
		$field_list = join(',', $fields);
		$value_list = join(', ', $values);
		
		$this->query = "INSERT INTO " . DB_PREFIX . "`" . $this->table . "` (" . $field_list . ") VALUES (" . $value_list . ")";
		//$this->_run_after_create($data, $this->db->getLastId());	
		return $this;
	}
	
	
	public function insert_multi($column_names, $rows, $escape = true) {
		
	    $columns = array_walk($column_names, array($this, 'prepare_column_name') );
	    $columns = implode(',', $column_names);

	    if( $escape ) array_walk_recursive( $rows, array( $this, 'escape_value' ));
		
	    $length = count($rows);
		
	    for($i = 0; $i < $length; $i++) $rows[$i] = implode(',', $rows[$i]);
		
	    $values = "(" . implode( '),(', $rows ) . ")";
	 
	    $this->query = "INSERT INTO " . DB_PREFIX . " $this->table ( $columns ) VALUES $values";
	    return $this;
	}
	
	
	public function update($primary_value, $data) {
		
		$a = array();
		
		foreach($data as $key=>$value) {
		    $a[] = $key . " = '" . $this->db->escape($value) ."'";
		}
		$dataset = join(',', $a);
			
		$this->query = "UPDATE " . DB_PREFIX . "$this->table SET " . $dataset . " WHERE  $this->primary_key = '" . $primary_value . "'";
		return $this;
	}
	
	
	public function delete($id) {
		$this->query = "DELETE FROM " . DB_PREFIX . "$this->table WHERE $this->primary_key = '" . (int)$id . "'";				
		return $this;				
	}
	
	
	public function escape_value(& $value) {
        if( is_string($value) ){
            $value = "'" . $this->db->escape($value) . "'";
        }
    }
	
	
    public function prepare_column_name(& $name) {
        $name = "`$name`";
    }
	
	
	public function get_enum($column) {
		$enum = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "$this->table LIKE '$column'");
		
		preg_match_all("/'([\w ]*)'/", $enum->row['Type'], $enum_values);
		$this->enum_values = $enum_values[1];
		
		return $this->enum_values;
		
	}
	
	
	public function order_by($field,$type){
	   	$this->query .= " ORDER BY $field $type ";
		return $this;
   	}
	
	
	public function run_query(){
		return $this->db->query($this->query);
	}
    
	
	public function lastid(){
		return $this->db->getLastId();	
	}
	
}
?>
