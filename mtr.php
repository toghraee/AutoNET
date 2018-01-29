<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ MTR Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center > AutoNet\\ MTR Information </p>";
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
    echo "<td>Building NEW Name</td><td>MTR</td><td> Get Info </td><td>Installed?</td>";
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
     $sql="select bld_oldname as bld_old, bld_newname as bld, new_name,installed from mtr  order by 1,3";
//    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());
	
    while ($row=mysql_fetch_assoc($result)){
        echo "<tr><form name=form2 method=get action=mtrinf.php>";
        echo "<input name=bld_old type=hidden value=".$row['bld_old'].">";
    	echo "<td><input name=bld     type=text READONLY value=".$row['bld']."></td>";
    	echo "<td><input name=new_name type=text READONLY value=".$row['new_name']."></td>";
    	echo "<td><input type=submit value=GetInfo></td>";
    	if ($row['installed']=='NO') $installed="<FONT color=RED><B> NO";
    	if ($row['installed']=='YES') $installed="<FONT color=GREEN><B> YES";
    	echo "<td align=center>".$installed."</td>";
    	echo "</tr></form>";
	}

}


echo "</body>";
echo "</html>";

?>
