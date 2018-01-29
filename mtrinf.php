<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ MTR Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ MTR Information </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> MTR Info</font></p>";

/*
//echo $gotvar;
//    if ($gotvar=='sum')  summary();
//    if ($gotvar=='full')  full();

$bld_old=$_POST['bld_old'];
$bld=$_POST['bld']; 
$floor=$_POST['floor']; 
$old_name=$_POST['old_name'];



*/

$bld_old=$_GET['bld_old'];
$bld=$_GET['bld']; 
$new_name=$_GET['new_name'];

$func=$_GET['func'];
echo "<BR>$func<BR>";
if ($func=="add_installed") {
    $room_id=$_GET['room_id'];
    $item=$_GET['item'];
    $description=$_GET['description'];
    $srno=$_GET['srno'];
    $uits_srno=$_GET['uits_srno'];
    $qty=$_GET['qty'];
    $category=$_GET['category'];
    $vendor=$_GET['vendor'];
    $hostname=$_GET['hostname'];
    $person=$_GET['person'];
    addinstalled('MTR',$room_id, $item, $description, $srno,$qty,$category,$vendor,$hostname,$person,$uits_srno);
  }

if ($func=="add_report") {
    $room_id=$_GET['room_id'];
    $person=$_GET['person'];
    $dt=$_GET['dt'];
    $report=$_GET['report'];
    addreport('MTR',$room_id, $dt, $report,$person);
  }



getinfo($bld_old,$bld,$new_name);


 

//function showswitch($48p,$24p,$10g,$1g){


