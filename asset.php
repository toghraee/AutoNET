<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ Asset</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center> AutoNet\\ Asset </p>";
echo "<br>";
echo "<br>";
$gotvar=$_GET['type'];
//echo $gotvar;
    if ($gotvar=='sum')  summary();
    if ($gotvar=='full')  full();


function summary(){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td>Name</td><td>Part Number</td><td>Qty</td><td>Category</td><td>Vendor</td>";
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
     $sql="select name,item,sum(qty) as qty,category,vendor from asset group by 1,2 order by 5,4,2";
 //    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr><td>".$row['name']."</td><td>".$row['item']."</td><td>".$row['qty']."</td><td>".$row['category']."</td><td>".$row['vendor']."</td></tr>";
	}
	echo "</table>";
}

function full(){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td>Name</td><td>Part Number</td><td>SR-NO</td><td>Qty</td><td>Category</td><td>Vendor</td><td>Installed?</td><td>Location</td><td>Delivered Date</td>";
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
     $sql="select name,item,srno,qty,category,vendor,location,delivered_date as dt from asset order by 5,6,2";
 //    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
       	$srno=$row['srno'];
       	$loc=$row['location'];
       	if ($srno=='') $srno='N/A';
      	if ($loc=='wearhouse') $installed='NO';
        if ($loc!='wearhouse') $installed='YES';
	echo "<tr><td>".$row['name']."</td><td>".$row['item']."</td><td>".$srno."</td><td>";
	echo $row['qty']."</td><td>".$row['category']."</td><td>".$row['vendor']."</td><td>";
	echo $installed."</td><td>".$loc."</td><td>".$row['dt']."</td></tr>";
	}
	echo "</table>";

}

echo "</body>";
echo "</html>";

?>
