<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ Core Port Maker</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ Core Port Maker </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> Core Port Maker";
echo "</p></font>";


//***************************EarthNET Core 01*********************************
echo "<BR><font color=green size=10> EarthNET Core 01 </font><BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";

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
$sql="select src_slot, src_port, src_ip, dst_type, dst_bld, dst_switch, dst_slot, dst_port, dst_ip ";
$sql=$sql." from portmapping where ";
$sql=$sql."src_switch='EarthNET_Core_01' order by 1,2";

    echo "<R> $sql<BR>";	
$result = mysql_query($sql)
or die(mysql_error());	
	
while ($row=mysql_fetch_assoc($result)) {

		$bld=$row['dst_bld'];
		

		echo "interface ethernet ".$row['src_slot']."/".$row['src_port'];
		echo "<BR>";
		echo "<BR>";
		echo "enable";
		echo "<BR>";
		echo "!";
		echo "<BR>";
		echo "!";
		echo "<BR>";
	}// while

			


//***************************EarthNET Core 02*********************************
echo "<BR><font color=green size=10> EarthNET Core 02 </font><BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";

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
$sql="select src_slot, src_port, src_ip, dst_type, dst_bld, dst_switch, dst_slot, dst_port, dst_ip ";
$sql=$sql." from portmapping where ";
$sql=$sql."src_switch='EarthNET_Core_02' order by 1,2";

    echo "<R> $sql<BR>";	
$result = mysql_query($sql)
or die(mysql_error());	
	
while ($row=mysql_fetch_assoc($result)) {

		$bld=$row['dst_bld'];
		


				echo "interface ethernet ".$row['src_slot']."/".$row['src_port'];
				echo "<BR>";
				echo "<BR>";
				echo "enable";
				echo "<BR>";
				echo "!";
				echo "<BR>";
				echo "!";
				echo "<BR>";

	}// while



//***************************SpaceNET Core 01*********************************
echo "<BR><font color=green size=10> SpaceNET Core 01 </font><BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";

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
$sql="select src_slot, src_port, src_ip, dst_type, dst_bld, dst_switch, dst_slot, dst_port, dst_ip ";
$sql=$sql." from portmapping where ";
$sql=$sql."src_switch='SpaceNET_Core_01' order by 1,2";

    echo "<R> $sql<BR>";	
$result = mysql_query($sql)
or die(mysql_error());	
	
while ($row=mysql_fetch_assoc($result)) {

		$bld=$row['dst_bld'];
		

		echo "interface ethernet ".$row['src_slot']."/".$row['src_port'];
		echo "<BR>";
		echo "<BR>";
		echo "enable";
		echo "<BR>";
		echo "!";
		echo "<BR>";
		echo "!";
		echo "<BR>";

	}// while



//***************************SpaceNET Core 02*********************************
echo "<BR><font color=green size=10> SpaceNET Core 02 </font><BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";

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
$sql="select src_slot, src_port, src_ip, dst_type, dst_bld, dst_switch, dst_slot, dst_port, dst_ip ";
$sql=$sql." from portmapping where ";
$sql=$sql."src_switch='SpaceNET_Core_02' order by 1,2";

    echo "<R> $sql<BR>";	
$result = mysql_query($sql)
or die(mysql_error());	
	
while ($row=mysql_fetch_assoc($result)) {

		$bld=$row['dst_bld'];
		

		echo "interface ethernet ".$row['src_slot']."/".$row['src_port'];
		echo "<BR>";
		echo "<BR>";
		echo "enable";
		echo "<BR>";
		echo "!";
		echo "<BR>";
		echo "!";
		echo "<BR>";

	}// while


?>