function getinfo($bld_old,$bld,$new_name){
  echo "<BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td>Attibute</td><td>Value</td>";
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
     $sql="select mtr_id,old_name, new_name, sw_fcx, sw_fcx_2x10g, sw_superx, sw_sx1600,sw_sx1600_2x10g,";
     $sql=$sql." sw_mod_24p_sfp,sw_mod_2x10g, analyzer168p, analyzer336p,fiber_sm_avail,fiber_mm_type ";
     $sql=$sql.", sfpmm , sfpsm, xfpmm, xfpsm, installed, ups_type, ups_qty, battery_type, battery_qty, racks_avail, lo ";
     $sql=$sql." from mtr where ";
     $sql=$sql."bld_oldname='".$bld_old."' and ";
     $sql=$sql."bld_newname='".$bld."' and ";
     $sql=$sql."new_name='".$new_name."'";
     
//     echo "<R> $sql<BR>";	
     $result = mysql_query($sql)	
       or die(mysql_error());	

    $row=mysql_fetch_assoc($result);
	echo "<tr><td align=center> <font color=NAVY> General Information</td></tr>";
	echo "<tr><td> <font color=NAVY> ID </td><td> <font color=NAVY>".$row['mtr_id']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Building OLD Name </td><td><font color=NAVY>".$bld_old."</td></tr>";
	echo "<tr><td> <font color=NAVY> Building NEW Name </td><td><font color=NAVY>".$bld."</td></tr>";
	echo "<tr><td> <font color=NAVY> MTR NEW Name </td><td><font color=NAVY>".$new_name."</td></tr>";
	echo "<tr><td> <font color=NAVY> MTR OLD Name </td><td><font color=NAVY>".$row['old_name']."</td></tr>";
	if ($row['installed']=='NO') $installed="<FONT color=RED><B> NO";
    	if ($row['installed']=='YES') $installed="<FONT color=GREEN><B> YES";
	echo "<tr><td> <font color=NAVY> Installed? </td><td><font color=NAVY>".$installed."</td></tr>";
	
	echo "<tr><td> <font color=NAVY> SW1 management IP </td><td><font color=NAVY>".$row['lo']."</td></tr>";
	
	//echo "<BR> BIIIP   1:!".strpos($bld,'C')."!   2:!".strstr($bld,'E')."! <BR>";
	if (strpos($bld,'C')+1>0 or strpos($bld,'E')+1>0) {
		echo "<tr><td> <font color=NAVY> SW2 management IP </td><td><font color=NAVY>".substr($row['lo'],0,10)."98</td></tr>";
	}
	
	
	

	echo "<tr><td align=center> <font color=PURPLE> Passive Information</td></tr>";
	echo "<tr><td> <font color=PURPLE> 2 x 24 core SM fiber to CIT available? </td><td><font color=PURPLE>".$row['fiber_sm_avail']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Fiber to FTRs available? </td><td><font color=PURPLE>".$row['fiber_mm_type']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Fiber to FTRs Cores? </td><td> <font color=PURPLE> NULL</td></tr>";
	echo "<tr><td> <font color=PURPLE> Analyzer 168 port </td><td><font color=PURPLE>".$row['analyzer168p']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Analyzer 336 port </td><td><font color=PURPLE>".$row['analyzer336p']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> UPS Type </td><td><font color=PURPLE>".$row['ups_type']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> UPS Quantity </td><td><font color=PURPLE>".$row['ups_qty']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Battery Type </td><td><font color=PURPLE>".$row['battery_type']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Battery Quantity </td><td><font color=PURPLE>".$row['battery_qty']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Available Racks </td><td><font color=PURPLE>".$row['racks_avail']."</td></tr>";



	echo "<tr><td align=center> <font color=WHITE> Active Information</td></tr>";
	if ($row['sw_fcx']) $sw_type='Fixed FCX 24 port SFP';
	if ($row['sw_superx']) $sw_type='Modular SuperX 8 Slot Chassis';
	if ($row['sw_sx1600']) $sw_type='Modular SX1600 16 Slot Chassis';
	if ($row['sw_sx1600_2x10g']) $sw_type='Modular SX1600 16 Slot Chassis with 2 x 10G Ports on SUP';
	
	echo "<tr><td> <font color=WHITE> Switch Type</td><td><font color=WHITE>".$sw_type."</td></tr>";
	if ($row['sw_fcx']) {
		echo "<tr><td> <font color=WHITE> Number of Switches </td><td><font color=WHITE>".$row['sw_fcx']."</td></tr>";
		echo "<tr><td> <font color=WHITE> 2x10G Module </td><td><font color=WHITE>".$row['sw_fcx_2x10g']."</td></tr>";
		}
	
	if ($row['sw_superx'] || $row['sw_sx1600'] || $row['sw_sx1600_2x10g']){
		echo "<tr><td> <font color=WHITE> Switch Module 24 Port SFP </td><td><font color=WHITE>".$row['sw_mod_24p_sfp']."</td></tr>";
		echo "<tr><td> <font color=WHITE> Switch Module 2 Port 10G </td><td><font color=WHITE>".$row['sw_mod_2x10g']."</td></tr>";
		echo "<tr><td> <font color=WHITE> Total Number of 10G  </td><td><font color=WHITE>".$row['xfpmm']+$row['xfpsm']."</td></tr>";
		echo "<tr><td> <font color=WHITE> Total Number of 1G  </td><td><font color=WHITE>".$row['sfpmm']+$row['sfpsm']."</td></tr>";
	}
	echo "<tr><td> <font color=WHITE> Optic SFP (1G)  MultiMode  LC Connector </td><td><font color=WHITE>".$row['sfpmm']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Optic SFP (1G)  SingleMode LC Connector </td><td><font color=WHITE>".$row['sfpsm']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Optic XFP (10G) MultiMode  LC Connector </td><td><font color=WHITE>".$row['xfpmm']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Optic XFP (10G) SingleMode LC Connector </td><td><font color=WHITE>".$row['xfpsm']."</td></tr>";

	
	echo "</table>";


echo "<BR><BR>";
echo "<table border=1 align=center><tr>";
echo "<td>";
echo "<form method=get action=mtrcfg.php>";
echo "<input type=hidden name=mtr_id value=".$row['mtr_id'].">";
echo "<input type=submit value=Generate-Configuration-file>";
echo "</form>";
echo "</td><td>";
echo "<form method=get action=mtrcfgwork.php>";
echo "<input type=hidden value=".$row['mtr_id'].">";
echo "<input type=submit value=Generate-Engineer-workorder>";
echo "</form>";
echo "</td><td>";
echo "<form method=get action=tech-work.php>";
echo "<input type=hidden name=room_id value=".$row['mtr_id'].">";
echo "<input type=hidden name=room_type value=MTR>";
echo "<input type=hidden name=bld value=".$bld.">";
echo "<input type=submit value=Generate-Technician-workorder>";
echo "</form>";
echo "</td></tr></table>";



echo "<BR><BR>";
echo "<table border=1 align=center><tr>";
echo "<td> <font color=YELLOW> Room BOQ </td></tr>";
echo "<tr><td> <font color=YELLOW> Part NO </td><td><font color=YELLOW> Description</td><td> <font color=YELLOW> Quantity</td><td><font color=YELLOW><B>Vendor</td></tr>";
if ($row['sw_fcx']) echo "<tr><td> 	FCX624S-F-ADV </td><td> Fixed 24XFE/GE SFP,2X16G STACK,ADV L3</td><td>".$row['sw_fcx']."</td><td>BROCADE</td></tr>";
if ($row['sw_fcx_2x10g']) echo "<tr><td> FCX-2XG </td><td> 2X10GBE XFP for FCX </td><td>".$row['sw_fcx_2x10g']."</td><td>BROCADE</td></tr>";

if ($row['sw_superx']) echo "<tr><td> FI-SX1-AC </td><td>FastIron SuperX Chassis with Fan tray and one (1) AC Power Supply</td><td>".$row['sw_superx']."</td><td>BROCADE</td></tr>";
if ($row['sw_superx']) echo "<tr><td> SX-FI12GM-6-PREM6 </td><td>IPv6-Capable FastIron SuperX Management Module includes 12 combo 10/100/1000</td><td>".$row['sw_superx']."</td><td>BROCADE</td></tr>";


if ($row['sw_sx1600']) echo "<tr><td> FI-SX1600-AC </td><td>FastIron SX 1600 chassis bundle includes one SX 1600 16-slot chassis (FI-SX1600-S), two Switch Fabric Module (SX-FISF), two system power supply (SX-ACPWR-SYS), seventeen interface cover panels (SX-FI-IFPNL), six power supply cover panels (SX-PWR-PNL), one SX 1600 filter (SX-SX1600-FILTER), and two fan trays that includes fans (SX-SX1600-FAN).</td><td>".$row['sw_sx1600']."</td><td>BROCADE</td></tr>";
if ($row['sw_sx1600']) echo "<tr><td> SX-FIZMR-6-PREM6 </td><td> IPv6-Capable Zero-Port Management Module for the FastIron SX 800 and SX 1600 chassis. This management module includes 1 Ethernet management port and 1 serial console port. There are no user traffic ports supported on this module. To configure redundancy, two of the same type of management modules must be installed in the chassis. Module ships with Premium IronWare software including Full L3 IPv4+IPv6 service sets (BGP-4, OSPF/OSPFv3, RIP/RIPng, VRRP/VRRPE, DVMRP, PIM, IPv4/IPv6 static routes, 6-to-4 static tunneling). The module can only be used in systems configured with all IPv6-ready line modules.</td><td>".$row['sw_sx1600']."</td><td>BROCADE</td></tr>";

if ($row['sw_sx1600_2x10g']) echo "<tr><td> FI-SX1-AC </td><td>FastIron SuperX Chassis with Fan tray and one (1) AC Power Supply</td><td>".$row['sw_sx1600_2x10g']."</td><td>BROCADE</td></tr>";
if ($row['sw_sx1600_2x10g']) echo "<tr><td> SX-FI2XGMR6-PREM6 </td><td>IPv6-Capable 2-port 10GbE Management Module for the FastIron SX 800 and SX 1600 chassis. This management module includes 1 Ethernet management port, one serial console port and 2 10GbE ports for user traffic. The 10GbE ports support pluggable XFP transceivers (transceivers not included). Module ships with Premium IronWare software including Full L3 IPv4+IPv6 service sets (BGP-4, OSPF/OSPFv3, RIP/RIPng, VRRP/VRRPE, DVMRP, PIM, IPv4/IPv6 static routes, 6-to-4 static tunneling).  The module can only be used in a system configured with all IPv6-ready line modules.</td><td>".$row['sw_sx1600_2x10g']."</td><td>BROCADE</td></tr>";

if ($row['sw_mod_24p_sfp']) echo "<tr><td> SX-FI624HF </td><td>24-port 100/1000 SFP based Fiber Ethernet IPv6 module for FastIron SuperX family.</td><td>".$row['sw_mod_24p_sfp']."</td><td>BROCADE</td></tr>";
if ($row['sw_mod_2x10g']) echo "<tr><td> SX-FI62XG </td><td>2-port XFP 10 Gigabit Ethernet module for FastIron SuperX family.</td><td>".$row['sw_mod_2x10g']."</td><td>BROCADE</td></tr>";


if ($row['xfpsm']) echo "<tr><td> 10G-XFP-LR </td><td> OPTIC, 10GBE, LR SingleMode, XFP, SMF, LC CONNECTOR </td><td>".$row['xfpsm']."</td><td>BROCADE</td></tr>";
if ($row['xfpmm']) echo "<tr><td> 10G-XFP-SR </td><td> OPTIC, 10GBE, SR MultiMode, XFP, SMF, LC CONNECTOR </td><td>".$row['xfpmm']."</td><td>BROCADE</td></tr>";
if ($row['sfpsm']) echo "<tr><td> E1MG-LX </td><td> 1G SFP MODULE, MINI-GBIC, LX SingleMode </td><td>".$row['sfpsm']."</td><td>BROCADE</td></tr>";
if ($row['sfpmm']) echo "<tr><td> E1MG-SX </td><td> 1G SFP MODULE, MINI-GBIC, SX MultiMode </td><td>".$row['sfpmm']."</td><td>BROCADE</td></tr>";
echo "<tr><td>".$row['ups_type']."</td><td> UPS </td><td>".$row['ups_qty']."</td><td>APC</td></tr>";
echo "<tr><td>".$row['battery_type']."</td><td> UPS </td><td>".$row['battery_qty']."</td><td>APC</td></tr>";
echo "</table>";




showinstalled($row['mtr_id'] ,$bld_old,$bld,$new_name);
showreport($row['mtr_id'],$bld_old,$bld,$new_name);
showswitch($row['sw_fcx'],$bld_old);
//$loc=$bld_old."-".$floor;
//showlocation($loc);
loopback($bld);

portmapping($row['mtr_id'],'MTR');


}


