
<?php

class SchoolCalendar{
	//database connection and table name

private $conn;
private $table_name="schoolcalendar";

//object properties
public $slno;
public $academicyear;
public $eventdate;
public $eventname;
public $reminder_required;
public $daysbefore;


public function __construct($db){
	$this->conn=$db;
}


function create(){
	

	try{

	$this->autogen();	
	$query="INSERT INTO ".$this->table_name. "(slno,academicyear,eventdate,eventname,reminder_required,daysbefore) values(?,?,?,?,?,?)";
	$stmt=$this->conn->prepare($query);

	//bind values
	$stmt->bindParam(1,$this->slno);
	$stmt->bindParam(2,$this->academicyear);
	$stmt->bindParam(3,$this->eventdate);
	$stmt->bindParam(4,$this->eventname);
	$stmt->bindParam(5,$this->reminder_required);
	$stmt->bindParam(6,$this->daysbefore);
	
	   
 	if($stmt->execute()){
		return true;
	}
	else{
		return false;
	}
	
}
catch(Exception $ex){
	return $ex.errorMessage();
}
}


//autogeneration
function autogen(){
	$query="select count(slno) as c, max(slno) as m from ".$this->table_name;
	$stmt=$this->conn->prepare($query);
	$stmt->execute();

	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$this->countrows=$row['c'];
	if($this->countrows==0)
		$this->slno=1;
	else{
		$this->slno=$row['m'];
		$this->slno++;
	}
}


//select all data
function readAll(){
	$query="SELECT * FROM ". $this->table_name." where academicyear=?";
	$stmt=$this->conn->prepare($query);

	//bind values
	$stmt->bindParam(1,$this->academicyear);
	
	
	$stmt->execute();
	$output=array();
	$output=$stmt->fetchall(PDO::FETCH_ASSOC);
	return $output;
}


}
?>