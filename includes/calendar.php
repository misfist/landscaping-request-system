<?php
/*
Plugin Name: calendar_csci216
Plugin URI: http://chelan.highline.edu/~csci201
Description: This is This is the calendar customer interface.
Version: 1.0
Author: Domino Developers
Author URI: http://chelan.highline.edu/~csci201
*/
function build_calendar($month, $year){		
		/*$username = "csci201";
		$password = "BottleTreefallBrassFreedom!";
		$servername = "localhost";
		$dbname = "csci201";
		$wpdb = new mysqli($servername, $username, $password, $dbname);

/*/ //Check wpdbection

$wpdb = new wpdb('username','password','database','localhost');
		if ($wpdb->wpdbect_error) {
			 die("wpdbection failed: " . $wpdb->wpdbect_error);
		}
   //$stmt = $wpdb->prepare("select bookedDate from orders;");
	$stmt = $wpdb->prepare("select * from bdetector where MONTH(bookedDate) = ? AND YEAR(bookedDate) = ?");
   //$stmt->execute();
    //$stmt->bind_param('ss', $month, $year);
    //$bookings = array();
    //if($stmt->execute()){
    //    $result = $stmt->get_result();
    //    if($result->num_rows>0){
    //        while($row = $result->fetch_assoc()){
    //            $bookings[] = $row['date'];
    //        }
    //        
    //        $stmt->close();
        //}
    //}
	//first of all we'll creat an array containing names of all days in a week
	$daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday', 'Friday', 'Saturday');
	
	//Then we'll get the frist day of the month that is in the argumnets of this function
	$firstDayOfMonth = mktime(0,0,0,$month, 1,$year);
	
	//now get the number of days this month contains
	$numberDays = date('t', $firstDayOfMonth);
	
	//getting some information about the first day of thois month
	$dateComponents = getdate($firstDayOfMonth);
	
	//getting the name of the month
	$monthName = $dateComponents['month'];
	
	//getting the index value 0-6 of the first day of this month
	$dayOfWeek = $dateComponents['wday'];
	
	//gettting the current date
	$dateToday = date('Y-m-d');
	
	//create HTML table
	$calendar="<table class='table table-bordered'>";
	$calendar.="<center><h2>$monthName $year</h2>";
	
	//$calendar .="<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0,0,0, $month-1, 1, $year))."'>Previous Month</a> ";
	$calendar .="<a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";
	$calendar .="<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y',mktime(0,0,0, $month+1, 1, $year))."'>Next Month</a></center><br>";
	
	$calendar.="<tr>";
	
	//create a calendar headers
	foreach($daysOfWeek as $day){
		$calendar.="<th class='header'>$day</th>";
	}
	$currentDay = 1;
	$calendar.="</tr><tr>";
	
	//The variable $dayOfWeek will make sure that must be only 7 columns on our table
	
	if($dayOfWeek >0){
		for($k = 0;$k < $dayOfWeek; $k++){
			$calendar.= "<td class='empty'></td>";
		}
	}
	
	
	//getting the day number
	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	
	while($currentDay <= $numberDays){
		
		//if seven coloumn(saturday) reached start a new row
		if($dayOfWeek == 7){
			$dayOfWeek = 0;
			$calendar.="</tr><tr>";
		}
		
		
		$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
		$date = "$year-$month-$currentDayRel";
		
		$dayname = strtolower(date('l', strtotime($date)));
		$eventNum = 0;
		
		$today = $date==date('Y-m-d')?"today":"";
		if($date<date('Y-m-d')){
			$calendar.="<td class='booked'><h4>$currentDay</h4><button class=''>N/A</button>";
		}elseif($date==date('Y-m-d')){
			$calendar.="<td class='booked'><h4>$currentDay</h4><button class='today'>Today</button>";
		}
//		elseif(in_array($date, $bookings)){
//            $calendar.="<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Already Booked</button>";}

		else{
			$calendar.="<td class='$today'><h4>$currentDay</h4><a href='request.php?date=".$date."'class='btn btn-success btn-sx'>Book</a>";
		}
		
		
		$calendar.="</td>";
		
		//incrementing the counters
		$currentDay++;
		$dayOfWeek++;
	}
	//completing the row of the last week in month necessary
	if($dayOfWeek != 7){
		$remainingDays = 7 - $dayOfWeek;
		for($i = 0; $i<$remainingDays; $i++){
			$calendar.= "<td></td>";
		}
	}
	
	$calendar.= "</tr>";
	$calendar.= "</table>";
	
	echo $calendar;
}


	//<meta name="viewport"content="width=device-width,initial-scale=1.0">"
	//<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	//<style>
	//	table{
	//		table-layout:fixed;
	//	}
	//	td{
	//		width:33%;
	//	}
	//	.today{
	//		background:yellow;
	//	}
	//	.booked{
	//		background: #F4F3F1;
	//	}
	//	
	//</style>
	function display_calendar(){
	echo "<div class='container'>";
		echo "<div class='row'>";
			echo "<div class='col-mid-12'>";
		
				$dateComponents = getdate();
				if(isset($_GET['month']) && isset($_GET['year'])){
                         $month = $_GET['month']; 			     
                         $year = $_GET['year'];
                     }else{
				$month = $dateComponents['mon'];
				$year = $dateComponents['year'];
					 }
				echo build_calendar($month,$year);
				
				
			echo "</div>";
		echo "</div>";
	echo "</div>";
}

function calendar_shortcode() {
	ob_start();
	
    display_calendar();
    
    return ob_get_clean(); 
}


add_shortcode( 'calendar_csci216', 'calendar_shortcode' );
