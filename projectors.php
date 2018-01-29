<?php
echo "<html>";
echo "<meta http-equiv=refresh content=30; url=http://AutoNet.visionaire.net/AutoNet//projectors.php>";
echo "<head>";
echo "<title>AutoNet\\ Projector Control</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center> AutoNet\\ Projector Control </p>";
echo "<br>";
echo "<br>";

$community_string_private="private";

ini_set( "display_errors", 0);


$func=$_POST['func'];
$ip=$_POST['ip'];


//echo "<BR><BR> POST VALUE func=!$func!<BR><BR>";
//echo "<BR><BR> POST VALUE ip=!$ip!<BR><BR>";


if ($func=='RefreshThePage') ;

if ($func=='TurnOn') ProjectorSetState($ip,1,$community_string_private);
if ($func=='TurnOff') ProjectorSetState($ip,2,$community_string_private);



if ($func=='TurnOnAllProjectors')  ProjectorSetBulk(1,$community_string_private);
if ($func=='TurnOffAllProjectors') ProjectorSetBulk(2,$community_string_private);




start();






function start(){
    

    echo "<BR><BR><table border=1 align = center>";
	echo "<p>";
	echo "<tr>";
	echo "<form method=post>";
	echo "<td><input type=Submit name=func value=RefreshThePage></td>";
	echo "</tr>";
	echo "</form>";
	echo "</table>";
	echo "</p>";

    
    
    echo "<BR><BR><table border=1 align = center>";
	echo "<p>";
	echo "<tr>";
	echo "<form name=form1 method=post>";
	echo "<td><input type=Submit name=func value=TurnOnAllProjectors></td>";
	echo "<td><input type=Submit name=func value=TurnOffAllProjectors></td>";
	echo "</form>";
	echo "</table>";
	echo "</tr>";
	echo "</p>";

    
    
    echo "<BR>";
    
    echo "<table border=1 align = center>";
    echo "<p>";
    echo "<tr>";
    echo "<td><font color=LIGHTGREEN>Building</td><td><font color=LIGHTGREEN>ClassRoom</td><td><font color=LIGHTGREEN>Projector Name</td><td><font color=LIGHTGREEN>Current Power State</td><td><font color=LIGHTGREEN>IP Address</td><td><font color=LIGHTGREEN>TurnOn</td><td><font color=LIGHTGREEN>TurnOff</td>";
    echo "</tr>";
    echo "</p>";
    
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
     $sql="select bld,ip,room_name,projector_name from projectors  order by bld,room_name,projector_name";
//     echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

 
 
	 while ($row=mysql_fetch_assoc($result)){
		$ip_address=$row['ip'];
		echo "<tr><td>".$row['bld']."</td><td>".$row['room_name']."</td><td>Projector #".$row['projector_name']."</td>";
		
		$community_string_public="public";
		
		
		$state=ProjectorReadState($ip_address,$community_string_public);
		
		echo "<td align=center>".$state."</td><td>".$ip_address."</td>";
		echo "<form name=form method=POST>";
		echo "<input type=hidden name=ip value=$ip_address>";
		if ($state!="<font color=RED><B>projector OFFLINE") { 
		    echo "<td> <input type=submit name=func value=TurnOn> </td>";
		    echo "<td> <input type=submit name=func value=TurnOff> </td>";

		    $sql5="update projectors set status=1 where ip='".$ip_address."'";
	        //    echo "<R> $sql5<BR>";
    		    $result5 = mysql_query($sql5)
		       or die(mysql_error());


		}
		else {
		    echo "<td>  </td>";
		    echo "<td>  </td>";
		
		}
		echo "</form>";
		echo "</tr>";
		
			
		}
		echo "</table>";

}


function ProjectorReadState($ip,$community_string_public) {
	$oid=".1.3.6.1.4.1.29485.3.2.3.1.0";
	$state_int=snmpget($ip,$community_string_public,$oid,1000000,0);
//	echo "<BR><BR> VALUE IS :::::  !$state_int!<BR><BR>";
        if (!$state_int) $state="<font color=RED><B>projector OFFLINE";
        if ($state_int=="INTEGER: 1") $state="<font color=GREEN><B>On";
	if ($state_int=="INTEGER: 2") $state="<font color=RED><B>Off";
	if ($state_int=="INTEGER: 3") $state="<font color=PURPLE><B>Powering On";
	if ($state_int=="INTEGER: 4") $state="<font color=BROWN><B>Turning Off , Cooling";
	if ($state_int=="INTEGER: 5") $state="<font color=WHITE><B>Waiting for Confirm Off State";
	
	return($state);
}


function ProjectorSetState($ip,$value,$community_string_private) {

	$oid=".1.3.6.1.4.1.29485.3.2.3.1.0";
	$oid_type="i";
//	echo "<BR><BR> function is  snmpset($ip,$community_string_private,$oid,$oid_type,$value)  <BR><BR>";
	$state_int=snmpset($ip,$community_string_private,$oid,$oid_type,$value);
}




function ProjectorSetBulk($value,$community_string_private){

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
     $sql="select ip from projectors where status=1";
//     echo "<R> $sql<BR>";
     $result2 = mysql_query($sql)
       or die(mysql_error());
	
	
	 while ($row2=mysql_fetch_assoc($result2)){
		
	 	$ip_address=$row2['ip'];
//	 	echo "<br> working for this IP:$ip_address!<BR>";
		$oid=".1.3.6.1.4.1.29485.3.2.3.1.0";
		$oid_type="i";
		$state_int=snmpset($ip_address,$community_string_private,$oid,$oid_type,$value);
//		echo "<BR><BR> function is  snmpset($ip_address,$community_string_private,$oid,$oid_type,$value)";
		

		}//end of while


}//end of function


echo "</body>";
echo "</html>";

?>
