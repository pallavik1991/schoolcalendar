<?php 
include_once '/config/database.php';
include_once '/objects/schoolcalendar.php';

		$database = new Database();
		$db = $database->getConnection();

		$schoolcal = new SchoolCalendar($db);
		$schoolcal->academicyear=$_POST["param_acyear"];

		$result=$schoolcal->readAll();
 		echo json_encode($result);



	?>
	 