<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ FTR Configuration</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ FTR Information </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> FTR Configuration";

/*
//echo $gotvar;
//    if ($gotvar=='sum')  summary();
//    if ($gotvar=='full')  full();

$bld_old=$_POST['bld_old'];
$bld=$_POST['bld']; 
$floor=$_POST['floor']; 
$old_name=$_POST['old_name'];



*/

$ftr_id=$_GET['ftr_id'];


getinfo($ftr_id);


 


function getinfo($ftr_id){
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
     $sql="select ftr_id,new_name,bld_newname , passive_ports, active_ports, 48p, 24p, 2x10g, 10g, 1g, psu, ";
     $sql=$sql."sfpmm , sfpsm, xfpmm, xfpsm, installed ";
     $sql=$sql." from ftr where ";
     $sql=$sql."ftr_id='".$ftr_id."'";
     
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    $row=mysql_fetch_assoc($result);
    
    if ($row['bld_newname']=='E2') {
    	echo "<BR> FTRs without MTR class <BR>";
    	build_ftr3($ftr_id,$row['new_name'], $row['bld_newname'],$row['48p'],$row['24p']);
    
    }
    
 	else {
 
		if ( substr($row['bld_newname'],0,1)=='A') {
				if ($row['24p']>0) p24($ftr_id,$row['new_name'], $row['bld_newname']);
				else p48($ftr_id,$row['new_name'], $row['bld_newname']);
		}

		if ( substr($row['bld_newname'],0,1)=='E') {
			build_ftr2($ftr_id,$row['new_name'], $row['bld_newname'],$row['48p'],$row['24p']);
		}
	
	
		if ( substr($row['bld_newname'],0,1)=='C') {
			build_ftr2($ftr_id,$row['new_name'], $row['bld_newname'],$row['48p'],$row['24p']);
		}
		if ( substr($row['bld_newname'],0,1)=='D') {
			build_ftr2_D($ftr_id,$row['new_name'], $row['bld_newname'],$row['48p'],$row['24p']);
		}

	
	}//else	
	
}


function p48($ftr_id,$new_name,$bld_newname){
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
     $sql= "select ip from bld_ip where bld='".$bld_newname."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$ip=$row['ip'];
	$ip2nd=substr($ip,3,3);
	

     $sql= "select src_switch, src_ip from portmapping where src_type='FTR' and src_bld='".$bld_newname."' and src_roomid='".$ftr_id."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$src_ip=$row['src_ip'];
	
	
	$b=substr($src_ip,strrpos($src_ip,".")+1,2);
	if (substr($b,1,1)=='/') $c=substr($b,0,1);
	else $c=substr($b,0,2);
	
	if ($c==2)  $p=1;
	if ($c==6)  $p=2;
	if ($c==10) $p=3;
	if ($c==14) $p=4;
	if ($c==18) $p=5;
	if ($c==22) $p=6;
	if ($c==26) $p=7;
	if ($c==30) $p=8;
	if ($c==34) $p=9;
	if ($c==38) $p=10;
	if ($c==42) $p=11;
	if ($c==46) $p=12;

echo "<BR><font size=48 color=NAVY>Building:".$bld_newname."  FTR ".$new_name."</font></p>";

 
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
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 1 name DEFAULT-VLAN by port";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 10 name WIRELESS-AP by port";
echo "<BR>";
 echo "untagged ethe 1/1/5 to 1/1/12 ";
 echo "<BR>";
 echo "router-interface ve 10";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 20 name DATA by port";
echo "<BR>";
 echo "tagged ethe 1/1/13 to 1/1/46 ";
 echo "<BR>";
 echo "router-interface ve 20";
 echo "<BR>";
 echo "multicast passive";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 40 name SERVICES by port";
echo "<BR>";
 echo "untagged ethe 1/1/47 to 1/1/48 ";
 echo "<BR>";
 echo "router-interface ve 40";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 50 name VOIP by port";
echo "<BR>";
 echo "tagged ethe 1/1/13 to 1/1/46 ";
 echo "<BR>";
 echo "router-interface ve 50";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "boot sys fl sec";
echo "<BR>";
echo "enable super-user-password 8 $1$ea3..Kr.$dK7V1CJ3VS2VWbONmAbgU1";
echo "<BR>";
echo "hostname SW1-".$bld_newname."-FTR-";
echo $new_name;
echo "<BR>";
echo "<BR>";
echo "<BR>";
/*
echo "ip dhcp-server enable";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool data-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."2.1 ";
 echo "<BR>";
 echo "dns-server 4.2.2.4 195.229.166.251 4.2.2.2 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."2.1  10.".$ip2nd.".".$p."2.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."2.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool voip-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."5.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."5.1 10.".$ip2nd.".".$p."5.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."5.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool wireless_ap-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."1.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."1.1 10.".$ip2nd.".".$p."1.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."1.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";

echo "!";
echo "<BR>";
echo "ip dhcp-server pool services-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."4.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."4.1 10.".$ip2nd.".".$p."4.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."4.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";

*/

echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.".$p;
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
echo "username admin password 8 $1$p/...Xm/$MX6U.I4poEQ8NfL8Lha.x1";
echo "<BR>";
echo "cdp run";
echo "<BR>";
echo "fdp run";
echo "<BR>";
echo "snmp-server community 1 $lZwZk0Q| ro";
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
echo "port bootp";
echo "<BR>";
echo "bootp-relay-max-hops 10";
echo "<BR>";
echo "router ospf";
echo "<BR>";
 echo "area 10.".$ip2nd.".0.0 stub 1 no-summary";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".99.".$p."  255.255.255.255";
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
echo "interface ethernet 1/1/1";
echo "<BR>";
 echo "port-name [4 TRUNK UPLINKS TO SW1-".$bld_newname."-MTR-0016]";
 echo "<BR>";
 echo "route-only";
 echo "<BR>";
 echo "ip address  ".$src_ip;
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
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
 echo "link-aggregate configure key 10000";
 echo "<BR>";
 echo "link-aggregate active";
 echo "<BR>";
 echo "trust dscp ";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/2";
echo "<BR>";
 echo "link-aggregate configure key 10000";
 echo "<BR>";
 echo "link-aggregate active";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/3";
echo "<BR>";
 echo "link-aggregate configure key 10000";
 echo "<BR>";
 echo "link-aggregate active";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/4";
echo "<BR>";
 echo "link-aggregate configure key 10000";
 echo "<BR>";
 echo "link-aggregate active";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/5";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/6";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/7";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/8";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/9";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/10";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/11";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/12";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(20)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/13";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/14";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/15";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/16";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/17";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/18";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/19";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/20";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/21";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/22";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/23";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/24";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/25";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/26";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/27";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/28";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/29";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/30";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/31";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/32";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/33";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/34";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/35";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/36";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/37";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/38";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/39";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/40";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/41";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/42";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/43";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/44";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/45";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/46";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "voice-vlan 50";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/47";
echo "<BR>";
 echo "port-name [SERVICES-VLAN(30)]";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/48";
echo "<BR>";
 echo "port-name [SERVICES-VLAN(30)]";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 10";
echo "<BR>";
 echo "port-name [IP interface WIRELESS-AP  Vlan 10]";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."1.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.111.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 20";
echo "<BR>";
 echo "port-name [IP interface DATA  Vlan 20]";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."2.1 255.255.254.0";
 echo "<BR>";
 echo "ip ospf area 10.111.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 40";
 echo "port-name [IP interface SERVICES  Vlan 40]";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."4.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.111.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 50";
echo "<BR>";
 echo "port-name [IP interface VOIP  Vlan 50]";
 echo "<BR>";
 echo "ip access-group VOIP-MARKING in ";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."5.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
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






}