function loopback($bld){
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
	echo "<BR><BR><table border=1 align = center>";
	echo "<tr><td> <font color=YELLOW><B><B> Management IP Address</td></tr>";
	echo "<tr><td><font color=YELLOW>SW1</td><td>10.$ip2nd.99.99</td></tr>";
	echo "<tr><td><font color=YELLOW>SW2</td><td>10.$ip2nd.99.98</td></tr>";
	echo "</table>";
}

	


function portmapping($room_id,$room_type){
  echo "<BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td>Source Switch</td><td>Source Port</td><td>Source IP</td><td>Destination Switch</td><td>Destination Port</td><td>Destination IP</td>";
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
     $sql="select src_roomid, src_switch, src_slot, src_port,src_ip,dst_ip , dst_switch, dst_slot, dst_port ";
     $sql=$sql." from portmapping where ";
     $sql=$sql."(src_type='".$room_type."' and src_roomID='".$room_id."') OR";
     $sql=$sql."(dst_type='".$room_type."' and dst_roomID='".$room_id."') and src_type='CORE' order by 1,3,4";
     
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
    	echo "<tr>";
	echo "<td align=center> <font color=NAVY>".$row['src_switch']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['src_slot']."/".$row['src_port']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['src_ip']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['dst_switch']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['dst_slot']."/".$row['dst_port']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['dst_ip']."</td>";
	echo "</tr>";
	
	}
	echo "</table>";


    echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td>Source Switch</td><td>Source Port</td><td>Source IP</td><td>Destination Switch</td><td>Destination Port</td><td>Destination IP</td>";
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
     $sql="select src_roomid, src_switch, substr(src_switch,12,10), substr(src_switch,1,3), src_slot, src_port,src_ip,dst_ip , dst_switch, dst_slot, dst_port ";
     $sql=$sql." from portmapping where ";
     $sql=$sql."(src_type='".$room_type."' and src_roomID='".$room_id."') OR";
     $sql=$sql."(dst_type='".$room_type."' and dst_roomID='".$room_id."') and src_type='FTR' order by 3,4,6";
     
