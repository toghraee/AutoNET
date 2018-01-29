<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ A series FTR Changer Configuration</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ A series FTR Changer Configuration </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> A series FTR Changer Configuration";
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
$sql="select ftr_id, new_name, bld_newname";
$sql=$sql." from ftr where ";
$sql=$sql."(bld_newname like 'A%' or bld_newname like 'B%') and bld_newname!='A11' order by 2";

//    echo "<BR> $sql<BR>";	
$result = mysql_query($sql)
or die(mysql_error());	
	
while ($row=mysql_fetch_assoc($result)) {

		$bld=$row['bld_newname'];
		$ftr_id=$row['ftr_id'];
		$new_name=$row['new_name'];
		
		echo "<BR><font color=green size=10> Working on  Building $bld  FTR $new_name  ,  FTR-ID: $ftr_id</font><BR>";
		echo "<BR>";
		echo "<BR>";
		echo "config t";

		//ETC

		echo "<BR>";
		echo "!";
		echo "<BR>";
		echo "ip access-list extended VOIP-MARKING";
		echo "<BR>";
		echo "permit ip any any";
		echo "<BR>";
		echo "exit";
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
		
		
		
		if (strstr($bld,'A' and $new_name=='0046')) {
			echo "int eth 1/1/9 to 1/1/23";
			echo "<BR>";
			echo "voice-vlan 50";
			echo "<BR>";	
		}
		else {
			if (strstr($bld,'B') and ($new_name=='0016A'or $new_name=='0003B'or $new_name=='1008A'or $new_name=='0024'or $new_name=='1008'or $new_name=='0002'or $new_name=='0017B'or $new_name=='0028B'or $new_name=='1001b')) {
				echo "int eth 1/1/9 to 1/1/23";
				echo "<BR>";
				echo "voice-vlan 50";
				echo "<BR>";	
			}	
		
				else {
					echo "int eth 1/1/13 to 1/1/46";
					echo "<BR>";
					echo "voice-vlan 50";
					echo "<BR>";
				}
		}
		
		p24($ftr_id,$new_name,$bld);
		

}// While 








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
     	 $result3 = mysql_query($sql)
	   or die(mysql_error());	

	$row=mysql_fetch_assoc($result3);
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


 

echo "hostname SW1-$bld_newname-FTR-$new_name";
echo "<BR>";
echo "!";
echo "<BR>";
echo "ip dhcp-server enable";
echo "<BR>";
echo "!";
echo "<BR>";
echo "no ip dhcp-server pool data-pool";
echo "<BR>";
echo "no ip dhcp-server pool voip-pool";
echo "<BR>";
echo "no ip dhcp-server pool wireless_ap-pool";
echo "<BR>";
echo "no ip dhcp-server pool services-pool";
echo "<BR>";
echo "!";



echo "<BR>";
echo "ip router-id 10.".$ip2nd.".99.".$p;
echo "<BR>";
echo "no interface loopback 1";
echo "<BR>";
echo "interface loopback 1";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".99.".$p."  255.255.255.255";
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ethernet 1/1/1";
echo "<BR>";
 echo "port-name [2 TRUNK UPLINKS TO SW1-".$bld_newname."-MTR-0016]";
 echo "<BR>";
 echo "route-only";
 echo "<BR>";
 echo "no ip address *";
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
 echo "<BR>";
echo "!";
echo "<BR>";


echo "!";
echo "<BR>";
echo "interface ve 10";
echo "<BR>";
 echo "no ip address *";
 echo "<BR>";
 echo "port-name [IP interface WIRELESS-AP  Vlan 10]";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."1.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 20";
echo "<BR>";
 echo "no ip address *";
 echo "<BR>";

 echo "port-name [IP interface DATA  Vlan 20]";
 echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."2.1 255.255.254.0";
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 40";
echo "<BR>";
 echo "no ip address *";
 echo "<BR>";

 echo "port-name [IP interface SERVICES  Vlan 40]";
echo "<BR>";
 echo "ip address 10.".$ip2nd.".".$p."4.1 255.255.255.0";
 echo "<BR>";
 echo "ip ospf area 10.".$ip2nd.".0.0";
 echo "<BR>";
echo "!";
echo "<BR>";
echo "interface ve 50";
echo "<BR>";
 echo "no ip address *";
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
echo "end";
echo "<BR>";
echo "wr me";
echo "<BR>";
echo "reload";
echo "<BR>";





echo "<BR>";
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!PART 2  A F T E R   R E L O A D !!!!!!!!!!!!!!!!!!!!";
echo "<BR>";

echo "<BR>";
echo "conf t";
echo "<BR>";

echo "ip dhcp-server pool data-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."2.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51";
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
 echo "dns-server 192.168.101.50 192.168.101.51";
 echo "<BR>";
 echo "tftp-server 10.90.5.10";
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
 echo "dns-server 192.168.101.50 192.168.101.51";
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

echo "<BR>";
echo "ip dhcp-server pool services-pool";
echo "<BR>";
 echo "dhcp-default-router 10.".$ip2nd.".".$p."4.1 ";
 echo "<BR>";
 echo "dns-server 192.168.101.50 192.168.101.51";
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

}



?>



