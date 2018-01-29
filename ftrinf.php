<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ FTR Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ FTR Information </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> FTR Info</font></p>";

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
$floor=$_GET['floor']; 
$old_name=$_GET['old_name'];

$func=$_GET['func'];

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
    $new_name=$_GET['new_name'];
    addinstalled('FTR',$room_id, $item, $description, $srno,$qty,$category,$vendor,$hostname,$person,$new_name,$uits_srno);
  }

if ($func=="add_report") {
    $room_id=$_GET['room_id'];
    $person=$_GET['person'];
    $dt=$_GET['dt'];
    $report=$_GET['report'];
    addreport('FTR',$room_id, $dt, $report,$person);
  }

getinfo($bld_old,$bld,$floor,$old_name);


 

//function showswitch($48p,$24p,$10g,$1g){


function getinfo($bld_old,$bld,$floor,$old_name){
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
     $sql="select ftr_id,new_name, passive_ports, active_ports, 48p, 24p, 2x10g, 10g, 1g, psu, analyzer168p, analyzer336p, ";
     $sql=$sql."sfpmm , sfpsm, xfpmm, xfpsm, installed, ups_type, ups_qty, battery_type, battery_qty, racks_avail, lo ";
     $sql=$sql." from ftr where ";
     $sql=$sql."bld_oldname='".$bld_old."' and ";
     $sql=$sql."bld_newname='".$bld."' and ";
     $sql=$sql."floor='".$floor."' ";
     $sql=$sql." and old_name='".$old_name."'";
     
//     echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    $row=mysql_fetch_assoc($result);
	echo "<tr><td align=center> <font color=NAVY> General Information</td></tr>";
	echo "<tr><td> <font color=NAVY> ID </td><td> <font color=NAVY>".$row['ftr_id']."</td></tr>";
	echo "<tr><td> <font color=NAVY> Building OLD Name </td><td><font color=NAVY>".$bld_old."</td></tr>";
	echo "<tr><td> <font color=NAVY> Building NEW Name </td><td><font color=NAVY>".$bld."</td></tr>";
	echo "<tr><td> <font color=NAVY> Floor </td><td><font color=NAVY>".$floor."</td></tr>";
	echo "<tr><td> <font color=NAVY> FTR OLD Name </td><td><font color=NAVY>".$old_name."</td></tr>";
	echo "<tr><td> <font color=NAVY> FTR NEW Name </td><td><font color=NAVY>".$row['new_name']."</td></tr>";
	if ($row['installed']=='NO') $installed="<FONT color=RED><B> NO";
    	if ($row['installed']=='YES') $installed="<FONT color=GREEN><B> YES";
	echo "<tr><td> <font color=NAVY> Installed? </td><td><font color=NAVY>".$installed."</td></tr>";
	echo "<tr><td> <font color=NAVY> Management IP </td><td><font color=BLUE>".$row['lo']."</td></tr>";

	echo "<tr><td align=center> <font color=PURPLE> Passive Information</td></tr>";
	echo "<tr><td> <font color=PURPLE> Passive ports from Morganti </td><td><font color=PURPLE>".$row['passive_ports']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Active ports </td><td><font color=PURPLE>".$row['active_ports']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> AsBuilt Passive </td><td> <font color=PURPLE> NULL</td></tr>";
	echo "<tr><td> <font color=PURPLE> Analyzer 168 port </td><td><font color=PURPLE>".$row['analyzer168p']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Analyzer 336 port </td><td><font color=PURPLE>".$row['analyzer336p']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> UPS Type </td><td><font color=PURPLE>".$row['ups_type']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> UPS Quantity </td><td><font color=PURPLE>".$row['ups_qty']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Battery Type </td><td><font color=PURPLE>".$row['battery_type']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Battery Quantity </td><td><font color=PURPLE>".$row['battery_qty']."</td></tr>";
	echo "<tr><td> <font color=PURPLE> Available Racks </td><td><font color=PURPLE>".$row['racks_avail']."</td></tr>";



	echo "<tr><td align=center> <font color=WHITE> Active Information</td></tr>";
	echo "<tr><td> <font color=WHITE> 48 Port Switch </td><td><font color=WHITE>".$row['48p']."</td></tr>";
	echo "<tr><td> <font color=WHITE> 24 Port Switch </td><td><font color=WHITE>".$row['24p']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Redundant Power Supply </td><td><font color=WHITE>".$row['psu']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Number of 10G Uplinks </td><td><font color=WHITE>".$row['10g']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Number of 1G Uplinks </td><td><font color=WHITE>".$row['1g']."</td></tr>";
	echo "<tr><td> <font color=WHITE> 2x10G Module </td><td><font color=WHITE>".$row['2x10g']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Optic SFP (1G) MultiMode LC COnnector </td><td><font color=WHITE>".$row['sfpmm']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Optic SFP (1G) SingleMode LC COnnector </td><td><font color=WHITE>".$row['sfpsm']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Optic XFP (10G) MultiMode LC COnnector </td><td><font color=WHITE>".$row['xfpmm']."</td></tr>";
	echo "<tr><td> <font color=WHITE> Optic XFP (10G) SingleMode LC COnnecto </td><td><font color=WHITE>".$row['xfpsm']."</td></tr>";

	
	echo "</table>";

$new_name=$row['new_name'];


echo "<BR><BR>";
echo "<table border=1 align=center><tr>";
echo "<td>";
echo "<form method=get action=ftrcfg.php>";
echo "<input type=hidden name=ftr_id value=".$row['ftr_id'].">";
echo "<input type=submit value=Generate-Configuration-file>";
echo "</form>";
echo "</td><td>";
echo "<form method=get action=ftrcfgwork.php>";
echo "<input type=hidden name=ftr_id value=".$row['ftr_id'].">";
echo "<input type=submit value=Generate-Engineer-workorder>";
echo "</form>";
echo "</td><td>";
echo "<form method=get action=tech-work.php>";
echo "<input type=hidden name=room_id value=".$row['ftr_id'].">";
echo "<input type=hidden name=room_type value=FTR>";
echo "<input type=hidden name=bld value=".$bld.">";
echo "<input type=submit value=Generate-Technician-workorder>";
echo "</form>";
echo "</td></tr></table>";



echo "<BR><BR>";
echo "<table border=1 align=center><tr>";
echo "<td> <font color=YELLOW> Room BOQ </td></tr>";
echo "<tr><td> <font color=YELLOW> Part NO </td><td><font color=YELLOW> Description</td><td> <font color=YELLOW> Quantity</td><td><font color=YELLOW><B>Vendor</td></tr>";
if ($row['24p']) echo "<tr><td> FCX624S-HPOE </td><td>24X1G HPOE, 2X16G STACKING</td><td>".$row['24p']."</td><td>BROCADE</td></tr>";
if ($row['48p']) echo "<tr><td> FCX648S-HPOE </td><td>24X1G HPOE, 2X16G STACKING</td><td>".$row['48p']."</td><td>BROCADE</td></tr>";
if ($row['psu']) echo "<tr><td> RPS14 </td><td>FCX POE POWER SUPPLY </td><td>".$row['psu']."</td><td>BROCADE</td></tr>";
if ($row['2x10g']) echo "<tr><td> FCX-2XG </td><td> 2X10GBE XFP for FCX </td><td>".$row['2x10g']."</td><td>BROCADE</td></tr>";
if ($row['xfpsm']) echo "<tr><td> 10G-XFP-LR </td><td> OPTIC, 10GBE, LR SingleMode, XFP, SMF, LC CONNECTOR </td><td>".$row['xfpsm']."</td><td>BROCADE</td></tr>";
if ($row['xfpmm']) echo "<tr><td> 10G-XFP-SR </td><td> OPTIC, 10GBE, SR MultiMode, XFP, SMF, LC CONNECTOR </td><td>".$row['xfpmm']."</td><td>BROCADE</td></tr>";
if ($row['sfpsm']) echo "<tr><td> E1MG-LX </td><td> 1G SFP MODULE, MINI-GBIC, LX SingleMode </td><td>".$row['sfpsm']."</td><td>BROCADE</td></tr>";
if ($row['sfpmm']) echo "<tr><td> E1MG-SX </td><td> 1G SFP MODULE, MINI-GBIC, SX MultiMode </td><td>".$row['sfpmm']."</td><td>BROCADE</td></tr>";
echo "<tr><td>".$row['ups_type']."</td><td> UPS </td><td>".$row['ups_qty']."</td><td>APC</td></tr>";
echo "<tr><td>".$row['battery_type']."</td><td> UPS </td><td>".$row['battery_qty']."</td><td>APC</td></tr>";
echo "</table>";




showinstalled($row['ftr_id'],$bld_old,$bld,$floor,$old_name,$new_name);

showreport($row['ftr_id'],$bld_old,$bld,$floor,$old_name);

showswitch($row['48p'],$row['24p'],$row['10g'],$row['1g'],$row['2x10g'],'FTR',$bld,$new_name);

$loc=$bld_old."-".$floor;
//ation($loc);
portmapping($row['ftr_id'],'FTR');

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
     $sql="select src_switch, substr(src_switch,1,3), src_slot, src_port,src_ip,dst_ip , dst_switch, dst_slot, dst_port ";
     $sql=$sql." from portmapping where ";
     $sql=$sql."(src_type='".$room_type."' and src_roomID='".$room_id."') OR";
     $sql=$sql."(dst_type='".$room_type."' and dst_roomID='".$room_id."') order by 2,4";
     
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





function showswitch($v48p,$v24p,$v10g,$v1g,$v2x10g,$room_type,$bld,$room){
  echo "<BR><BR><BR>";
  echo "48P:".$v48p." , 24P: ".$v24p." , 10G: ".$v10g." , 1G: ".$v1g." , 2x10G: ".$v2x10g."<BR>";
  echo "<table border=1 align = center>";
    echo "<tr><td>";
    $u=1;
   while ($v48p>0 || $v24p>0){
	$u++;
    	//echo "in $v48p>0 || $v24p>0";
    	if ($v48p>0) {
    		echo "<img src=images/brocade/48p_10g.jpg><BR>";
    		$v48p--;
    		}
    	
	if ( $v48p==0 &&  $v24p>0) {
		echo "<img src=images/brocade/24p_10g.jpg><BR>";
		$v24p--;
	}

    }
    
echo "</td><td>";
echo "<td>";
$i=1;
//echo "NNNN".$u."LLLL";
while ($i<=$u) {
    echo "SW".$i."-".$bld."-".$room_type."-".$room;
    echo "<BR>";
    echo "<BR>";
    echo "<BR>";
    $i++;
    }
    
    
echo "</table>";
}



function showinstalled($ftr_id,$bld_old,$bld,$floor,$old_name,$new_name){
  echo "<BR><BR><table border=1 align = center>";
    echo "<tr>";
    echo "<td> <font color=YELLOW><B><B> Installed Items </td></tr>";
    echo "<td><font color=YELLOW>Part Number</td><td><font color=YELLOW>Description</td><td>";
    echo "<font color=YELLOW>Serial NO</td><td><font color=YELLOW>UITS Serial NO</td><td><font color=YELLOW>Quantity</td><td><font color=YELLOW>Category</td><td>";
    echo "<font color=YELLOW>HostName</td><td><font color=YELLOW>Configured By</td><td><font color=YELLOW>Installed Date</td>";
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
     $sql="select category,partno,uits_srno,srno,description,qty,installed_date as dt, configured_by, hostname from installed where ";
     $sql=$sql."room_type='FTR' and room_id=".$ftr_id." order by 1,2,3";
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
	echo "<td>".$row['hostname']."</td>";
	echo "<td>".$row['configured_by']."</td>";
	echo "<td>".$row['dt']."</td>";			
	echo "</tr>";
	}
	echo "</table>";
	
	
    echo "<BR><BR><table border=1 align = center>";
    echo "<form name=funcs>";
    echo "<input type=hidden name=func value=add_installed>";
    echo "<input type=hidden name=room_id value=".$ftr_id.">";
    echo "<input type=hidden name=bld_old value=".$bld_old.">";
    echo "<input type=hidden name=bld value=".$bld.">";
    echo "<input type=hidden name=floor value=".$floor.">";
    echo "<input type=hidden name=old_name value=".$old_name.">";
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
    echo "<td><font color=YELLOW>HostName</td><td><input type=text name=hostname value=SW1-".$bld."-FTR-".$new_name." ></td></tr>";
    echo "<tr>";
    echo "<td><font color=YELLOW>SUBMIT</td><td><input type=submit name=Add the ITEM></td></tr>";
    echo "<tr>";  
    echo "</form>";
    echo "</table>";
        
    
    
 
}




function addinstalled($room_type,$room_id, $item, $description, $srno,$qty,$category,$vendor,$hostname,$person,$new_name, $uits_srno) {
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
     
//     echo "<R> $sql<BR>";
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




function showreport($ftr_id,$bld_old,$bld,$floor,$old_name){
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
     $sql="select report, dt,person from reports where ";
     $sql=$sql."room_type='FTR' and room_id=".$ftr_id." order by 1";
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
    echo "<input type=hidden name=room_id value=".$ftr_id.">";
    echo "<input type=hidden name=bld_old value=".$bld_old.">";
    echo "<input type=hidden name=bld value=".$bld.">";
    echo "<input type=hidden name=floor value=".$floor.">";
    echo "<input type=hidden name=old_name value=".$old_name.">";
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