//     echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
    	echo "<tr>";
	echo "<td align=center> <font color=NAVY>".$row['src_switch']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['src_slot']."/".$row['src_port']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['src_ip']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['dst_switch']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['dst_slot']."/".$row['dst_port']."</td>";
	echo "<td align=center> <font color=NAVY>".$row['dst_ip']."</td>";
	echo "</tr>";
	
	}
	echo "</table>";







}






function showswitch($fcx,$bld_old){
  echo "<BR><BR><BR>";
//  echo "48P:".$v48p." , 24P: ".$v24p." , 10G: ".$v10g." , 1G: ".$v1g." , 2x10G: ".$v2x10g."<BR>";
  echo "<table border=1 align = center>";
    echo "<tr><td>";

    	//echo "in $v48p>0 || $v24p>0";
    	if ($fcx) {
    		echo "<img src=images/brocade/24p_10g.jpg><BR>";
    		echo "<img src=images/brocade/24p_10g.jpg><BR>";
    		}
    	
	if ($bld_old=='3A') echo "<img src=images/brocade/mtr/3A.JPG><BR>";
	if ($bld_old=='3B') echo "<img src=images/brocade/mtr/3B.JPG><BR>";
	if ($bld_old=='3C') echo "<img src=images/brocade/mtr/3C.JPG><BR>";
	if ($bld_old=='3D') echo "<img src=images/brocade/mtr/3D.JPG><BR>";
	if ($bld_old=='3E') echo "<img src=images/brocade/mtr/3E.JPG><BR>";
	if ($bld_old=='3F') echo "<img src=images/brocade/mtr/3F.JPG><BR>";
	if ($bld_old=='3G') echo "<img src=images/brocade/mtr/3G.JPG><BR>";
	if ($bld_old=='5A') echo "<img src=images/brocade/mtr/5A.JPG><BR>";
	if ($bld_old=='5B') echo "<img src=images/brocade/mtr/5B.JPG><BR>";
	if ($bld_old=='5C') echo "<img src=images/brocade/mtr/5C.JPG><BR>";
	if ($bld_old=='5D') echo "<img src=images/brocade/mtr/5D.JPG><BR>";
	if ($bld_old=='5E') echo "<img src=images/brocade/mtr/5E.JPG><BR>";
	if ($bld_old=='6D') echo "<img src=images/brocade/mtr/6D.JPG><BR>";
	
	
echo "</table>";
}