function p24($ftr_id,$new_name,$bld_newname){
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
     $sql= "select ip from bld_ip where bld='".$bld_newname."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$ip=$row['ip'];
	$ip2nd=substr($ip,3,3);
	

     $sql= "select src_switch, src_ip from portmapping where src_type='FTR' and src_bld='".$bld_newname."' and src_roomid='".$ftr_id."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$src_ip=$row['src_ip'];
	
	
	$b=substr($src_ip,strrpos($src_ip,".")+1,2);
	if (substr($b,1,1)=='/') $c=substr($b,0,1);
	else $c=substr($b,0,2);
	
	if ($c==2)  $p=1;
	if ($c==6)  $p=2;
	if ($c==10) $p=3;
	if ($c==14) $p=4;
	if ($c==18) $p=5;
	if ($c==22) $p=6;
	if ($c==26) $p=7;
	if ($c==30) $p=8;
	if ($c==34) $p=9;
	if ($c==38) $p=10;
	if ($c==42) $p=11;
	if ($c==46) $p=12;

echo "<BR><font size=48 color=NAVY>Building:".$bld_newname."  FTR ".$new_name."</font></p>";

 
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
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 1 name DEFAULT-VLAN by port";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 10 name WIRELESS-AP by port";
echo "<BR>";
 echo "untagged ethe 1/1/3 to 1/1/8 ";
 echo "<BR>";
 echo "router-interface ve 10";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 20 name DATA by port";
echo "<BR>";
 echo "tagged ethe 1/1/9 to 1/1/23 ";
 echo "<BR>";
 echo "router-interface ve 20";
 echo "<BR>";
 echo "multicast passive";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 40 name SERVICES by port";
echo "<BR>";
 echo "untagged ethe 1/1/23 to 1/1/24 ";
 echo "<BR>";
 echo "router-interface ve 40";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 50 name VOIP by port";
echo "<BR>";
 echo "tagged ethe 1/1/9 to 1/1/23 ";
 echo "<BR>";
 echo "router-interface ve 50";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "boot sys fl sec";
echo "<BR>";
echo "enable acl-per-port-per-vlan";
echo "<BR>";
echo "enable super-user-password 8 $1$ea3..Kr.$dK7V1CJ3VS2VWbONmAbgU1";
echo "<BR>";
echo "hostname SW1-A1-FTR-";
echo $new_name;
echo "<BR>";
echo "<BR>";
echo "<BR>";
echo "ip dhcp-server enable";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool data-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."2.1 ";
 echo "<BR>";
 echo "dns-server 4.2.2.4 195.229.166.251 4.2.2.2 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."2.1  10.".$ip2nd.".".$p."2.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."2.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool voip-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."5.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."5.1 10.".$ip2nd.".".$p."5.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."5.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool wireless_ap-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."1.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."1.1 10.".$ip2nd.".".$p."1.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."1.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";

echo "!";
echo "<BR>";
echo "ip dhcp-server pool services-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."4.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."4.1 10.".$ip2nd.".".$p."4.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."4.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";



echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.".$p;
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
echo "username admin password 8 $1$p/...Xm/$MX6U.I4poEQ8NfL8Lha.x1";
echo "<BR>";
echo "cdp run";
echo "<BR>";
echo "fdp run";
echo "<BR>";
echo "snmp-server community 1 $lZwZk0Q| ro";
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
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".99.".$p."  255.255.255.255";
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
echo "interface ethernet 1/1/1";
echo "<BR>";
 echo "port-name [2 TRUNK UPLINKS TO SW1-".$bld_newname."-MTR-0016]";
 echo "<BR>";
 echo "route-only";
 echo "<BR>";
 echo "ip address  ".$src_ip;
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
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
 echo "link-aggregate configure key 10000";
 echo "<BR>";
 echo "link-aggregate active";
 echo "<BR>";
 echo "trust dscp ";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/2";
echo "<BR>";
 echo "link-aggregate configure key 10000";
 echo "<BR>";
 echo "link-aggregate active";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/3";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(10)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/4";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(10)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/5";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(10)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/6";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(10)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/7";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(10)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/8";
echo "<BR>";
 echo "port-name [WIRELESS-AP-VLAN(10)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/9";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/10";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/11";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/12";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/13";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/14";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/15";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/16";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/17";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/18";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/19";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/20";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/21";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/22";
echo "<BR>";
 echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/23";
echo "<BR>";
 echo "port-name [SERVICES-VLAN(40)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/24";
echo "<BR>";
 echo "port-name [SERVICES-VLAN(40)]";
 echo "<BR>";
 echo "dual-mode  20";
 echo "<BR>";
 echo "inline power";
 echo "<BR>";
echo "!";

echo "!";
echo "<BR>";
echo "interface ve 10";
echo "<BR>";
 echo "port-name [IP interface WIRELESS-AP  Vlan 10]";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."1.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.111.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 20";
echo "<BR>";
 echo "port-name [IP interface DATA  Vlan 20]";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."2.1 255.255.254.0";
 echo "<BR>";
 echo "ip ospf area 10.111.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 40";
echo "<BR>";
 echo "port-name [IP interface SERVICES  Vlan 40]";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."4.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.111.0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 50";
echo "<BR>";
 echo "port-name [IP interface VOIP  Vlan 50]";
 echo "<BR>";
 echo "ip access-group VOIP-MARKING in ";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."5.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
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






}




