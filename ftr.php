<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ FTR Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center> AutoNet\\ FTR Information </p>";
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



function old_new(){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td>Old Name</td><td>New Name</td>";
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
     $sql="select bld_oldname as old ,bld_newname as new from ftr group by 1,2 order by 1,2";
 //    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr><td>".$row['old']."</td><td>".$row['new']."</td></tr>";
	}
	echo "</table>";
}




function form(){
  echo "<BR><BR><BR>";
  echo "<form name=form1 method=get action=ftrinf.php>";
  echo "<table border=1 align = center>";
    echo "<tr>";
    echo "<td>Building</td><td>Floor</td><td>FTR</td>";
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
//     $sql="select bld_newname, floor,old_name from ftr group by 1,2 order by 1,2,3";


echo "<tr>";


     $sql="select bld_newname as name from ftr group by 1 order by 1";
//    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

	echo "<td><select name=bld>";
    while ($row=mysql_fetch_assoc($result)){
    	echo "<option value=".$row['name'].">".$row['name']."</option>";
	}
	echo "</select></td>";
	
     $sql="select floor as name from ftr group by 1 order by 1";
//    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

	echo "<td><select name=floor>";
    while ($row=mysql_fetch_assoc($result)){
    	echo "<option value=".$row['name'].">".$row['name']."</option>";
	}
	echo "</select></td>";
		
	
	
     $sql="select old_name as name from ftr group by 1 order by 1";
//    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

	echo "<td><select name=ftr>";
    while ($row=mysql_fetch_assoc($result)){
    	echo "<option value=".$row['name'].">".$row['name']."</option>";
	}
	echo "</select></td>";
		
	echo "<td><input type=submit value=submit>";	
	echo "</tr></table></form>";
}




function form2(){
  echo "<BR><BR><BR>";

  echo "<table border=1 align = center>";
    echo "<tr>";
    echo "<td>Building NEW Name</td><td>Floor</td><td>FTR</td><td> Get Info </td><td>Configured?</td><td>Installed?</td>";
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
//     $sql="select bld_newname, floor,old_name from ftr group by 1,2 order by 1,2,3";





     $sql="select bld_oldname as bld_old, bld_newname as bld, floor , new_name,old_name, installed, configured from ftr  order by 2,3,4";
//    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());
	
    while ($row=mysql_fetch_assoc($result)){
        echo "<tr><form name=form2 method=get action=ftrinf.php>";
        //echo "<td><input name=bld_old type=text READONLY value=".$row['bld_old']."></td>";
        echo "<input name=bld_old type=HIDDEN value=".$row['bld_old'].">";
    	echo "<td><input name=bld     type=text READONLY value=".$row['bld']."></td>";
    	echo "<td><input name=floor   type=text READONLY value=".$row['floor']."></td>";
 	echo "<td><input name=new_name type=text READONLY value=".$row['new_name']."></td>";
 	echo "<input name=old_name type=hidden READONLY value=".$row['old_name'].">";
 	echo "<td><input type=submit value=GetInfo></td>";
 	
    	if ($row['configured']=='NO') $configured="<FONT color=RED><B> NO";
    	if ($row['configured']=='YES') $configured="<FONT color=GREEN><B> YES";
    	echo "<td align=center>".$configured."</td>";
    	if ($row['installed']=='NO') $installed="<FONT color=RED><B> NO";
    	if ($row['installed']=='YES') $installed="<FONT color=GREEN><B> YES";
    	echo "<td align=center>".$installed."</td>";
    	echo "</tr></form>";
	}

}


echo "</body>";
echo "</html>";

?>