function showinstalled($mtr_id,$bld_old,$bld,$new_name){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td> <font color=YELLOW><B><B> Installed Items </td></tr>";
    echo "<td><font color=YELLOW>Part Number</td><td><font color=YELLOW>Description</td><td><font color=YELLOW>Serial NO</td><td><font color=YELLOW>UITS Serial NO</td><td><font color=YELLOW>Quantity</td><td><font color=YELLOW>Category</td><td><font color=YELLOW>Installed Date</td>";
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
     $sql="select category,partno,srno,uits_srno,description,qty,installed_date as dt from installed where ";
     $sql=$sql."room_type='MTR' and room_id=".$mtr_id." order by 1,2,3";
//     echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr>";
	echo "<td>".$row['partno']."</td>";
	echo "<td>".$row['description']."</td>";
	echo "<td>".$row['srno']."</td>";
	echo "<td>".$row['uits_srno']."</td>";
	echo "<td>".$row['qty']."</td>";
	echo "<td>".$row['category']."</td>";
	echo "<td>".$row['dt']."</td>";			
	echo "</tr>";
	}
	echo "</table>";
	
    echo "<BR><BR><table border=1 align = center>";
    echo "<form name=funcs>";
    echo "<input type=hidden name=func value=add_installed>";
    echo "<input type=hidden name=room_id value=".$mtr_id.">";
    echo "<input type=hidden name=bld_old value=".$bld_old.">";
    echo "<input type=hidden name=bld value=".$bld.">";
    echo "<input type=hidden name=new_name value=".$new_name.">";
    echo "<tr>";
    echo "<td> <font color=YELLOW><B><B> ADD Installed Items </td><td></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Part Number</td><td><input type=text name=item></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Description</td><td><input type=text name=description></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Serial Number</td><td><input type=text name=srno></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>UITS Serial Number</td><td><input type=text name=uits_srno></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Quantity</td><td><input type=text name=qty></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Categotry</td><td><input type=text name=category value=NETWORK></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Vendor</td><td><input type=text name=vendor value=BROCADE></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>Configured By (person)</td><td><input type=text name=person></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>HostName</td><td><input type=text name=hostname value=SW1-".$bld."-MTR-".$new_name."></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>SUBMIT</td><td><input type=submit name=Add the ITEM></td></tr>";
    echo "<tr>";
    echo "</form>";
    echo "</table>";

}