function	build_ftr2($ftr_id,$new_name,$bld,$v48p,$v24p) {


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

     $sql= "select src_switch, src_ip from portmapping where src_type='FTR' and src_bld='".$bld."' and src_roomid='".$ftr_id."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$src_ip=$row['src_ip'];



	$sql=" select @rownum:=@rownum+1 as row, src_roomid as src from ( select src_roomid from portmapping  ";
	$sql=$sql." where src_type='FTR' and dst_bld='".$bld."'  group by src_roomid order by src_roomid) e,  (SELECT @rownum:=0) r" ;
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

echo "</font></font><p>";
echo "<BR> Our FTR ID is : $ftr_id";	
$ftr_row=0;
	while ($row=mysql_fetch_assoc($result)) {
		echo "<BR> Internal calc : FTR_ID: ".$row['src'] . "  ROW: ".$row['row'];
		if ($row['src']==$ftr_id) $ftr_row=$row['row'];
		}// while
$p=$ftr_row;
echo "<BR> Internal calc : P is $p";
	
	/*$b=substr($src_ip,strrpos($src_ip,".")+1,2);
	if (substr($b,1,1)=='/') $c=substr($b,0,1);
	else $c=substr($b,0,2);
	
	if ($c==2)  $p=1;
	if ($c==6)  $p=2;
	if ($c==10) $p=3;
	if ($c==14) $p=4;
	if ($c==18) $p=5;
	if ($c==22) $p=6;
	if ($c==26) $p=7;
	if ($c==30) $p=8;
	if ($c==34) $p=9;
	if ($c==38) $p=10;
	if ($c==42) $p=11;
	if ($c==46) $p=12;

*/


echo "<BR><font size=48 color=NAVY>Building: $bld  FTR $new_name  <BR>48Port switch: $v48p  , 24Port switch: $v24p</font></p>";

 
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
echo "ip load-sharing 8";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 1 name DEFAULT-VLAN by port";
echo "<BR>";
echo "!";
echo "<BR>";

//*******************PORT - VLAN Assignment*********************
echo "vlan 10 name WIRELESS-AP by port";
echo "<BR>";

// FTR_ID=128 is FTR 2059 of C6 which is connecting with 1G fiber not 10G
if ($ftr_id==128) {
	echo "untagged ethe 1/1/5 to 1/1/10 ";
	echo "<BR>";
}
else {
	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "untagged ethe $i/1/1 to $i/1/8 ";
			 echo "<BR>";
			 }
		else {
			echo "untagged ethe $i/1/1 to $i/1/8 ";
			echo "<BR>";
			}
	}// for
}//else

