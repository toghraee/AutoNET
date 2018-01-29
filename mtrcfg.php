<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ MTR Configuration</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ MTR Configuration </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> MTR Configuration";

$mtr_id=$_GET['mtr_id'];


getinfo($mtr_id);


 


function getinfo($mtr_id){
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
     $sql=$sql."mtr_id='".$mtr_id."'";
     
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	
	
	$row=mysql_fetch_assoc($result);
    
    $sw='SWITCH';
    if ($row['sw_fcx_2x10g']>0) $sw='FCX';
    if ($row['sw_superx']>0) $sw='SUPERX';
    if ($row['sw_sx1600_2x10g']>0) $sw='SX1600';
    
	if ($row['bld_newname']=='D1_2' or $row['bld_newname']=='D3') build_mtr2_D($row['mtr_id'],$row['new_name'],$row['bld_newname']);
	else    build_mtr($mtr_id,$row['bld_newname'],$sw,$row['new_name']);
    
}


function build_mtr($mtr_id,$bld,$sw,$new_name){
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
     $sql= "select ip from bld_ip where bld='".$bld."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$ip=$row['ip'];
	$ip2nd=substr($ip,3,3);
	

echo "<BR><font size=48 color=NAVY>Building:".$bld."  MTR SW1-".$new_name."</font></p>";

 
echo "</font></font><p>";

echo "conf t";
echo "<BR>";
echo "";
echo "<BR>";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip multicast-routing";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "<BR>";
echo "enable super-user-password gr8Vision";
echo "<BR>";
echo "hostname SW1-".$bld."-MTR-".$new_name;
echo "<BR>";
echo "<BR>";
echo "<BR>";
echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.99";
echo "<BR>";
echo "no ip source-route";
echo "<BR>";
echo "ip icmp burst-normal 5000 burst-max 10000 lockup 300";
echo "<BR>";
echo "ip tcp burst-normal 10 burst-max 100 lockup 300";
echo "<BR>";
echo "ip multicast passive";
echo "<BR>";
echo "logging host 10.20.66.20";
echo "<BR>";
echo "logging console";
echo "<BR>";
echo "no telnet server";
echo "<BR>";
echo "username admin password gr8Vision";
echo "<BR>";
echo "cdp run";
echo "<BR>";
echo "fdp run";
echo "<BR>";
echo "snmp-server community 1 \$lZwZk0Q| ro";
echo "<BR>";
echo "clock timezone gmt GMT+04";
echo "<BR>";
echo "sntp server 10.20.66.123";
echo "<BR>";
echo "snmp-client 0.0.0.0 ";
echo "<BR>";
echo "no web-management hp-top-tools";
echo "<BR>";
echo "no web-management http";
echo "<BR>";
echo "banner motd ^#";
echo "<BR>";
echo "******************************************************************************************************";
echo "<BR>";
echo "* Your IP address has been logged. Access to this device is restricted to authorized personnel only. *";
echo "<BR>";
echo "* Unauthorized access is prohibited and is a punishable offense under law. Do not proceed if you are *";
echo "<BR>";
echo "* not authorized.                                                                                    *";
echo "<BR>";
echo "******************************************************************************************************^#";
echo "<BR>";
echo "!";
echo "<BR>";
echo "no port bootp";
echo "<BR>";
echo "router ospf";
echo "<BR>";
echo "area 10.".$ip2nd.".0.0 stub 1 no-summary";
echo "<BR>";
echo "area 0.0.0.0";
echo "<BR>";
echo "area 10.".$ip2nd.".0.0 range 10.".$ip2nd.".0.0 255.255.0.0 advertise";
echo "<BR>";
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".99.99/32";
 echo "<BR>";
 echo "ip ospf area 0.0.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";

if ($sw!="SUPERX") {
		echo "interface management 1";
		echo "<BR>";
		 echo "ip address 192.168.168.1 255.255.255.0";
		 echo "<BR>";
		echo "!";
		echo "<BR>";
}

// Uplinks to Core

     $sql= "select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port, dst_ip from portmapping ";
     $sql=$sql." where dst_type='MTR' ";
     $sql=$sql." and dst_bld='".$bld."' and dst_roomid=".$mtr_id." and src_type='CORE' and substring(dst_switch,1,3)='SW1' ";
     $sql=$sql." order by dst_slot, dst_port";
//	 echo "<BR> $sql <BR>";

     	 $result = mysql_query($sql)
	   or die(mysql_error());	
	
	while ($row=mysql_fetch_assoc($result)) {

	echo "interface ethernet ".$row['dst_slot']."/".$row['dst_port'];
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
	 echo "<BR>";
	 echo "!";
	 echo "<BR>";
	 echo "!";
	 echo "<BR>";

	}

	//  Downlinks to FTRs
	// D4 has link aggregation and will be separate here
//	if ($bld=='D4') {     THIS IS CHNAGED NOW AS WE REMOVED LACP LINKS FROM CONFIG. D4 is like a normal MTR
	if ($bld=='LACP_LINK_AGREEGATE') {
		
		//****************************Downlink TO FTR***********************************************
		$host="127.0.0.1";
		$user="root";
		$password="rezasql";
		# Connect to MySQL server
		$conn = mysql_connect($host,$user,$password)
		   or die(mysql_error());
		# Select the database
		mysql_select_db("", $conn)
		   or die(mysql_error());


		$sql="select src_roomid,dst_ip,count(*) from portmapping where dst_switch like 'SW1%' and src_type='FTR' and dst_roomid='".$mtr_id."' group by 1,2 order by 2";
//	    echo "<R> $sql<BR>";	
		 $result = mysql_query($sql)
		   or die(mysql_error());	
		$key=10000;
		   
		while ($row=mysql_fetch_assoc($result)) {
			$key=$key+1000;
			$flag=1;
			
			$sql="select src_switch,src_slot,src_port,dst_switch,dst_slot,dst_port	from portmapping where dst_ip='".$row['dst_ip']."' order by 1,2,3 ";
//			echo "<R> $sql<BR>";	
			 $result2 = mysql_query($sql)
			   or die(mysql_error());	
			
			while ($row2=mysql_fetch_assoc($result2)) {
			
				if ($flag==1) {
						$sw=substr($row2['dst_switch'],2,1);
						echo "interface ethernet ".$row2['dst_slot']."/".$row2['dst_port'];
						echo "<BR>";
						echo "port-name [DOWNLINK TO FTR -".$row2['src_switch']."    Port:".$row2['src_slot']."/".$row2['src_port']." ]";
						echo "<BR>";
						echo "route-only";
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
						echo "trust dscp ";
						echo "<BR>";
						echo "dhcp snooping trust";
						echo "<BR>";
						echo "link-aggregate configure key $key";
						echo "<BR>";
						echo "link-aggregate active";
						echo "<BR>";
						echo "!";
						echo "<BR>";
								
						$flag=0;
					}	
					else {
						
						echo "interface ethernet ".$row2['dst_slot']."/".$row2['dst_port'];
						echo "<BR>";
						echo "port-name [DOWNLINK TO FTR -".$row2['src_switch']."    Port:".$row2['src_slot']."/".$row2['src_port']." ]";
						echo "<BR>";
						echo "link-aggregate configure key $key";
						echo "<BR>";
						echo "link-aggregate active";
						echo "<BR>";
						echo "!";
						echo "<BR>";
					}// end else
			 
				} // end of WHILE INNER ROW 2
			 
			 echo "<BR>";
			 echo "!";
			 echo "<BR>";
		
		}// while uplinks
			

	}// if
	
	else {
		
		// Normal L3 Downlinks to FTRs

		 $sql= "select src_switch, src_slot, src_port, src_ip,  dst_switch, dst_slot, dst_port, dst_ip  from portmapping where dst_type='MTR' ";
		 $sql=$sql." and dst_bld='".$bld."' and dst_roomid=".$mtr_id." and src_type='FTR' and substring(dst_switch,1,3)='SW1'";
		 $sql=$sql." order by dst_slot, dst_port";

			 $result = mysql_query($sql)
		   or die(mysql_error());	

		while ($row=mysql_fetch_assoc($result)) {
		
		echo "interface ethernet ".$row['dst_slot']."/".$row['dst_port'];
		echo "<BR>";
		echo "port-name [DOWNLINK TO FTR -".$row['src_switch']."    Port:".substr($row['src_switch'],2,1)."/".$row['src_slot']."/".$row['src_port']." ]";
		 echo "<BR>";
		 echo "route-only";
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
		}//while
		
	}//else

// Remaining of config

echo "<BR>";
echo "ip access-list extended VOIP-MARKING";
echo "<BR>";
 echo "permit tcp any any range 2000 2002 dscp-marking 50 ";
 echo "<BR>";
 echo "permit tcp any any eq 1720 dscp-marking 50 ";
 echo "<BR>";
 echo "permit tcp any any range 11000 11999 dscp-marking 50 ";
 echo "<BR>";
 echo "permit udp any any eq 2427 dscp-marking 50 ";
 echo "<BR>";
 echo "permit udp any any range 16384 32767 dscp-marking 50 ";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "crypto key generate";
echo "<BR>";
echo "ip ssh  authentication-retries 5";
echo "<BR>";
echo "ip ssh  timeout 100";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "end";
echo "<BR>";

echo "<BR>";













//*******************************************************S W I T C H    2***************************************************

echo "<BR><font size=48 color=NAVY>Building:".$bld."  MTR SW2-".$new_name."</font></p>";

 
echo "</font></font><p>";

echo "conf t";
echo "<BR>";
echo "";
echo "<BR>";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip multicast-routing";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "<BR>";
echo "enable super-user-password gr8Vision";
echo "<BR>";
echo "hostname SW2-".$bld."-MTR-".$new_name;
echo "<BR>";
echo "<BR>";
echo "<BR>";
echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.98";
echo "<BR>";
echo "no ip source-route";
echo "<BR>";
echo "ip icmp burst-normal 5000 burst-max 10000 lockup 300";
echo "<BR>";
echo "ip tcp burst-normal 10 burst-max 100 lockup 300";
echo "<BR>";
echo "ip multicast passive";
echo "<BR>";
echo "logging host 10.20.66.20";
echo "<BR>";
echo "logging console";
echo "<BR>";
echo "no telnet server";
echo "<BR>";
echo "username admin password gr8Vision";
echo "<BR>";
echo "cdp run";
echo "<BR>";
echo "fdp run";
echo "<BR>";
echo "snmp-server community 1 \$lZwZk0Q| ro";
echo "<BR>";
echo "clock timezone gmt GMT+04";
echo "<BR>";
echo "sntp server 10.20.66.123";
echo "<BR>";
echo "snmp-client 0.0.0.0 ";
echo "<BR>";
echo "no web-management hp-top-tools";
echo "<BR>";
echo "no web-management http";
echo "<BR>";
echo "banner motd ^#";
echo "<BR>";
echo "******************************************************************************************************";
echo "<BR>";
echo "* Your IP address has been logged. Access to this device is restricted to authorized personnel only. *";
echo "<BR>";
echo "* Unauthorized access is prohibited and is a punishable offense under law. Do not proceed if you are *";
echo "<BR>";
echo "* not authorized.                                                                                    *";
echo "<BR>";
echo "******************************************************************************************************^#";
echo "<BR>";
echo "!";
echo "<BR>";
echo "no port bootp";
echo "<BR>";
echo "router ospf";
echo "<BR>";
echo "area 10.".$ip2nd.".0.0 stub 1 no-summary";
echo "<BR>";
echo "area 0.0.0.0";
echo "<BR>";
echo "area 10.".$ip2nd.".0.0 range 10.".$ip2nd.".0.0 255.255.0.0 advertise";
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".99.98/32";
 echo "<BR>";
 echo "ip ospf area 0.0.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";

if ($sw!="SUPERX") {
		echo "interface management 1";
		echo "<BR>";
		 echo "ip address 192.168.168.1 255.255.255.0";
		 echo "<BR>";
		echo "!";
		echo "<BR>";
}

// Uplinks to Core

     $sql= "select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port, dst_ip from portmapping ";
     $sql=$sql." where dst_type='MTR' ";
     $sql=$sql." and dst_bld='".$bld."' and dst_roomid=".$mtr_id." and src_type='CORE' and substring(dst_switch,1,3)='SW2' ";
     $sql=$sql." order by dst_slot, dst_port";

//	 echo "<BR> $sql <BR>";

     	 $result = mysql_query($sql)
	   or die(mysql_error());	
	
	while ($row=mysql_fetch_assoc($result)) {

	echo "interface ethernet ".$row['dst_slot']."/".$row['dst_port'];
	echo "<BR>";
	echo "port-name [UPLINK TO CORE -".$row['src_switch']." ".$row['src_slot']."/".$row['src_port']." ]";
	echo "<BR>";
	echo "ip address  ".$row['dst_ip'];
	 echo "<BR>";
	 echo "ip ospf area 0.0.0.0";
	 echo "ip pim-sparse";
	 echo "<BR>";
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
	 echo "<BR>";
	 echo "!";
	 echo "<BR>";
	 echo "!";
	 echo "<BR>";

	}

	
		//  Downlinks to FTRs
	// D4 has link aggregation and will be separate here
	if ($bld=='D4') {
		
		//****************************DOWNLINK TO FTR***********************************************
		$host="127.0.0.1";
		$user="root";
		$password="rezasql";
		# Connect to MySQL server
		$conn = mysql_connect($host,$user,$password)
		   or die(mysql_error());
		# Select the database
		mysql_select_db("", $conn)
		   or die(mysql_error());


		$sql="select src_roomid,dst_ip,count(*) from portmapping where dst_switch like 'SW2%' and src_type='FTR' and dst_roomid='".$mtr_id."' group by 1,2 order by 2";
//	    echo "<R> $sql<BR>";	
		 $result = mysql_query($sql)
		   or die(mysql_error());	
		$key=10000;
		   
		while ($row=mysql_fetch_assoc($result)) {
			$key=$key+1000;
			$flag=1;
			
			$sql="select src_switch,src_slot,src_port,dst_switch,dst_slot,dst_port	from portmapping where dst_ip='".$row['dst_ip']."' order by 1,2,3 ";
//			echo "<R> $sql<BR>";	
			 $result2 = mysql_query($sql)
			   or die(mysql_error());	
			
			while ($row2=mysql_fetch_assoc($result2)) {
			
				if ($flag==1) {
						$sw=substr($row2['dst_switch'],2,1);
						echo "interface ethernet ".$row2['dst_slot']."/".$row2['dst_port'];
						echo "<BR>";
						echo "port-name [DOWNLINK TO FTR -".$row2['src_switch']."    Port:".$row2['src_slot']."/".$row2['src_port']." ]";
						echo "<BR>";
						echo "route-only";
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
						echo "trust dscp ";
						echo "<BR>";
						echo "dhcp snooping trust";
						echo "<BR>";
						echo "link-aggregate configure key $key";
						echo "<BR>";
						echo "link-aggregate active";
						echo "<BR>";
						echo "!";
						echo "<BR>";
								
						$flag=0;
					}	
					else {
						
						echo "interface ethernet ".$row2['dst_slot']."/".$row2['dst_port'];
						echo "<BR>";
						echo "port-name [DOWNLINK TO FTR -".$row2['src_switch']."    Port:".$row2['src_slot']."/".$row2['src_port']." ]";
						echo "<BR>";
						echo "link-aggregate configure key $key";
						echo "<BR>";
						echo "link-aggregate active";
						echo "<BR>";
						echo "!";
						echo "<BR>";
					}// end else
			 
				} // end of WHILE INNER ROW 2
			 
			 echo "<BR>";
			 echo "!";
			 echo "<BR>";
		
		}// while uplinks
			

	}// if
	
	else {	
			
			
		// Normal L3 Downlinks to FTRs

			 $sql= "select src_switch, src_slot, src_port, src_ip,  dst_switch, dst_slot, dst_port, dst_ip  from portmapping where dst_type='MTR' ";
			 $sql=$sql." and dst_bld='".$bld."' and dst_roomid=".$mtr_id." and src_type='FTR' and substring(dst_switch,1,3)='SW2'";
			 $sql=$sql." order by dst_slot, dst_port";

				 $result = mysql_query($sql)
			   or die(mysql_error());	

			while ($row=mysql_fetch_assoc($result)) {
			
			echo "interface ethernet ".$row['dst_slot']."/".$row['dst_port'];
			echo "<BR>";
			echo "port-name [DOWNLINK TO FTR -".$row['src_switch']."    Port:".substr($row['src_switch'],2,1)."/".$row['src_slot']."/".$row['src_port']." ]";
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
	}//else

// Remaining of config

echo "<BR>";
echo "ip access-list extended VOIP-MARKING";
echo "<BR>";
 echo "permit tcp any any range 2000 2002 dscp-marking 50 ";
 echo "<BR>";
 echo "permit tcp any any eq 1720 dscp-marking 50 ";
 echo "<BR>";
 echo "permit tcp any any range 11000 11999 dscp-marking 50 ";
 echo "<BR>";
 echo "permit udp any any eq 2427 dscp-marking 50 ";
 echo "<BR>";
 echo "permit udp any any range 16384 32767 dscp-marking 50 ";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "crypto key generate";
echo "<BR>";
echo "ip ssh  authentication-retries 5";
echo "<BR>";
echo "ip ssh  timeout 100";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "end";
echo "<BR>";

echo "<BR>";



}// function




//********************************************************************************************************************


//**********************************************************************************************************************

function	build_mtr2_D($mtr_id,$new_name,$bld) {


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
     $sql= "select ip from bld_ip where bld='".$bld."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$ip=$row['ip'];
	$ip2nd=substr($ip,3,3);





echo "<BR><font size=48 color=NAVY>Building: $bld  MTR $new_name  <BR></p>";

 
echo "</font></font><p>";

echo "conf t";
echo "<BR>";
echo "";
echo "<BR>";
echo "stack enable";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip multicast-routing";
echo "<BR>";
echo "!";
echo "<BR>";
echo "<BR>";
echo "!";
echo "<BR>";

echo "aaa authentication enable default enable";
echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "boot sys fl sec";
echo "<BR>";
echo "enable super-user-password Gr8Vision";
echo "<BR>";
echo "hostname SW1-".$bld."-MTR-".$new_name;
echo "<BR>";


echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.99";
echo "<BR>";
echo "no ip source-route";
echo "<BR>";
echo "<BR>";
echo "logging host 10.20.66.20";
echo "<BR>";
echo "logging console";
echo "<BR>";
echo "no telnet server";
echo "<BR>";
echo "username admin password gr8Vision";
echo "<BR>";
echo "cdp run";
echo "<BR>";
echo "fdp run";
echo "<BR>";
echo "snmp-server community 1 \$lZwZk0Q| ro";
echo "<BR>";
echo "clock timezone gmt GMT+04";
echo "<BR>";
echo "sntp server 10.20.66.123";
echo "<BR>";
echo "snmp-client 0.0.0.0 ";
echo "<BR>";
echo "no web-management hp-top-tools";
echo "<BR>";
echo "no web-management http";
echo "<BR>";
echo "banner motd ^#";
echo "<BR>";
echo "******************************************************************************************************";
echo "<BR>";
echo "* Your IP address has been logged. Access to this device is restricted to authorized personnel only. *";
echo "<BR>";
echo "* Unauthorized access is prohibited and is a punishable offense under law. Do not proceed if you are *";
echo "<BR>";
echo "* not authorized.                                                                                    *";
echo "<BR>";
echo "******************************************************************************************************^#";
echo "<BR>";
echo "!";
echo "<BR>";

echo "router ospf";
echo "<BR>";
echo "area 10.".$ip2nd.".0.0 stub 1 no-summary";
echo "<BR>";
echo "area 0.0.0.0";
echo "<BR>";
echo "area 10.".$ip2nd.".0.0 range 10.".$ip2nd.".0.0 255.255.0.0 advertise";
echo "!";
echo "<BR>";
 
 
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
$loopback_ip="10.".$ip2nd.".99.99";



echo "<BR>";
 echo "ip address $loopback_ip  255.255.255.255";
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface management 1";
echo "<BR>";
 echo "ip address 192.168.168.1 255.255.255.0";
 echo "<BR>";
echo "!";
echo "<BR>";




//****************************DOWNLINK TO FTR***********************************************
    $host="127.0.0.1";
    $user="root";
    $password="rezasql";
    # Connect to MySQL server
    $conn = mysql_connect($host,$user,$password)
       or die(mysql_error());
    # Select the database
    mysql_select_db("", $conn)
       or die(mysql_error());
    
	$sql="select dst_roomid,dst_ip,count(*),length(dst_ip) from portmapping where src_type='FTR' and dst_roomid=".$mtr_id." group by 1,2 order by 4,2";
//    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	
	$key=10000;
	   
    while ($row=mysql_fetch_assoc($result)) {
		$key=$key+1000;
		$flag=1;
		
		$sql="select src_switch,src_slot,src_port,dst_switch,dst_slot,dst_port	from portmapping where dst_ip='".$row['dst_ip']."' order by 1,2,3 ";
//		echo "<R> $sql<BR>";	
		 $result2 = mysql_query($sql)
		   or die(mysql_error());	
    	
		while ($row2=mysql_fetch_assoc($result2)) {
		
			if ($flag==1) {
					$sw=substr($row2['dst_switch'],2,1);
					echo "interface ethernet ".$sw."/".$row2['dst_slot']."/".$row2['dst_port'];
					echo "<BR>";
					echo "port-name [".$row2['dst_switch']." Eth $sw/".$row2['dst_slot']."/".$row2['dst_port']." ] <--> ";
					echo "port-name [".$row2['src_switch']." Eth ".substr($row2['src_switch'],2,1)." /".$row2['src_slot']."/".$row2['src_port']." ]";
					echo "<BR>";
					echo "route-only";
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
					echo "trust dscp ";
					echo "<BR>";
					//echo "link-aggregate configure key $key";
					//echo "<BR>";
					//echo "link-aggregate active";
					//echo "<BR>";
					echo "ipv6 enable";
					echo "<BR>";
					echo "!";
					echo "<BR>";
							
					//$flag=0;
				}	
				else {
					$sw=substr($row2['dst_switch'],2,1);
					echo "interface ethernet ".$sw."/".$row2['dst_slot']."/".$row2['dst_port'];
					echo "<BR>";
					echo "port-name [".$row2['dst_switch']." Eth $sw/".$row2['dst_slot']."/".$row2['dst_port']." ] <--> ";
					echo "port-name [".$row2['src_switch']." Eth ".substr($row2['src_switch'],2,1)." /".$row2['src_slot']."/".$row2['src_port']." ]";
					echo "<BR>";
					echo "link-aggregate configure key $key";
					echo "<BR>";
					echo "link-aggregate active";
					echo "<BR>";
					echo "!";
					echo "<BR>";
				}// end else
		 
			} // end of WHILE INNER ROW 2
		 
		 echo "<BR>";
		 echo "!";
		 echo "<BR>";
	
	}// while uplinks
		
 
 // Uplinks to Core
//**********************************************************************
     $sql= "select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port, dst_ip from portmapping ";
     $sql=$sql." where dst_type='MTR' ";
     $sql=$sql." and dst_bld='".$bld."' and dst_roomid=".$mtr_id." and src_type='CORE' ";
     $sql=$sql." order by dst_slot, dst_port";
//	 echo "<BR> $sql <BR>";

     	 $result = mysql_query($sql)
	   or die(mysql_error());	
	
	while ($row=mysql_fetch_assoc($result)) {
	$sw=substr($row['dst_switch'],2,1);
	
	echo "interface ethernet $sw/".$row['dst_slot']."/".$row['dst_port'];
	echo "<BR>";
	echo "port-name [UPLINK TO CORE -".$row['src_switch']." ".$row['src_slot']."/".$row['src_port']." ]";
	echo "<BR>";
	echo "route-only";
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
	 echo "<BR>";
	 echo "!";
	 echo "<BR>";
	 echo "!";
	 echo "<BR>";

	}

 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "crypto key generate";
 echo "<BR>";
 echo "ip ssh  authentication-retries 5";
 echo "<BR>";
 echo "ip ssh  timeout 100";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "end";
 echo "<BR>";
 
 echo "<BR>";
 


 
 

} // function








//*******************************************************************************************************************














?>