function showreport($mtr_id,$bld_old,$bld,$new_name){
    echo "<BR> ";
    echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td> <font color=BROWN><B><B> Work History in the room </td></tr>";
    echo "<td><font color=BROWN>Date</td><td><font color=BROWN>Report</td><td><font color=BROWN>Person In-Charge</td><td>";
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
     $sql="select report,dt,person  from reports where ";
     $sql=$sql."room_type='MTR' and room_id=".$mtr_id." order by 1";
//     echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());

    while ($row=mysql_fetch_assoc($result)){
	echo "<tr>";
	echo "<td>".$row['dt']."</td>";
	echo "<td>".$row['report']."</td>";
	echo "<td>".$row['person']."</td>";
	echo "</tr>";
	}
	echo "</table>";
	
	
	
	
	    echo "<BR><BR><table border=1 align = center>";
	    echo "<form name=funcs>";
	    echo "<input type=hidden name=func value=add_report>";
	    echo "<input type=hidden name=room_id value=".$mtr_id.">";
	    echo "<input type=hidden name=bld_old value=".$bld_old.">";
	    echo "<input type=hidden name=bld value=".$bld.">";
	    echo "<input type=hidden name=new_name value=".$new_name.">";
	    echo "<tr>";
	    echo "<td> <font color=YELLOW><B><B> ADD Report </td><td></td></tr>";
	    echo "<tr>";
	    echo "<td><font color=YELLOW>Date </td><td><input type=text name=dt value=2010-06-20 19:11:00></td></tr>";
	    echo "<tr>";
	    echo "<td><font color=YELLOW>PersonIn charge</td><td><input type=text name=person></td></tr>";
	    echo "<tr>";
	    echo "<td><font color=YELLOW>Report</td><td><textarea name=report></textarea></td></tr>";
	    echo "<tr>";
	    echo "<tr>";
	    echo "<td><font color=YELLOW>SUBMIT</td><td><input type=submit name=Add the ITEM></td></tr>";
	    echo "<tr>";
	    echo "</form>";
	    echo "</table>";

}




function addinstalled($room_type,$room_id, $item, $description, $srno,$qty,$category,$vendor,$hostname,$person,$uits_srno) {
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
     $sql="insert into installed values ('".$room_type."',".$room_id.",'".$item."','".$description."','".$srno."',".$qty.",";
     $sql=$sql."'".$category."' , '".$vendor."' , now() , '".$hostname."' , '".$person."' , '".$uits_srno."' )";
     
//    echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());
}


function     addreport($room_type,$room_id, $dt, $report,$person){
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
     $sql="insert into reports values ('".$room_type."',".$room_id.",'".$dt."','".$report."','".$person."')";
     
//     echo "<R> $sql<BR>";
     $result = mysql_query($sql)
       or die(mysql_error());
}


function showlocation($loc){
  echo "<BR><BR><BR>";
  echo "<table border=1 align = center>";
  echo "<tr><td>";
  echo "<img src=images/location/";
  echo $loc;
  echo ".jpg><BR>";
  echo "</table>";
}


echo "</body>";
echo "</html>";

?>
