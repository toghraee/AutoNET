<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ Wireless Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ Wireless Information </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> Wireless Info</font></p>";


$bld=$_GET['bld'];
$level=$_GET['level']; 

getinfo($bld,$level);


function getinfo($bld,$level){
  echo "<BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td>Attibute</td><td>Value</td>";
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
     $sql="select bld, level, aps, map_file from wireless_plan where bld='".$bld."' and level='".$level."'";
          
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    $row=mysql_fetch_assoc($result);
	echo "<tr><td align=center> <font color=NAVY> General Information</td></tr>";
	echo "<tr><td> <font color=NAVY> Building NEW Name </td><td><font color=NAVY>".$bld."</td></tr>";
	echo "<tr><td> <font color=NAVY> Floor </td><td><font color=NAVY>";
	if ($level=='0') echo "GF";
	if ($level!='0') echo $level;
	echo "</td></tr>";
	echo "<tr><td> <font color=NAVY> Number of Access Points in this floor </td><td><font color=NAVY>".$row['aps']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Number of Installed Access Points </td><td><font color=NAVY>";
	getinstalled($row['bld'],$row['level']);
	echo "</td></tr>";
	echo "<tr><td> <font color=NAVY> Type of Access Points in this floor </td><td><font color=NAVY>Cisco 1252 dual radio with 6 antennas</td></tr>";
	echo "</table>";


$loc=$row['map_file'];
showinstalled($bld,$level);
showlocation($loc);

}


function getinstalled($bld,$level){
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
//     $sql="select bld_newname, floor,old_name from Wireless group by 1,2 order by 1,2,3";
     $sql="select count(*) as cnt from wireless_ap where bld='".$bld."' and level='".$level."'";
//    echo "<R> $sql<BR>";
     $result2 = mysql_query($sql)
       or die(mysql_error());
	
    $row=mysql_fetch_assoc($result2);
    echo $row['cnt'];
}



function showinstalled($bld,$level){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td> <font color=YELLOW><B><B> Installed Items </td></tr>";
    echo "<td><font color=YELLOW>AP Type</td><td><font color=YELLOW>AP MAC Address</td><td><font color=YELLOW>AP Serial NO</td>";
    echo "<td><font color=YELLOW>AP internal ID</td><td><font color=YELLOW>AP Name</td><td><font color=YELLOW>Installed Date</td>";
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
     $sql="select internal_id, ap_mac, ap_serial, ap_name, ap_model,installed_date as dt from wireless_ap where ";
     $sql=$sql."bld='".$bld."' and level='".$level."' order by 1,2,3";
 //    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr><td>".$row['ap_model']."</td><td>";
	echo "<td>".$row['ap_mac']."</td><td>";
	echo "<td>".$row['ap_serial']."</td><td>";
	echo "<td>".$row['internal_id']."</td><td>";
	echo "<td>".$row['ap_name']."</td><td>";
	echo "<td>".$row['dt']."</td><td>";			
	echo "</tr>";
	}
	echo "</table>";
}




function showlocation($loc){
  echo "<BR><BR><BR>";
//  echo $loc;
  echo "<BR>";
  echo "<table border=1 align = center>";
  echo "<tr><td>";
  echo "<a target=_blank href=images/wlan/".$loc."><img src=images/wlan/";
  echo $loc;
  echo "></a>";
  echo "</table>";
}


echo "</body>";
echo "</html>";

?>



