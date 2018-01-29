<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ CORE Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ MTR Information </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> CORE Info</font></p>";



$sw=$_GET['sw'];

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


getinfo($sw);


 

//function showswitch($48p,$24p,$10g,$1g){


function getinfo($sw){
  


echo "<BR><BR>";
echo "<table border=1 align=center><tr>";
echo "<td>";
echo "<form method=get action=corecfg.php>";
echo "<input type=hidden name=sw value=".$sw.">";
echo "<input type=submit value=Generate-Interface_Configuration>";
echo "</form>";
echo "</td></tr></table>";







showinstalled($sw);

portmapping($sw,'CORE');


}


function portmapping($sw,$room_type){
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
     $sql=$sql."(dst_switch='".$sw."' or src_switch='".$sw."') ";
     $sql=$sql." order by 1,3,4";
     
//     echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
    	echo "<tr>";
	echo "<td align=left> <font color=NAVY>".$row['src_switch']."</td>";
	echo "<td align=left> <font color=NAVY>".$row['src_slot']."/".$row['src_port']."</td>";
	echo "<td align=left> <font color=NAVY>".$row['src_ip']."</td>";
	echo "<td align=left> <font color=NAVY>".$row['dst_switch']."</td>";
	echo "<td align=left> <font color=NAVY>".$row['dst_slot']."/".$row['dst_port']."</td>";
	echo "<td align=left> <font color=NAVY>".$row['dst_ip']."</td>";
	echo "</tr>";
	
	}
	echo "</table>";



}






function showinstalled($sw){
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
     $sql=$sql."room_type='CORE' and hostname='".$sw."' order by 1,2,3";
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
	echo "<input type=hidden name=room_id value=0>";
	echo "<input type=hidden name=bld_old value=CORE>";
	echo "<input type=hidden name=bld value=CORE";
	echo "<input type=hidden name=new_name value=CORE>";
    
    

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
    echo "<td><font color=YELLOW>HostName</td><td><input type=text name=hostname value=$sw></td></tr>";
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





echo "</body>";
echo "</html>";

?>
