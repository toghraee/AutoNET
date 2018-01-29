<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ AV Room List </title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center> AutoNet\\ AV Room List  </p>";
echo "<br>";
echo "<br>";




form2();







function form2(){
  echo "<BR><BR><BR>";

  echo "<table border=1 align = center>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Building Series (Old Name)</td><td><font color=YELLOW>Old Room Name</td><td><font color=YELLOW> Level</td><td><font color=YELLOW>Room Type</td><td><font color=YELLOW> Name </td><td><font color=YELLOW>GetInfo</td>";
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
     $sql="select room_id,bld_oldname, level, description, old_name,  av_room_types.name as name from av_rooms, av_room_types  where av_rooms.type_id=av_room_types.type_id order by 2,3,5";
     $result = mysql_query($sql)
       or die(mysql_error());
	
    while ($row=mysql_fetch_assoc($result)){
    	
    	
    	echo "<tr><td>".$row['bld_oldname']."</td><td>".$row['old_name']."</td><td>".$row['level']."</td>";
     	echo "<td>".$row['name']."</td><td>".$row['description']."</td>";
 
        echo "<td><form name=form2 method=get action=av_room_info.php>";
        echo "<input name=room_id type=hidden  value=".$row['room_id'].">";
    	echo "<input type=submit value=GetInfo></td>";
    	echo "</tr></form>";
	}

}


echo "</body>";
echo "</html>";

?>
