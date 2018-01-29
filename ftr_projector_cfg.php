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
     $sql="select ftr_id,bld_newname,new_name,24p,48p from ftr  order by 2,1 ";
     
//    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
	projector($row['ftr_id'],$row['bld_newname'],$row['24p'],$row['48p'],$row['new_name']);
    }
        


function projector($ftr_id,$bld,$v24p,$v48p,$name) {


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


	$sql=" select @rownum:=@rownum+1 as row, src_roomid as src from ( select src_roomid from portmapping  ";
	$sql=$sql." where src_type='FTR' and dst_bld='".$bld."'  group by src_roomid order by src_roomid) e,  (SELECT @rownum:=0) r" ;
     	 $result = mysql_query($sql)
	   or die(mysql_error());	

echo "</font></font><p>";
echo "<BR> Our FTR ID is : $ftr_id";	
$ftr_row=0;
	while ($row=mysql_fetch_assoc($result)) {
//		echo "<BR> Internal calc : FTR_ID: ".$row['src'] . "  ROW: ".$row['row'];
		if ($row['src']==$ftr_id) $ftr_row=$row['row'];
		}// while
$p=$ftr_row;
echo "<BR> Internal calc : P is $p";
	
echo "<BR><font size=48 color=NAVY>Building: $bld  FTR $name<BR></font></p>";
echo "</font></font><p>";

echo "conf t";
echo "<BR>";

//*******************PORT - VLAN Assignment*********************

$vlan_id=200+$p;
echo "vlan $vlan_id name VIDEO_APPS by port";
echo "<BR>";
$sw=$v24p+$v48p;
if ($v24p>0) echo "tagged eth $sw/1/23";
else echo "tagged eth $sw/1/47";
echo "<BR>";
echo "router-interface ve $vlan_id";
echo "<BR>";
echo "!";

echo "<BR>";
echo "interface ve $vlan_id";
echo "<BR>";
echo "port-name [IP interface VIDEO_APPS  Vlan $vlan_id]";
echo "<BR>";
echo "ip address 10.".$ip2nd.".".$vlan_id.".1 255.255.255.0";
echo "<BR>";
echo "ip ospf area 10.$ip2nd.0.0";
echo "<BR>";
echo "ip helper-address 1 10.90.192.100";
echo "<BR>";
echo "<BR>";
echo "!";
echo "<BR>";



$vlan_id=220+$p;
echo "vlan $vlan_id name EDUCATION_EQP by port";
echo "<BR>";
$sw=$v24p+$v48p;
if ($v24p>0) echo "tagged eth $sw/1/23";
else echo "tagged eth $sw/1/47";
echo "<BR>";
echo "router-interface ve $vlan_id";
echo "<BR>";
echo "!";
echo "<BR>";

echo "<BR>";
echo "interface ve $vlan_id";
echo "<BR>";
echo "port-name [IP interface EDUCATION_EQP  Vlan $vlan_id]";
echo "<BR>";
echo "ip address 10.".$ip2nd.".".$vlan_id.".1 255.255.255.0";
echo "<BR>";
echo "ip ospf area 10.$ip2nd.0.0";
echo "<BR>";
echo "ip helper-address 1 10.90.192.100";
echo "<BR>";
echo "<BR>";
echo "!";
echo "<BR>";


$vlan_id=240+$p;
echo "vlan $vlan_id name FREE by port";
echo "<BR>";
$sw=$v24p+$v48p;
if ($v24p>0) echo "tagged eth $sw/1/23";
else echo "tagged eth $sw/1/47";
echo "<BR>";
echo "router-interface ve $vlan_id";
echo "<BR>";
echo "!";
echo "<BR>";

echo "<BR>";
echo "interface ve $vlan_id";
echo "<BR>";
echo "port-name [IP interface FREE  Vlan $vlan_id]";
echo "<BR>";
echo "ip address 10.".$ip2nd.".".$vlan_id.".1 255.255.255.0";
echo "<BR>";
echo "ip ospf area 10.$ip2nd.0.0";
echo "<BR>";
echo "ip helper-address 1 10.90.192.100";
echo "<BR>";
echo "<BR>";
echo "!";
echo "<BR>";


} // function



?>