echo "router-interface ve 10";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 20 name DATA by port";
echo "<BR>";

// FTR_ID=128 is FTR 2059 of C6 which is connecting with 1G fiber not 10G
if ($ftr_id==128) {
	echo "tagged ethe 1/1/11 to 1/1/22 ";
	echo "<BR>";
}
else {
	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "tagged ethe $i/1/9 to $i/1/22 ";
			 echo "<BR>";
			 }
		else {
			echo "tagged ethe $i/1/9 to $i/1/46 ";
			echo "<BR>";
		}

	}// for
}//else
 echo "router-interface ve 20";
 echo "<BR>";
 echo "multicast passive";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 40 name SERVICES by port";
echo "<BR>";

// FTR_ID=128 is FTR 2059 of C6 which is connecting with 1G fiber not 10G
if ($ftr_id==128) {
	echo "untagged ethe 1/1/23 to 1/1/24 ";
	echo "<BR>";
}
else {
	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "untagged ethe $i/1/23 to $i/1/24 ";
			 echo "<BR>";
			 }
		else {
			 echo "untagged ethe $i/1/47 to $i/1/48 ";
			 echo "<BR>";
			}
	}// for
}//else
 
 echo "router-interface ve 40";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 50 name VOIP by port";
echo "<BR>";
// FTR_ID=128 is FTR 2059 of C6 which is connecting with 1G fiber not 10G
if ($ftr_id==128) {
	echo "tagged ethe 1/1/11 to 1/1/22 ";
	echo "<BR>";
}
else {
	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "tagged ethe $i/1/9 to $i/1/22 ";
			 echo "<BR>";
			 }
		else {
			echo "tagged ethe $i/1/9 to $i/1/46 ";
			echo "<BR>";
			}
	}// for
}//else

 echo "router-interface ve 50";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "boot sys fl sec";
echo "<BR>";
//echo "enable acl-per-port-per-vlan";
echo "<BR>";
echo "enable super-user-password Gr8Vision";
echo "<BR>";
echo "hostname SW1-$bld-FTR-";
echo $new_name;
echo "<BR>";
echo "<BR>";
echo "<BR>";
/*
echo "ip dhcp-server enable";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool data-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."2.1 ";
 echo "<BR>";
 echo "dns-server 4.2.2.4 195.229.166.251 4.2.2.2 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."2.1  10.".$ip2nd.".".$p."2.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."2.0 255.255.254.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool voip-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."5.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."5.1 10.".$ip2nd.".".$p."5.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."5.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool wireless_ap-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."1.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."1.1 10.".$ip2nd.".".$p."1.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."1.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";

echo "!";
echo "<BR>";
echo "ip dhcp-server pool services-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."4.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."4.1 10.".$ip2nd.".".$p."4.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."4.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";

*/

echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.".$p;
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
echo "port bootp";
echo "<BR>";
echo "bootp-relay-max-hops 10";
echo "<BR>";

echo "router ospf";
echo "<BR>";
 echo "area 10.".$ip2nd.".0.0 stub 1 no-summary";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".99.".$p."  255.255.255.255";
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





//****************************UPLINK TO CORE  FOR SPECIFIC SMALL FTRS  ***********************************************
if ($ftr_id==204) {
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
     $sql="select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port , dst_ip ";
     $sql=$sql." from portmapping where ";
     $sql=$sql."dst_roomid='".$ftr_id."' and dst_type='FTR'";
     
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
    
    	$sw=substr($row['src_switch'],2,1);
    	
		echo "interface ethernet ".$sw."/".$row['src_slot']."/".$row['src_port'];
		echo "<BR>";
		echo "port-name [UPLINK TO CORE -".$row['dst_switch']."    Port:".$row['dst_slot']."/".$row['dst_port']." ]";
		echo "<BR>";
		echo "ip address  ".$row['src_ip'];
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
		 echo "!";
		 echo "<BR>";
		 echo "!";
		 echo "<BR>";
	
		}// while uplinks
	
} // End IF



//****************************UPLINK TO MTR***********************************************
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
     $sql="select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port , dst_ip ";
     $sql=$sql." from portmapping where ";
     $sql=$sql."src_roomid='".$ftr_id."' and dst_type='MTR'";
     
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
    
    	$sw=substr($row['src_switch'],2,1);
    	
		echo "interface ethernet ".$sw."/".$row['src_slot']."/".$row['src_port'];
		echo "<BR>";
		echo "port-name [UPLINK TO MTR -".$row['dst_switch']."    Port:".$row['dst_slot']."/".$row['dst_port']." ]";
		echo "<BR>";
		echo "ip address  ".$row['src_ip'];
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
		 echo "!";
		 echo "<BR>";
		 echo "!";
		 echo "<BR>";
	
		}// while uplinks
		

//Building End points  VLAN 10 WIRELESS APs    

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	
	for ($j=1; $j<=8; $j++) {
		echo "interface ethernet $i/1/$j";
		echo "<BR>";
		echo "port-name [WIRELESS-AP-VLAN(10)]";
		echo "<BR>";
		echo "inline power priority 1 power-by-class 4";
		echo "<BR>";
		echo "!";
		echo "<BR>";

		}// For J
}// For i


