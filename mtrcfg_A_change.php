<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ A series MTR Changer Configuration</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ A series MTR Changer Configuration </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> A series MTR Changer Configuration";
echo "</p></font>";



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
$sql="select mtr_id,new_name,bld_newname , sw_fcx,sw_fcx_2x10g, sw_superx, sw_sx1600, sw_sx1600_2x10g, sw_mod_24p_sfp, sw_mod_2x10g, ";
$sql=$sql."sfpmm , sfpsm, xfpmm, xfpsm, installed ";
$sql=$sql." from mtr where ";
$sql=$sql."bld_newname like 'A%' or bld_newname like 'B%' ";

//    echo "<R> $sql<BR>";	
$result = mysql_query($sql)
or die(mysql_error());	
	
while ($row=mysql_fetch_assoc($result)) {

		$bld=$row['bld_newname'];
		$mtr_id=$row['mtr_id'];
		$new_name=$row['new_name'];
		
		echo "<BR><font color=green size=10> Working on MTR Building $bld </font><BR>";
		echo "<BR>";
		echo "<BR>";
		echo "config t";

		//ETC

		echo "<BR>";
		echo "!";
		echo "<BR>";
		echo "no ip access-list extended VOIP-MARKING";
		echo "<BR>";
		echo "enable super-user-password Gr8Vision";
		echo "<BR>";
		echo "cdp run";
		echo "<BR>";
		echo "fdp run";
		echo "<BR>";
		echo "snmp-server community T1F1MH02 ro";
		echo "<BR>";
		echo "sntp server 10.20.66.123";
		echo "<BR>";
		echo "!";
		echo "<BR>";
		echo "!";
		echo "<BR>";
		//ETC


		//loopback, host-name
		  $sql= "select ip from bld_ip where bld='".$bld."'";
		 $result2 = mysql_query($sql)
				   or die(mysql_error());	
		 $row=mysql_fetch_assoc($result2);
		 $ip=$row['ip'];
		 $ip2nd=substr($ip,3,3);
		 
		 echo "interface loopback 1";
		 echo "<BR>";
		 echo "ip address 10.$ip2nd.99.99/32";
		 echo "<BR>";
		 echo "ip ospf area 0.0.0.0";
		 echo "<BR>";
		 echo "exit";
		 echo "<BR>";
		 echo "ip multicast-routing";
		 echo "<BR>";
		 echo "!";
		 echo "<BR>";
		 echo "ip router-id 10.$ip2nd.99.99/32";
		 echo "<BR>";
		 echo  "hostname SW1-$bld-MTR-$new_name";
	     echo "<BR>";	 
		//loopback, host-name
		

		//Port delete
		echo "no interface ethernet 1/3/1";
		echo "<BR>";		
		echo "no interface ethernet 1/3/2";
		echo "<BR>";				
		echo "no interface ethernet 2/3/1";
		echo "<BR>";				
		echo "no interface ethernet 2/3/2";
		echo "<BR>";				
		
		/*$r=1;
		while ($r<25){
			echo "<BR>";
			echo "no interface ethernet 1/1/$r";
			echo "<BR>";
			echo "no interface ethernet 2/1/$r";
			$r++;
			}
		*/
	 // Uplinks to Core

		  $sql= "select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port, dst_ip from portmapping ";
		  $sql=$sql." where dst_type='MTR' ";
		  $sql=$sql." and dst_bld='".$bld."' and dst_roomid=".$mtr_id." and src_type='CORE'  ";
		  $sql=$sql." order by dst_slot, dst_port";
	 //	 echo "<BR> $sql <BR>";

			 $result2 = mysql_query($sql)
		   or die(mysql_error());	

			while ($row=mysql_fetch_assoc($result2)) {
				
				
				
				if (substr($row['dst_switch'],0,3)=='SW1') $sw=1;
				if (substr($row['dst_switch'],0,3)=='SW2') $sw=2;
				
				echo "<BR>";
				echo "!";
				echo "<BR>";
				echo "interface ethernet $sw/".$row['dst_slot']."/".$row['dst_port'];
				echo "<BR>";
				echo "port-name [UPLINK TO CORE -".$row['src_switch']." ".$row['src_slot']."/".$row['src_port']." ]";
				echo "<BR>";
				echo "ip address  ".$row['dst_ip'];
				echo "<BR>";
				echo "ip pim-sparse";
				echo "<BR>";
				echo "ip ospf area 0.0.0.0";
				echo "<BR>";
				echo "ip ospf dead-interval 3";
				echo "<BR>";
				echo "ip ospf hello-interval 1";
				echo "<BR>";
				echo "ip ospf md5-authentication key-id 1 key 1 $6lUdQUn";
				echo "<BR>";
				echo "ip ospf auth-change-wait-time 0";
				echo "<BR>";
				echo "ip ospf network point-to-point";
				echo "<BR>";
				echo "!";
				echo "<BR>";
				 echo "exit";
				 echo "<BR>";
				 echo "!";

			}// while

			


	 // SWICTH 1 DOWNLINKS  to FTR
	 
	 
	 
	 // Downlinks to FTRs
	 
	      $sql= "select src_switch, src_slot, src_port, src_ip,  dst_switch, dst_slot, dst_port, dst_ip  from portmapping where dst_type='MTR' ";
	      $sql=$sql." and dst_bld='".$bld."' and dst_roomid=".$mtr_id." and src_type='FTR' ";
	      $sql=$sql." order by  src_ip , dst_slot, dst_port ";
	 
	 	echo "<BR>";
//	 	echo "$sql";
	 	echo "<BR>";
	 
	      	 $result4 = mysql_query($sql)
	 	   or die(mysql_error());	
	 
	 	$ip_check='REZA';
	 	
	 	while ($row=mysql_fetch_assoc($result4)) {
	 	
			if (substr($row['dst_switch'],0,3)=='SW1') $sw=1;
			if (substr($row['dst_switch'],0,3)=='SW2') $sw=2;

	 	
	 	
	 	$ip_check2=$row['src_ip'];
	 	
	 	if ($ip_check!=$ip_check2) {
	 		$ip_check=$ip_check2;
	 		echo "interface ethernet $sw/".$row['dst_slot']."/".$row['dst_port'];
			echo "<BR>";
			echo "port-name [DOWNLINK TO FTR -".$row['src_switch']."    Port:".substr($row['src_switch'],2,1)."/".$row['src_slot']."/".$row['src_port']." ]";
			echo "<BR>";
			echo "no ip address *";
			echo "<BR>";
			echo "ip address  ".$row['dst_ip'];
			echo "<BR>";
			echo "ip ospf area 10.".$ip2nd.".0.0";
			echo "<BR>";
			echo "ip pim-sparse";
			echo "<BR>";
			echo "ip ospf dead-interval 3";
			echo "<BR>";
			echo "ip ospf hello-interval 1";
			echo "<BR>";
			echo "ip ospf md5-authentication key-id 1 key 1 $6lUGlU";
			echo "<BR>";
			echo "ip ospf auth-change-wait-time 0";
			echo "<BR>";
			echo "ip ospf network point-to-point";
			echo "<BR>";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			echo "!";
			echo "<BR>";
	  	}
	 	else {
	 	    echo "interface ethernet $sw/".$row['dst_slot']."/".$row['dst_port'];
	 	    echo "<BR>";
	 	    echo "!";
	 	    echo "<BR>";
	 	}
	 	
	 	
	 	
	 
	 }// while

	 	 echo "<BR>";
	 	 echo "<BR>";
	 	 echo "<BR>";
	 	 

	 




}// While 


?>
