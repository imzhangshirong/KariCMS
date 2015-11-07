<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/25
 */
class database{
	private $conn;
	public $result;
	function __construct(){
		$this->conn=new mysqli(DB_HOST, DB_USER,DB_PASS,DB_NAME);
		if($this->conn->connect_error){
			die('Database Connect Error:'.$this->conn->connect_error);
		}
		$this->conn->set_charset("utf8");
	}
	function __destruct (){
		$this->conn->close();
	}
	public function query($sql){
		$this->result=$this->conn->query($sql);
		if($this->conn->error){
			$jsonArr=array(
				'code'=>'0',
				'error'=>$this->conn->error
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
	}
	public function getID(){
		return $this->conn->insert_id;
	}
	public function error(){
		return $this->conn->error;
	}
	public function all2array(){
		$temp=array();
		while ( $row  = $this->result->fetch_assoc ()) {
			if(isset($row['url'])){
				$row['url']=PATH_HOST_HTTP.$row['url'];
			}
			$temp[]=$row;
		}
		return $temp;
	}
}
?>