//Building End points  DATA-VLAN(20)_VOICE-VLAN(50)    

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
//echo "<BR> BOOOB v48p: $v48p v24p:$v24p<BR>";
	if ($i>$v48p and $v24p>0 and $i<=$v48p+$v24p) {
//	echo "<BR> BOOOB Inside the 24 Port v48p: $v48p v24p:$v24p<BR>";
		
		for ($j=9; $j<=22; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
			echo "<BR>";
			echo "dual-mode  20";
			echo "<BR>";
			echo "voice-vlan 50";
			echo "<BR>";
			echo "inline power";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		 }// if
	else {	 
		
		for ($j=9; $j<=46; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
			echo "<BR>";
			echo "dual-mode  20";
			echo "<BR>";
			echo "voice-vlan 50";
			echo "<BR>";
			echo "inline power";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		} // else
}// For i





//Building End points [SERVICES-VLAN(40)]

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	if ($i>$v48p and $v24p>0 and $i<=$v48p+$v24p) {
		
		for ($j=23; $j<=24; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [SERVICES-VLAN(40)]";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		 }// if
	else {	 
		
		for ($j=47; $j<=48; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [SERVICES-VLAN(40)]";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		} // else
}// For i
    



    
 
 
 echo "<BR>";
 echo "interface ve 10";
 echo "<BR>";
  echo "port-name [IP interface WIRELESS-AP  Vlan 10]";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."1.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 20";
 echo "<BR>";
  echo "port-name [IP interface DATA  Vlan 20]";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."2.1 255.255.254.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 40";
  echo "<BR>";
  echo "port-name [IP interface SERVICES  Vlan 40]";
 echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."4.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 50";
 echo "<BR>";
  echo "port-name [IP interface VOIP  Vlan 50]";
  echo "<BR>";
  echo "ip access-group VOIP-MARKING in ";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."5.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.".$ip2nd.".0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
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
   echo "permit ip any any ";
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
 


} // function








//*******************************************************************************************************************


function	build_ftr3($ftr_id,$new_name,$bld,$v48p,$v24p) {


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

     $sql= "select dst_switch, dst_ip from portmapping where dst_type='FTR' and dst_bld='".$bld."' and dst_roomid='".$ftr_id."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$src_ip=$row['dst_ip'];

	
	echo "</font></font><p>";
//	echo "<BR> SQL $sql<BR>";

//	echo "<BR> SRC IP is  $src_ip<BR>";

	$sql=" select @rownum:=@rownum+1 as row, dst_roomid as dst from ( select dst_roomid from portmapping  ";
	$sql=$sql." where dst_type='FTR' and dst_bld='".$bld."'  group by dst_roomid order by dst_roomid) e,  (SELECT @rownum:=0) r" ;
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

echo "</font></font><p>";
echo "<BR> Our FTR ID is : $ftr_id";	
$ftr_row=0;
	while ($row=mysql_fetch_assoc($result)) {
		echo "<BR> Internal calc : FTR_ID: ".$row['dst'] . "  ROW: ".$row['row'];
		if ($row['dst']==$ftr_id) $ftr_row=$row['row'];
		}// while
$p=$ftr_row;
echo "<BR> Internal calc : P is $p";
	
	/*$b=substr($src_ip,strrpos($src_ip,".")+1,2);
	if (substr($b,1,1)=='/') $c=substr($b,0,1);
	else $c=substr($b,0,2);
	
	if ($c==2)  $p=1;
	if ($c==6)  $p=2;
	if ($c==10) $p=3;
	if ($c==14) $p=4;
	if ($c==18) $p=5;
	if ($c==22) $p=6;
	if ($c==26) $p=7;
	if ($c==30) $p=8;
	if ($c==34) $p=9;
	if ($c==38) $p=10;
	if ($c==42) $p=11;
	if ($c==46) $p=12;

*/


echo "<BR><font size=48 color=NAVY>Building: $bld  FTR $new_name  <BR>48Port switch: $v48p  , 24Port switch: $v24p</font></p>";

 
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
echo "ip load-sharing 8";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 1 name DEFAULT-VLAN by port";
echo "<BR>";
echo "!";
echo "<BR>";

//*******************PORT - VLAN Assignment*********************
echo "vlan 10 name WIRELESS-AP by port";
echo "<BR>";
$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	if ($i>$v48p and $v24p>0) {
		 echo "untagged ethe $i/1/1 to $i/1/8 ";
		 echo "<BR>";
		 }
	else {
		echo "untagged ethe $i/1/1 to $i/1/8 ";
		echo "<BR>";
		}
}// for


echo "router-interface ve 10";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 20 name DATA by port";
echo "<BR>";

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	if ($i>$v48p and $v24p>0) {
		 echo "tagged ethe $i/1/9 to $i/1/22 ";
		 echo "<BR>";
		 }
	else {
		echo "tagged ethe $i/1/9 to $i/1/46 ";
		echo "<BR>";
	}
	
}// for

 echo "router-interface ve 20";
 echo "<BR>";
 echo "multicast passive";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 40 name SERVICES by port";
echo "<BR>";

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	if ($i>$v48p and $v24p>0) {
		 echo "untagged ethe $i/1/23 to $i/1/24 ";
		 echo "<BR>";
		 }
	else {
		 echo "untagged ethe $i/1/47 to $i/1/48 ";
		 echo "<BR>";
		}
}// for

 
 echo "router-interface ve 40";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 50 name VOIP by port";
echo "<BR>";

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	if ($i>$v48p and $v24p>0) {
		 echo "tagged ethe $i/1/9 to $i/1/22 ";
		 echo "<BR>";
		 }
	else {
		echo "tagged ethe $i/1/9 to $i/1/46 ";
		echo "<BR>";
		}
}// for

 echo "router-interface ve 50";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "boot sys fl sec";
