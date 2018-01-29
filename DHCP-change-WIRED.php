<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ DCHP Scope Generator change WIRED</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ DCHP Scope change for WIRED </p>";
echo "<br>";



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
$sql="select bld_newname,new_name, left(new_name,1) as flr, lo , right(lo,1) as my_id";
$sql=$sql." from ftr where ";
$sql=$sql."bld_newname not in ('A11','E2')  and bld_newname not like 'D%' ";

//    echo "<BR> $sql<BR>";	
$result = mysql_query($sql)
or die(mysql_error());	
	
while ($row=mysql_fetch_assoc($result)) {

		$bld=$row['bld_newname'];
		$flr=$row['flr'];
		$new_name=$row['new_name'];
		$lo=$row['lo'];
		$supernet=substr($lo,0,7);
		//$my_id=$row['my_id'];     
		//10.111.99.1
		$my_id=substr($lo,10,2);
//		echo "<BR> SubStr is " . substr($bld,0,1) . "!<BR>";
//		echo "<BR> SuperNet is $supernet!<BR>";
//		echo "<BR> MY ID  is $my_id!<BR>";
		
		
		if (substr($bld,0,1)=='A')  $type='HOSTEL';
		if (substr($bld,0,1)=='B')  $type='VILLAGE';
		if (substr($bld,0,1)=='C')  $type='ACADEMICS';
		if (substr($bld,0,1)=='E')  $type='LABS';
		
		
		/*  Fixing Wireless Controller Domains */
		if (substr($bld,0,2)=='A1') $wlc='a.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='A2') $wlc='a.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='A3') $wlc='a.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='A4') $wlc='a.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='A5') $wlc='a.wlc2.ap..ac.ae';
		if (substr($bld,0,2)=='A6') $wlc='a.wlc2.ap..ac.ae';
		if (substr($bld,0,2)=='A7') $wlc='a.wlc2.ap..ac.ae';
		if (substr($bld,0,2)=='A8') $wlc='a.wlc2.ap..ac.ae';
		if (substr($bld,0,2)=='A9') $wlc='a.wlc3.ap..ac.ae';
		if (substr($bld,0,2)=='A10') $wlc='a.wlc3.ap..ac.ae';
		if (substr($bld,0,2)=='A11') $wlc='a.wlc3.ap..ac.ae';
		
		if (substr($bld,0,1)=='B') $wlc='b.wlc1.ap..ac.ae';
		
		if (substr($bld,0,2)=='C1') $wlc='c.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='C5') $wlc='c.wlc2.ap..ac.ae';
		if (substr($bld,0,2)=='C4') $wlc='c.wlc3.ap..ac.ae';
		if (substr($bld,0,2)=='C6') $wlc='c.wlc3.ap..ac.ae';
		
		
		if (substr($bld,0,2)=='E2') $wlc='e.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='E3') $wlc='e.wlc2.ap..ac.ae';
		if (substr($bld,0,2)=='E4') $wlc='e.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='E5') $wlc='e.wlc2.ap..ac.ae';
		if (substr($bld,0,2)=='E6') $wlc='e.wlc1.ap..ac.ae';
		if (substr($bld,0,2)=='E7') $wlc='e.wlc2.ap..ac.ae';
		
		
//		echo "<BR><font color=green size=10> Working on  Building $bld  FTR $new_name  ,  Floor: $flr</font><BR>";
//		echo "<BR>";

		
//		echo "<BR><B> DATA POOL </B><BR>";
		echo "Dhcp Server 10.90.192.100 Scope ".$supernet.$my_id."2.0 Add iprange ".$supernet.$my_id."2.51  ".$supernet.$my_id."3.254";
		echo "<BR>";
		


}// While 



?>
