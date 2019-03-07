<?php 
session_start();
if (!isset($_SESSION["email"]))
	{
		header("location: index.php");
	}
else{
    
	include("connection.php");
	$email = $_SESSION["email"];
    $name = "";
    $result1 = mysqli_query($conn,"SELECT stat FROM users WHERE email_id='" . $email . "'");
  
  while($row1 = $result1->fetch_assoc()){
    $stat = $row1['stat'];
    if($stat==0){
      header("location: complete_registeration.php");
    }
  }
    $query = "select t.tripid,t.userid,t.date_time,t.trip_name,t.des_id, 
  u.userid, u.fname,u.contact,u.email_id,u.locality,
  d.createTime,d.where_to_meet,d.time_to_meet,d.estimated_cost,d.how_to_reach,d.tripid,
  des.des_id,des.place,des.locality,des.Height_feet,des.Height_m,des.difficulty,des.season,des.picture,des.desc
  
from trips t 
left outer join destination des 
  on t.des_id=des.des_id
left outer join  describ d
  on t.tripid =d.tripid
left outer join users u
  on t.userid=u.userid 
  
where t.stat = 0";
  $result = mysqli_query($conn,$query);
  $rowcount = mysqli_num_rows($result);
	// $row = $result->mysqli_fetch_all();

}


?>




<!DOCTYPE html>
<html>
<head>
	<title>Trips | WanderLust</title>
	
  <link rel="stylesheet" type="text/css" href="css/normal_nav.css">
  <link rel="stylesheet" type="text/css" href="card.css">
  
</head>
<body >
  <?php
  include "normal_nav.php";
  ?><br><br><br><br><br><br><br><br>
 <?php
 function ordinal($num)
  {
    $last=substr($num,-1);
    if( $last>3  or 
        $last==0 or 
        ( $num >= 11 and $num <= 19 ) )
    {
      $ext='th';
    }
    else if( $last==3 )
    {
      $ext='rd';
    }
    else if( $last==2 )
    {
      $ext='nd';
    }
    else 
    {
      $ext='st';
    }
    return $num.$ext;
  }

 $i=1;
 while($row = $result->fetch_assoc()){
    $image = $row['picture'];
    $datetime = new DateTime($row['date_time']);
    $month =  $datetime->format('F');
    $day =  $datetime->format('d');
    $year =  $datetime->format('Y');
    $day = ordinal($day);
    $date_display = $day.' '.$month.' '.$year;
    $desc = substr($row['desc'], 0, 100);
    $name = $row['fname'];
    $trip_id = $row['tripid'];
    
        
    if($i%2===1){
      
      echo("<form action='main.php'  method='post'>");
       echo("<div class=blog-card>");
      echo("<div class='meta'>");
      echo '<img class ="photo" src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';
    // echo '<img class ="photo" src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';
      // echo("<div class='photo' style='background-image: url($image)'></div>");
      echo("<ul class='details'>");
      echo("<input type=hidden value='$trip_id' name=id>");
      echo("<li class='author'>Created by - ");echo($name);echo("</li>");
      echo("<li class='author'>Trip Date - ");echo($date_display);echo("</li>");
        echo("<li class='author'>");echo($row['Height_feet']);echo("ft,");
        echo($row['Height_m']);echo("m");echo("</li>");
        echo("<li class='date'>");echo($row['difficulty']);echo("</li>");
        echo("<li class='tags'>");
          echo("<ul>");
            echo("<li>");echo($row['season']);echo("</li>");
          echo("</ul>");
        echo("</li>");
      echo("</ul>");
    echo("</div>");
    echo("<div class='description'>");
      echo("<h1>");echo($row['place']);echo("</h1>");
      echo("<h2>");echo($row['locality']);echo("</h2>");
      echo('<p>');echo($desc);echo("....</p>");
      echo("<p class='read-more'><br>");
      echo("<input type='submit' style='border-radius:100px; color:#4CAF50; font-size:19px;background-color:white' name='More_Info' value='More Info'></button>");
      // echo("<a href='join_trip_acutal.php?id=1'>More Info</a>");
      echo("</form>");
        
      echo("</p>");
    echo("</div>");
  echo("</div>");
      $i++;
      
  }


    else if($i%2===0){

    echo("<form action='main.php'  method='post'>");  
    echo("<div class='blog-card alt'>");
    echo("<div class='meta'>");
    echo '<img class ="photo" src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';
    // echo '<img class ="photo" src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';  
      // echo("<div class='photo' style='background-image: url(base64_encode( $image ))'></div>");
      echo("<ul class='details'>");
      echo("<input type=hidden value='$trip_id' name=id>");
      echo("<li class='author'>Created by - ");echo($name);echo("</li>");
      echo("<li class='author'>Trip Date - ");echo($date_display);echo("</li>");
        echo("<li class='author'>");echo($row['Height_feet']);echo("ft,");
        echo($row['Height_m']);echo("m");echo("</li>");
        echo("<li class='date'>");echo($row['difficulty']);echo("</li>");
        echo("<li class='tags'>");
          echo("<ul>");
            echo("<li>");echo($row['season']);echo("</li>");
          echo("</ul>");
        echo("</li>");
      echo("</ul>");
    echo("</div>");
    echo("<div class='description'>");
      echo("<h1>");echo($row['place']);echo("</h1>");
      echo("<h2>");echo($row['locality']);echo("</h2>");
      echo('<p>');echo($desc);echo("....</p>");
      echo("<p class='read-more'><br>");
      echo("<input type='submit' style='border-radius:100px; color:#4CAF50; font-size:19px;background-color:white' name='More_Info' value='More Info'></button>");
      // echo("<input type='submit' name='More_Info' value='More Info'></button>");
      // echo("<a href='join_trip_acutal.php?id=1'>More Info</a>");
      echo("</form>");
      echo("</p>");
    echo("</div>");
  echo("</div>");

      $i++;
  }

 }
 
 ?>

 
</body>
</html>



  