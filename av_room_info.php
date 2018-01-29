<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ AV Room  Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ FTR Information </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY>AV Room Info</font></p>";

/*
//echo $gotvar;
//    if ($gotvar=='sum')  summary();
//    if ($gotvar=='full')  full();

$bld_old=$_POST['bld_old'];
$bld=$_POST['bld']; 
$floor=$_POST['floor']; 
$old_name=$_POST['old_name'];



*/

$room=$_GET['room_id'];





getinfo($room);


 

//function showswitch($48p,$24p,$10g,$1g){


function getinfo($room){

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
     $sql="select av_rooms.room_id,bld_oldname, level, old_name, new_name, description, name ,av_rooms.type_id";
     $sql=$sql." from av_rooms, av_room_types where ";
     $sql=$sql."room_id=".$room." and ";
     $sql=$sql."av_rooms.type_id=av_room_types.type_id";
     
 //   echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

     $row=mysql_fetch_assoc($result);
        echo "<p align=center> <font size=48 color=PURPLE> Type: ".$row['name']."<BR>";
     
        echo "<BR><table border=1 align = center>";
        echo "<tr>";
        echo "<td>Attibute</td><td>Value</td>";
    	echo "</tr>";
	echo "<tr><td align=center> <font color=NAVY> General Information</td></tr>";
	echo "<tr><td> <font color=NAVY> Room Type </td><td><font color=NAVY>".$row['name']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Building OLD Name </td><td><font color=NAVY>".$row['bld_oldname']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Building NEW Name </td><td><font color=NAVY>".$row['bld_newname']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Floor </td><td><font color=NAVY>".$row['level']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Room OLD Name </td><td><font color=NAVY>".$row['old_name']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Room NEW Name </td><td><font color=NAVY>".$row['new_name']."</td></tr>";
	if ($row['installed']=='NO') $installed="<FONT color=RED><B> NO";
    	if ($row['installed']=='YES') $installed="<FONT color=GREEN><B> YES";
	echo "<tr><td> <font color=NAVY> Installed? </td><td><font color=NAVY>".$installed."</td></tr>";

	echo "</table>";


echo "<BR><BR>";
echo "<table border=1 align=center><tr>";
echo "<td>";
echo "<form method=get action=ftrtechwork.php>";
echo "<input type=hidden value=".$room.">";
echo "<input type=submit value=Generate-Technician-workorder>";
echo "</form>";
echo "</td></tr></table>";





showboq($row['type_id']);
showinstalled($row['room_id']);
showreport($row['room_id']);

$loc=$row['bld_oldname']."-".$row['level'];
showlocation($loc);


}



function showlocation($loc){
  echo "<BR><BR><BR>";
  echo "<table border=1 align = center>";
  echo "<tr><td>";
  echo "<img src=images/location/";
  echo $loc;
  echo ".jpg><BR>";
  echo "</table>";
}








function showboq($id){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td> <font color=YELLOW><B><B> Room BOQ </td></tr>";
    echo "<td><font color=YELLOW>Part Number</td><td><font color=YELLOW>Description</td><td><font color=YELLOW>Quantity</td><td><font color=YELLOW>Vendor</td>";
    echo "</tr>";
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
     $sql="select name,vendor,item,qty from av_room_boq where ";
     $sql=$sql."type_id='".$id."' order by 2";
//     echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr><td>".$row['item']."</td>";
	echo "<td>".$row['name']."</td>";
	echo "<td>".$row['qty']."</td>";
	echo "<td>".$row['vendor']."</td>";
	echo "</tr>";
	}
	echo "</table>";
}


function showinstalled($room_id){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td> <font color=YELLOW><B><B> Installed Items </td></tr>";
    echo "<td><font color=YELLOW>Part Number</td><td><font color=YELLOW>Description</td><td><font color=YELLOW>Serial NO</td><td><font color=YELLOW>Quantity</td><td><font color=YELLOW>Category</td><td><font color=YELLOW>Installed Date</td>";
    echo "</tr>";
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
     $sql="select category,partno,srno,description,qty,installed_date as dt from installed where ";
     $sql=$sql."room_type='AV' and room_id=".$room_id." order by 1,2,3";
//     echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr><td>".$row['partno']."</td><td>";
	echo "<td>".$row['description']."</td><td>";
	echo "<td>".$row['srno']."</td><td>";
	echo "<td>".$row['qty']."</td><td>";
	echo "<td>".$row['category']."</td><td>";
	echo "<td>".$row['dt']."</td><td>";			
	echo "</tr>";
	}
	echo "</table>";
}



function showreport($room_id){
    echo "<BR> ";
    echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td> <font color=BROWN><B><B> Work History in the room </td></tr>";
    echo "<td><font color=BROWN>Date</td><td><font color=BROWN>Report</td><td><font color=BROWN>Person In-Charge</td><td>";
    echo "</tr>";
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
     $sql="select report, report_date,incharge from room_reports where ";
     $sql=$sql."room_type='AV' and room_id=".$room_id." order by 1,3";
//     echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr><td>".$row['report_date']."</td><td>";
	echo "<tr><td>".$row['report']."</td><td>";
	echo "<tr><td>".$row['incharge']."</td><td>";
	echo "</tr>";
	}
	echo "</table>";
}


echo "</body>";
echo "</html>";

?>