echo "<BR>";
//echo "enable acl-per-port-per-vlan";
echo "<BR>";
echo "enable super-user-password Gr8Vision";
echo "<BR>";
echo "hostname SW1-$bld-FTR-";
echo $new_name;
echo "<BR>";
echo "<BR>";
echo "<BR>";
echo "ip dhcp-server enable";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool data-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."2.1 ";
 echo "<BR>";
 echo "dns-server 4.2.2.4 195.229.166.251 4.2.2.2 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."2.1  10.".$ip2nd.".".$p."2.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."2.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool voip-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."5.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."5.1 10.".$ip2nd.".".$p."5.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."5.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server pool wireless_ap-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."1.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."1.1 10.".$ip2nd.".".$p."1.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."1.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";

echo "!";
echo "<BR>";
echo "ip dhcp-server pool services-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."4.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51 4.2.2.4 ";
 echo "<BR>";
 echo "domain-name .ac.ae";
 echo "<BR>";
 echo "excluded-address 10.".$ip2nd.".".$p."4.1 10.".$ip2nd.".".$p."4.9";
 echo "<BR>";
 echo "lease 1 0 0";
 echo "<BR>";
  echo "network 10.".$ip2nd.".".$p."4.0 255.255.255.0";
  echo "<BR>";
 echo "deploy";
 echo "<BR>";
echo "!";



echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.".$p;
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
echo "port bootp";
echo "<BR>";
echo "router ospf";
echo "<BR>";
 echo "area 10.".$ip2nd.".0.0 stub 1 no-summary";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".99.".$p."  255.255.255.255";
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





//****************************UPLINK TO CORE  FOR SPECIFIC SMALL FTRS  ***********************************************
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
     $sql="select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port , dst_ip ";
     $sql=$sql." from portmapping where ";
     $sql=$sql."dst_roomid='".$ftr_id."' and dst_type='FTR'";
     
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
    
    	$sw=substr($row['dst_switch'],2,1);
    	
		echo "interface ethernet ".$sw."/".$row['dst_slot']."/".$row['dst_port'];
		echo "<BR>";
		echo "port-name [UPLINK TO CORE ".$row['src_switch']."    Port:".$row['src_slot']."/".$row['src_port']." ]";
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
		 echo "!";
		 echo "<BR>";
		 echo "!";
		 echo "<BR>";
	
		}// while uplinks
	




		

//Building End points  VLAN 10 WIRELESS APs    

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	
	for ($j=1; $j<=8; $j++) {
		echo "interface ethernet $i/1/$j";
		echo "<BR>";
		echo "port-name [WIRELESS-AP-VLAN(10)]";
		echo "<BR>";
		echo "inline power priority 1 power-by-class 4";
		echo "<BR>";
		echo "!";
		echo "<BR>";

		}// For J
}// For i


