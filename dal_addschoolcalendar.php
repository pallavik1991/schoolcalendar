<?php
include_once '/config/database.php';
include_once '/objects/schoolcalendar.php';

$database = new Database();
$db = $database->getConnection();

$schoolcal = new SchoolCalendar($db);
$msg="";
 
    try{

          if (empty($_POST["param_eventdate"]))  
            $msg.= "Event Date is required ";
        
        else
      
              $schoolcal->eventdate=$_POST["param_eventdate"];  

      if (empty($_POST["param_eventname"]))  
            $msg.= "Event Name is required ";
        
        else if (!preg_match ("/^[a-zA-Z\s.]{3,20}$/",$_POST["param_eventname"]))
              $msg.="Event Name should be minimum of 3-20 alphabets";
        else
      
        	$schoolcal->eventname=$_POST["param_eventname"];
        $schoolcal->academicyear=$_POST["param_acyear"];
        $schoolcal->reminder_required=$_POST["param_reminder"];
        $schoolcal->daysbefore=$_POST["param_days"];
        
         if(empty($msg))
        {


        if($schoolcal->create()){
            $msg="Success";
           
        }
    // if unable to create , tell the user
    else{
         $msg= "Unable";
        }
         echo json_encode($msg);
    }
    else
    {
    	 echo json_encode($msg);
    }
    
    }
    catch(Exception $ex)
    {
        $msg=$ex.errorMessage();
    }
    finally{
        //echo $msg;
    }
 
?>
