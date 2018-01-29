<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ Wireless Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center> AutoNet\\ Wireless Information </p>";
echo "<br>";
echo "<br>";
/*$gotvar=$_GET['type'];
//echo $gotvar;
    if ($gotvar=='sum')  summary();
    if ($gotvar=='full')  full();
*/

//old_new();
form2();
//form();



function form2(){
  echo "<BR><BR><BR>";

  echo "<table border=1 align = center>";
    echo "<tr>";
    echo "<td>Building Name</td><td>Floor</td><td>Planned Number of Access Points</td><td>Installed Access Points</td><td> Get Info </td>";
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
//     $sql="select bld_newname, floor,old_name from Wireless group by 1,2 order by 1,2,3";

     $sql="select bld, level, aps from wireless_plan  order by 1,2";
//    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());
	
    while ($row=mysql_fetch_assoc($result)){
        echo "<tr><form name=form2 method=get action=wirelessinf.php>";
    	echo "<td><input name=bld     type=text READONLY value=".$row['bld']."></td>";
    	echo "<td><input name=level   type=text READONLY value=".$row['level']."></td>";
 	echo "<td>".$row['aps']."</td>";
 	getinstalled($row['bld'],$row['level']);
    	echo "<td><input type=submit value=GetInfo></td>";
    	echo "</tr></form>";
	}

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
    echo "<td>".$row['cnt']."</td>";
}



echo "</body>";
echo "</html>";

?>