//Building End points  DATA-VLAN(20)_VOICE-VLAN(50)    

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
//echo "<BR> BOOOB v48p: $v48p v24p:$v24p<BR>";
	if ($i>$v48p and $v24p>0 and $i<=$v48p+$v24p) {
//	echo "<BR> BOOOB Inside the 24 Port v48p: $v48p v24p:$v24p<BR>";
		
		for ($j=9; $j<=22; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
			echo "<BR>";
			echo "dual-mode  20";
			echo "<BR>";
			echo "voice-vlan 50";
			echo "<BR>";
			echo "inline power";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		 }// if
	else {	 
		
		for ($j=9; $j<=46; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
			echo "<BR>";
			echo "dual-mode  20";
			echo "<BR>";
			echo "voice-vlan 50";
			echo "<BR>";
			echo "inline power";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		} // else
}// For i





//Building End points [SERVICES-VLAN(40)]

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	if ($i>$v48p and $v24p>0 and $i<=$v48p+$v24p) {
		
		for ($j=23; $j<=24; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [SERVICES-VLAN(40)]";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		 }// if
	else {	 
		
		for ($j=47; $j<=48; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [SERVICES-VLAN(40)]";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		} // else
}// For i
    



    
 
 
 echo "<BR>";
 echo "interface ve 10";
 echo "<BR>";
  echo "port-name [IP interface WIRELESS-AP  Vlan 10]";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."1.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 20";
 echo "<BR>";
  echo "port-name [IP interface DATA  Vlan 20]";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."2.1 255.255.254.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 40";
  echo "port-name [IP interface SERVICES  Vlan 40]";
 echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."4.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 50";
 echo "<BR>";
  echo "port-name [IP interface VOIP  Vlan 50]";
  echo "<BR>";
  echo "ip access-group VOIP-MARKING in ";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."5.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.".$ip2nd.".0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";
  
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
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
  echo "permit ip any any";
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
 


} // function


//********************************************************************************************************************


//**********************************************************************************************************************

function	build_ftr2_D($ftr_id,$new_name,$bld,$v48p,$v24p) {


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

     $sql= "select src_switch, src_ip from portmapping where src_type='FTR' and src_bld='".$bld."' and src_roomid='".$ftr_id."'";
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result);
	$src_ip=$row['src_ip'];



	$sql=" select @rownum:=@rownum+1 as row, src_roomid as src from ( select src_roomid from portmapping  ";
	$sql=$sql." where src_type='FTR' and dst_bld='".$bld."'  group by src_roomid order by src_roomid) e,  (SELECT @rownum:=0) r" ;
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

echo "</font></font><p>";
echo "<BR> Our FTR ID is : $ftr_id";	
$ftr_row=0;
	while ($row=mysql_fetch_assoc($result)) {
		echo "<BR> Internal calc : FTR_ID: ".$row['src'] . "  ROW: ".$row['row'];
		if ($row['src']==$ftr_id) $ftr_row=$row['row'];
		}// while
$p=$ftr_row;
echo "<BR> Internal calc : P is $p";



echo "<BR><font size=48 color=NAVY>Building: $bld  FTR $new_name  <BR>48Port switch: $v48p  , 24Port switch: $v24p</font></p>";

 
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
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 1 name DEFAULT-VLAN by port";
echo "<BR>";
echo "!";
echo "<BR>";

//*******************PORT - VLAN Assignment*********************
echo "vlan 10 name WIRELESS-AP by port";
echo "<BR>";

	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "untagged ethe $i/1/5 to $i/1/10 ";
			 echo "<BR>";
			 }
		else {
			echo "untagged ethe $i/1/5 to $i/1/10 ";
			echo "<BR>";
			}
	}// for

echo "router-interface ve 10";
echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 20 name DATA by port";
echo "<BR>";

	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "tagged ethe $i/1/11 to $i/1/22 ";
			 echo "<BR>";
			 }
		else {
			echo "tagged ethe $i/1/11 to $i/1/46 ";
			echo "<BR>";
		}

	}// for

 echo "router-interface ve 20";
 echo "<BR>";
 echo "multicast passive";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 40 name SERVICES by port";
echo "<BR>";

	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "untagged ethe $i/1/23 to $i/1/24 ";
			 echo "<BR>";
			 }
		else {
			 echo "untagged ethe $i/1/47 to $i/1/48 ";
			 echo "<BR>";
			}
	}// for
 
 echo "router-interface ve 40";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "vlan 50 name VOIP by port";
echo "<BR>";

	$i=1;
	for ($i=1; $i<=$v48p+$v24p; $i++) {
		if ($i>$v48p and $v24p>0) {
			 echo "tagged ethe $i/1/11 to $i/1/22 ";
			 echo "<BR>";
			 }
		else {
			echo "tagged ethe $i/1/11 to $i/1/46 ";
			echo "<BR>";
			}
	}// for


 echo "router-interface ve 50";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";

echo "!";
echo "<BR>";
echo "vlan 60 name IP-TV by port";
echo "<BR>";
 echo "router-interface ve 60";
 echo "<BR>";
echo "!";



echo "<BR>";
echo "aaa authentication login default local";
echo "<BR>";
echo "boot sys fl sec";
echo "<BR>";
echo "<BR>";
echo "enable super-user-password Gr8Vision";
echo "<BR>";
echo "hostname SW1-$bld-FTR-";
echo $new_name;
echo "<BR>";
echo "<BR>";
echo "<BR>";


echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.".$p;
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
echo "port bootp";
echo "<BR>";
echo "bootp-relay-max-hops 10";
echo "<BR>";

echo "router ospf";
echo "<BR>";
 echo "area 10.".$ip2nd.".0.0 stub 1 no-summary";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "router pim";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface loopback 1";
$loopback_ip="10.".$ip2nd.".99.".$p;

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
     $sql= "update ftr set lo='".$loopback_ip."' where ftr_id=".$ftr_id;
     	 $result = mysql_query($sql)
	   or die(mysql_error());	
//	echo "<BR>";
//	echo "<BR>";
//	echo $sql;
//echo "<BR>";



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




