<?php

class Config{
	
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $db = "ecrud";
	private $conn = "";
	private $result = array();
	private $mysqli = false;


    public function __construct()
	{
		if(!$this->mysqli){
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db) or die("Connection Failed");
			$this->mysqli = true;
		}
		else return true;	   
	}

	public function insert($table, $params=array())
	{
		if($this->tableExists($table)){

			$col = implode(', ', array_keys($params));
			$val = implode("', '", $params);
			$sql = "INSERT INTO $table ($col) VALUES ('$val')";

			if($this->conn->query($sql)){
                return true;
			}else return false;

		}
		else{
            return false;
		}
		
	}

	public function update($table, $params=array(), $where = null)
	{
		if($this->tableExists($table)){

			$args = array();
			foreach($params as $k=>$v)
			{
                $args[] = "$k='$v'";
			}
			$sql = "UPDATE $table SET ".implode(', ',$args);
			
			if($where != null){
				$sql .= " WHERE $where";
			}

			if($this->conn->query($sql)){
                return true;
			}else 
			    return false;

		}
		else{
            return false;
		}
	}

	public function delete($table, $where = null)
	{
		if($this->tableExists($table)){
			$sql = "DELETE FROM $table";
			if($where != null){
				$sql .= " WHERE $where";
			}

			if($this->conn->query($sql)){
                return true;
			}else 
			    return false;

		}
		else{
            return false;
		}
	}

	public function select($table, $rows="*", $join = null, $where = null, $limit = null)
	{
		if($this->tableExists($table)){
			$sql = "SELECT $rows FROM $table";
			
			if($join != null){
				$sql .= " JOIN $join";
			}
			if($where != null){
				$sql .= " WHERE $where";
			}
			if($limit != null){
				if(isset($_GET['page'])){
					$page = $_GET['page'];
				}
				else{
					$page = 1;
				}
				$start = ($page-1) * $limit;
				$sql .= " LIMIT $start, $limit";
			}
			
			$result = $this->conn->query($sql);

			if($result){
				$this->result = $result->fetch_all(MYSQLI_ASSOC);
                return true;
			}else{
				array_push($this->result, $this->conn->error);
				return false;
			} 
			    
		}
		else{
            return false;
		}
	}
	
	public function pagination($table, $join = null, $where = null, $limit = null)
	{
		if($this->tableExists($table)){
			if($limit != null){
				$sql = "SELECT COUNT(*) FROM $table";
				if($join != null){
					$sql .= " JOIN $join";
				}
				if($where != null){
					$sql .= " WHERE $where";
				}
				
				$res = $this->conn->query($sql);
				$total = $res->fetch_array() ;
				$total = $total[0];
				$total_page = ceil($total / $limit);
				return $total_page;	
			}
			else{
                return false;
		    }
	    }
		else{
            return false;
		}
	}

	public function sql($sql)
	{
		$result = $this->conn->query($sql);
		if($result){
			$this->result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
			//return true;
		}
		else{
			array_push($this->result, $this->conn->error);
			return false;
		}
		
	}
	
	public function getResult()
	{
		$val = $this->result;
		$this->result = array();
		return $val;
	}

	private function tableExists($table)
	{
		$sql = "SHOW TABLES FROM $this->db LIKE '$table'";
		$t = $this->conn->query($sql);
		if($t){
			if($t->num_rows==1){
                 return true;   
			}
			else {
				array_push($this->result, $table." doesnt exist");
				return false;
			}
			
		}
	}


	public function __destruct()
	{
		if($this->mysqli){
			if($this->conn->close()){
				$this->mysqli = false;
				return true;
			}			
		}
		else 
		    return false;
	}
	
}

?>
