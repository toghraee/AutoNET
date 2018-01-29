<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ AV Room Types </title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center> AutoNet\\ AV Room Types  </p>";
echo "<br>";
echo "<br>";
/*$gotvar=$_GET['type'];
//echo $gotvar;
    if ($gotvar=='sum')  summary();
    if ($gotvar=='full')  full();
*/

//show();
form2();
//form();



function form2(){

    $host="127.0.0.1";
    $user="root";
    $password="rezasql";
    # Connect to MySQL server
    $conn = mysql_connect($host,$user,$password)
       or die(mysql_error());
    # Select the database
    mysql_select_db("", $conn)
       or die(mysql_error());
    # Send SQL query
     $sql="select name,type_id from av_room_types  order by 2";
     $result = mysql_query($sql)
       or die(mysql_error());
	
    while ($row=mysql_fetch_assoc($result)){
    	
    	echo "<BR><table border=1>";
    	echo "<tr><td><font color=BLUE> Type Description: <font color=WHITE> ".$row['name'];
    	echo "</td><td><font color=BLUE> Count:";
    	showcount($row['type_id']);
    	echo "</td></tr>";
    	showmembers($row['type_id']);

    	echo "</tr></table><br>";
	}

}



function showmembers($type_id){

    $host="127.0.0.1";
    $user="root";
    $password="rezasql";
    # Connect to MySQL server
    $conn = mysql_connect($host,$user,$password)
       or die(mysql_error());
    # Select the database
    mysql_select_db("", $conn)
       or die(mysql_error());
    # Send SQL query
     $sql="select description, count(*) as cnt from av_rooms where type_id='".$type_id."' group by 1  order by 1";
     $result1 = mysql_query($sql)
       or die(mysql_error());
    	echo "<tr><td><font color=YELLOW>  Room Description </td><td><font color=YELLOW> Count </td></tr>";	
    while ($row=mysql_fetch_assoc($result1)){
    	echo "<tr><td>".$row['description']."</td><td>".$row['cnt']."</td></tr>";

	}

}


function showcount($type_id){

    $host="127.0.0.1";
    $user="root";
    $password="rezasql";
    # Connect to MySQL server
    $conn = mysql_connect($host,$user,$password)
       or die(mysql_error());
    # Select the database
    mysql_select_db("", $conn)
       or die(mysql_error());
    # Send SQL query
     $sql="select count(*) as cnt from av_rooms where type_id='".trim($type_id)."'";
 //echo $sql;
 $result2 = mysql_query($sql)
       or die(mysql_error());
	$row=mysql_fetch_assoc($result2);
    	echo $row['cnt'];
}



echo "</body>";
echo "</html>";

?>