//****************************UPLINK TO MTR***********************************************
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
/*     $sql="select src_switch, src_slot, src_port, src_ip, dst_switch, dst_slot, dst_port , dst_ip ";
     $sql=$sql." from portmapping where ";
     $sql=$sql."src_roomid='".$ftr_id."' and dst_type='MTR'";
 */

	$sql="select src_roomid,src_ip,count(*) from portmapping where src_roomid='".$ftr_id."' group by 1,2 order by 2";
 //   echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	
	$key=10000;
	   
    while ($row=mysql_fetch_assoc($result)) {
		$key=$key+1000;
		$flag=1;
		
		$sql="select src_switch,src_slot,src_port,dst_switch,dst_slot,dst_port	from portmapping where src_ip='".$row['src_ip']."' order by 1,2,3 ";
//		echo "<R> $sql<BR>";	
		 $result2 = mysql_query($sql)
		   or die(mysql_error());	
    	
		while ($row2=mysql_fetch_assoc($result2)) {
		
			if ($flag==1) {
					$sw=substr($row2['src_switch'],2,1);
					echo "interface ethernet ".$sw."/".$row2['src_slot']."/".$row2['src_port'];
					echo "<BR>";
					echo "port-name [UPLINK TO MTR -".$row2['dst_switch']."    Port:".$row2['dst_slot']."/".$row2['dst_port']." ]";
					echo "<BR>";
					echo "route-only";
					echo "<BR>";
					echo "ip address  ".$row['src_ip'];
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
					/*echo "link-aggregate configure key $key";
					echo "<BR>";
					echo "link-aggregate active";
					echo "<BR>";
					*/
					echo "!";
					echo "<BR>";
							
					//$flag=0;
				}	
				else {
					$sw=substr($row2['src_switch'],2,1);
					echo "interface ethernet ".$sw."/".$row2['src_slot']."/".$row2['src_port'];
					echo "<BR>";
					echo "port-name [UPLINK TO MTR -".$row2['dst_switch']."    Port:".$row2['dst_slot']."/".$row2['dst_port']." ]";
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
		

//Building End points  VLAN 10 WIRELESS APs    

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	
	for ($j=5; $j<=10; $j++) {
		echo "interface ethernet $i/1/$j";
		echo "<BR>";
		echo "port-name [WIRELESS-AP-VLAN(10)]";
		echo "<BR>";
		echo "inline power priority 1 power-by-class 4";
		echo "<BR>";
		echo "!";
		echo "<BR>";

		}// For J
}// For i


//Building End points  DATA-VLAN(20)_VOICE-VLAN(50)    

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
//echo "<BR> BOOOB v48p: $v48p v24p:$v24p<BR>";
	if ($i>$v48p and $v24p>0 and $i<=$v48p+$v24p) {
//	echo "<BR> BOOOB Inside the 24 Port v48p: $v48p v24p:$v24p<BR>";
		
		for ($j=11; $j<=22; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
			echo "<BR>";
			echo "dual-mode  20";
			echo "<BR>";
			echo "voice-vlan 50";
			echo "<BR>";
			echo "inline power";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		 }// if
	else {	 
		
		for ($j=11; $j<=46; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [DATA-VLAN(20)_VOICE-VLAN(50)]";
			echo "<BR>";
			echo "dual-mode  20";
			echo "<BR>";
			echo "voice-vlan 50";
			echo "<BR>";
			echo "inline power";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		} // else
}// For i





//Building End points [SERVICES-VLAN(40)]

$i=1;
for ($i=1; $i<=$v48p+$v24p; $i++) {
	if ($i>$v48p and $v24p>0 and $i<=$v48p+$v24p) {
		
		for ($j=23; $j<=24; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [SERVICES-VLAN(40)]";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		 }// if
	else {	 
		
		for ($j=47; $j<=48; $j++) {
			echo "interface ethernet $i/1/$j";
			echo "<BR>";
			echo "port-name [SERVICES-VLAN(40)]";
			echo "<BR>";
			echo "!";
			echo "<BR>";
			}// For J
		} // else
}// For i
    



    
 
 
 echo "<BR>";
 echo "interface ve 10";
 echo "<BR>";
  echo "port-name [IP interface WIRELESS-AP  Vlan 10]";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."1.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 20";
 echo "<BR>";
  echo "port-name [IP interface DATA  Vlan 20]";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."2.1 255.255.254.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 40";
  echo "<BR>";
  echo "port-name [IP interface SERVICES  Vlan 40]";
 echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."4.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.$ip2nd.0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 echo "!";
 echo "<BR>";
 echo "interface ve 50";
 echo "<BR>";
  echo "port-name [IP interface VOIP  Vlan 50]";
  echo "<BR>";
  echo "ip access-group VOIP-MARKING in ";
  echo "<BR>";
  echo "ip address 10.".$ip2nd.".".$p."5.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.".$ip2nd.".0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 
 echo "!";
 echo "<BR>";
 echo "interface ve 60";
 echo "<BR>";
  echo "port-name [IP interface IP-TV  Vlan 60]";
  echo "<BR>";
echo "ip address 10.".$ip2nd.".".$p."6.1 255.255.255.0";
  echo "<BR>";
  echo "ip ospf area 10.".$ip2nd.".0.0";
  echo "<BR>";
  echo "ip helper-address 1 10.90.192.100";
  echo "<BR>";

 
 
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
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
   echo "permit ip any any ";
  echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
 echo "!";
 echo "<BR>";
	echo "ip dhcp snooping vlan 1";
	echo "<BR>";
	echo "ip dhcp snooping vlan 10";
	echo "<BR>";
	echo "ip dhcp snooping vlan 20";
	echo "<BR>";
	echo "ip dhcp snooping vlan 40";
	echo "<BR>";
	echo "ip dhcp snooping vlan 50";

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
