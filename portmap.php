<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ Port Mapping</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ Port Mapping </p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> Port Mapping</font></p>";


start();
showportmapping('CORE','MTR');
 


function start(){
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
     $sql="select dst_bld from portmapping where dst_bld like 'E%' group by 1 ";
     
 //    echo "<R> $sql<BR>";	
     $result = mysql_query($sql)
       or die(mysql_error());	

    while ($row=mysql_fetch_assoc($result)) {
    
    	portmap_bld($row['dst_bld']);
    	
    	}
    	
    	


}



function portmap_bld($bld){
    echo "<BR><BR><BR>";
    echo "------------------------------------------------------------------------------------------------------------<BR>";
    echo "<BR>Processing Building : ".$bld." ....<BR>";

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
	 $sql="select ip from bld_ip where bld='".$bld."'";

	  $result2 = mysql_query($sql)
		or die(mysql_error());	

     	$row=mysql_fetch_assoc($result2);
     	$ip=$row['ip'];
		$ip2nd=substr($ip,3,3);
     
     
    echo "<BR>Building IP Range : ".$ip ." ..... Second Octet: ".$ip2nd."<BR>";	
    
    portmap_core_mtr($bld,$ip2nd);
    
    
	//*******GET MTR INFORMATION******************
	 $sql="select mtr_id, new_name from mtr where bld_newname='".$bld."'";

	  $result20 = mysql_query($sql)
		or die(mysql_error());	

		$row=mysql_fetch_assoc($result20);
		$mtr_id=$row['mtr_id'];
		$mtr_new_name=$row['new_name'];
		
		    
    
    if ($bld!='E2')  portmap_ftr_mtr($bld,$ip2nd,$mtr_id,$mtr_new_name);
    
  

}

function   portmap_core_mtr($bld,$ip2nd) {

    echo "<BR>";
    echo "Start IP mapping between CORE-MTR<BR>";

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
	 $sql="select new_name, src_switch,src_slot,src_port,dst_switch,dst_slot,dst_port from portmapping,mtr where ";
	 $sql=$sql." src_type='CORE' and dst_type='MTR' and dst_bld='".$bld."' and dst_roomid=mtr_id order by src_slot, src_port";
     $result3 = mysql_query($sql)
		or die(mysql_error());	

	$core_ip_side=1;
	$mtr_ip_side=2;
	while ($row=mysql_fetch_assoc($result3)) {

		echo "<BR> Working for mapping : SRC Switch: ".$row['src_switch']." - Port : ".$row['src_slot'] ."/".$row['src_port'];
		echo "--------TO DST ----Building $bld --- MTR name: ".$row['new_name']."----Switch :";
		echo $row['dst_switch']."- Port : ".$row['dst_slot']."/".$row['dst_port'];
		
		if (strstr($row['dst_switch'],'DIST1')) $dist='1';
		else
			if (strstr($row['dst_switch'],'DIST2')) $dist='2';
			else $dist='3';
		
		
		if ($dist!='3') $dst_host="SW".$dist."-$bld-MTR-".$row['new_name'];
		if ($dist=='3') $dst_host=$row['dst_switch'];
		
		echo "<BR> New Name $dst_host <BR>";
		
		
		$src_ip="10.250.".$ip2nd.".".$core_ip_side."/29";
		$dst_ip="10.250.".$ip2nd.".".$mtr_ip_side."/29";
		
		$core_ip_side=$core_ip_side+8;
		$mtr_ip_side=$core_ip_side+1;
		
		echo "Source IP in Core : $src_ip  --------- Destinatio IP in MTR : $dst_ip <BR>";


		$sql="update portmapping set src_ip='".$src_ip."' , dst_ip='".$dst_ip."' , dst_switch='".$dst_host."' where ";
		$sql=$sql." src_type='CORE' and dst_type='MTR' and dst_bld='".$bld."' and ";
		$sql=$sql." src_slot=".$row['src_slot']." and src_port=".$row['src_port']." and dst_switch='".$row['dst_switch']."' and ";
		$sql=$sql." dst_slot=".$row['dst_slot']." and dst_port=".$row['dst_port']."";
		
		echo "<BR>$sql<BR><BR>";
		
		
		$user="root";
		$password="rezasql";
		# Connect to MySQL server
		$conn = mysql_connect($host,$user,$password)
		   or die(mysql_error());
		# Select the database
		mysql_select_db("", $conn)
		   or die(mysql_error());
		# Send SQL query
		 $result4 = mysql_query($sql)
			or die(mysql_error());	


		}




}


function   lastport($sw,$bld) {

    echo "<BR>";
    echo "Getting last used MTR port $bld<BR>";

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
	 $sql="select max(dst_slot) as slot from portmapping where left(dst_switch,3)='".$sw."' and ";
	 $sql=$sql." dst_bld='".$bld."' ";
//echo "<BR>$sql";

     $result5 = mysql_query($sql)
		or die(mysql_error());
	 $row=mysql_fetch_assoc($result5);
	 $slot=$row['slot'];
//	 echo "<BR> $sw  Slot: $slot";
	 
	 $sql="select max(dst_port) as port from portmapping where left(dst_switch,3)='".$sw."' and ";
 	 $sql=$sql." dst_bld='".$bld."' and dst_slot='".$slot."' ";
//echo "<BR>$sql";

	      $result5 = mysql_query($sql)
	 		or die(mysql_error());
	 	 $row=mysql_fetch_assoc($result5);
	 $port=$row['port'];
	 $sww=$slot."/".$port;
	 echo "<BR> in function : SW : $sw    Last Port $sww";
	 return($sww);
	 


}


function   portmap_ftr_mtr($bld,$ip2nd,$mtr_id,$mtr_new_name) {

    
    $host_mtr1="SW1-".$bld."-MTR-".$mtr_new_name;
    $host_mtr2="SW2-".$bld."-MTR-".$mtr_new_name;
    
    
    echo "<BR>";
    echo "Start FTR mapping between MTR Building: $bld<BR>";

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
	 $sql="select ftr_id, new_name, 48p , 2x10g, 24p, 10g, 1g from ftr where ";
	 $sql=$sql." bld_newname='".$bld."' order by new_name";
     $result3 = mysql_query($sql)
		or die(mysql_error());	

	$core_ip_side=1;
	$mtr_ip_side=2;
	$ip_counter=-3;

	while ($row=mysql_fetch_assoc($result3)) {

		echo "<BR> Working for FTR Port mapping : FTR ID: ".$row['ftr_id']." ---Name : ".$row['new_name'] ." ---48 port:".$row['48p'];
		echo "---24 port: ".$row['24p']."---10G:".$row['10g']." ---2x10G:".$row['2x10g']."---1g:".$row['1g']."!<BR>";

	$new_name=$row['new_name'];
	$ftr_id=$row['ftr_id'];
	$v2x10g=$row['2x10g'];
	$v10g=$row['10g'];
	$sw=$row['48p']+$row['24p'];
	$flag=1;
	$my_2x10g=$v2x10g;
	$my_10g=$v10g;
	$rr=20;
	$i=1;
	
	
	$SW1_last=& lastport('SW1',$bld);
	
	$sw1_slot=substr($SW1_last,0,strpos($SW1_last,'/'));
	$sw1_port=substr($SW1_last,strpos($SW1_last,'/')+1,10);
	echo "<BR> BBS  Last Port: $SW1_last  Last slot : $sw1_slot   Last port : $sw1_port   That number is strchr($SW1_last,'/')    is !".strpos($SW1_last,'/');
	
	$SW2_last=& lastport('SW2',$bld);
	$sw2_slot=substr($SW2_last,0,strpos($SW2_last,'/'));
	$sw2_port=substr($SW2_last,strpos($SW2_last,'/')+1,10);

	echo "<BR> Last port of SW1 : $SW1_last  is  $sw1_slot  , $sw1_port";
	echo "<BR> Last port of SW2 : $SW2_last  is  $sw2_slot  , $sw2_port"; 
	
	if ($sw1_port==2) {
						$sw1_slot++;
						$sw1_port=1;
					}
	else 	$sw1_port++;
	if ($sw1_slot=='10') $sw1_slot='11';
	if ($sw1_slot=='9' and $bld!='E6') $sw1_slot='11';

	
	
	if ($sw2_port==2) {
							$sw2_slot++;
							$sw2_port=1;
						}
	else $sw2_port++;
	if ($sw2_slot==10) $sw2_slot=11;
	if ($sw2_slot==9 and $bld!='E6') $sw2_slot=11;

	
	
	echo "<BR> Next port of SW1 :   is  $sw1_slot  / $sw1_port";
	echo "<BR> Next port of SW2 :   is  $sw2_slot  / $sw2_port"; 
	
	
	//*******Chck is both DIST switches are populated dame or not
	if ( ($sw1_slot!=$sw2_slot) or ($sw1_port!=$sw2_port) ) echo "<BR> BIB BIB MTR switches ports are not same";
	if ($sw1_slot>$sw2_slot or ($sw1_slot==$sw2_slot and $sw1_port>$sw2_port)) {
		echo "<BR> SW1 is higher ,  using SW2 as default";
		$single_sw=2;
	}
	
	if ($sw1_slot<$sw2_slot or ($sw1_slot==$sw2_slot and $sw1_port<$sw2_port)) {
		echo "<BR> SW2 is higher  , using SW1 as default";
		$single_sw=1;
	}
	
	
	if ( ($sw1_slot==$sw2_slot) and ($sw1_port==$sw2_port) ) {
	echo "<BR> Both MTR Switches are same in Slot / Port  using SW1 as default ";
		$single_sw=1;
	}
	
	//*************CREATE PORT MAPPING******************
		

	
	while ($i<=$v2x10g and $my_10g>0 and $rr>0) {
	

	
	echo "<BR>$rr -- my10g:$my_10g  my2x10g: $my_2x10g";
		if ($my_10g-$my_2x10g>0) {
		
			$ip_counter=$ip_counter+4;
			$dst_ip="10.".$ip2nd.".0.".$ip_counter."/30";
			$temp_counter=$ip_counter+1;
			$src_ip="10.".$ip2nd.".0.".$temp_counter."/30";
			echo "<BR> Port ".$i." /3/1  IP: $src_ip --------------DUAL(1)----------TO------------------- --MTR $host_mtr1 --PORT: $sw1_slot  / $sw1_port---IP: $dst_ip - ";
		
			$host_ftr="SW".$i."-".$bld."-FTR-".$new_name;
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
			 $sql="insert into portmapping values ('FTR','$bld',$ftr_id,'$host_ftr','3','1','$src_ip','MTR','$bld',$mtr_id,'$host_mtr1',$sw1_slot,'$sw1_port','$dst_ip') ";
			echo "<BR> Insert SQL :  $sql <BR>";
			 
			$result31 = mysql_query($sql)
				or die(mysql_error());	

		
		
			$ip_counter=$ip_counter+4;
			$dst_ip="10.".$ip2nd.".0.".$ip_counter."/30";
			$temp_counter=$ip_counter+1;
			$src_ip="10.".$ip2nd.".0.".$temp_counter."/30";
		
			echo "<BR> Port ".$i." /3/2 IP: $src_ip  ---------------DUAL(2)---------TO-------------------  --MTR $host_mtr2----PORT:-$sw2_slot/ $sw2_port---IP: $dst_ip - ";
		
			$host_ftr="SW".$i."-".$bld."-FTR-".$new_name;
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
			 $sql="insert into portmapping values ('FTR','$bld',$ftr_id,'$host_ftr','3','2','$src_ip','MTR','$bld',$mtr_id,'$host_mtr2',$sw2_slot,'$sw2_port','$dst_ip') ";

			echo "<BR> Insert SQL :  $sql <BR>";
			 
			$result32 = mysql_query($sql)
			  or die(mysql_error());	

		
			$my_2x10g--;
			$my_10g--;
			$my_10g--;
			$i++;
			
		
			if ($sw1_port==2) {
								$sw1_slot++;
								$sw1_port=1;
							}
			else 	$sw1_port++;
			if ($sw1_slot=='10') $sw1_slot='11';
			if ($sw1_slot=='9' and $bld!='E6') $sw1_slot='11';
								
			
			
			

			if ($sw2_port==2) {
									$sw2_slot++;
									if ($sw2_slot==10) $sw2_slot==11;
									if ($sw2_slot==9) {
										if ($bld!='E6') $sw1_slot=11;
									}
									$sw2_port=1;
								}
			else $sw2_port++;
			if ($sw2_slot=='10') $sw2_slot='11';
			if ($sw2_slot=='9' and $bld!='E6') $sw2_slot='11';

			
				
			}
			
			
			
		if ($my_10g>0 and ($my_10g-$my_2x10g==0) and $my_2x10g>0) {
//			echo "<BR> Port $i /3/1 TO --MTR SW1 --$sw1_slot  / $sw1_port--- ";
			
			
			if ($single_sw==1) {
				$ip_counter=$ip_counter+4;
				$dst_ip="10.".$ip2nd.".0.".$ip_counter."/30";
				$temp_counter=$ip_counter+1;
				$src_ip="10.".$ip2nd.".0.".$temp_counter."/30";
				echo "<BR> Port ".$i." /3/1  IP: $src_ip --------------SINGLE(1)----------TO------------------- --MTR $host_mtr1 --PORT: $sw1_slot  / $sw1_port---IP: $dst_ip - ";

				$host_ftr="SW".$i."-".$bld."-FTR-".$new_name;
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
				 $sql="insert into portmapping values ('FTR','$bld',$ftr_id,'$host_ftr','3','1','$src_ip','MTR','$bld',$mtr_id,'$host_mtr1',$sw1_slot,'$sw1_port','$dst_ip') ";

				echo "<BR> Insert SQL :  $sql <BR>";

				 $result33 = mysql_query($sql)
					or die(mysql_error());	
					
					
					
					
					
					if ($sw1_port==2) {
						$sw1_slot++;
						$sw1_port=1;
						}
					else 	$sw1_port++;
					if ($sw1_slot=='10') $sw1_slot='11';
					if ($sw1_slot=='9' and $bld!='E6') $sw1_slot='11';

				$my_2x10g--;
				$my_10g--;
				$i++;
			

				}
				
			if ($single_sw==2) {
				$ip_counter=$ip_counter+4;
				$dst_ip="10.".$ip2nd.".0.".$ip_counter."/30";
				$temp_counter=$ip_counter+1;
				$src_ip="10.".$ip2nd.".0.".$temp_counter."/30";
				echo "<BR> Port ".$i." /3/1  IP: $src_ip --------------SINGLE(2)----------TO------------------- --MTR $host_mtr2 --PORT: $sw2_slot  / $sw2_port---IP: $dst_ip - ";

				$host_ftr="SW".$i."-".$bld."-FTR-".$new_name;
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
				 $sql="insert into portmapping values ('FTR','$bld',$ftr_id,'$host_ftr','3','1','$src_ip','MTR','$bld',$mtr_id,'$host_mtr2',$sw2_slot,'$sw2_port','$dst_ip') ";

				echo "<BR> Insert SQL :  $sql <BR>";

				 $result33 = mysql_query($sql)
					or die(mysql_error());	
				
				
				if ($sw2_port==2) {
					$sw2_slot++;
					$sw2_port=1;
					}
				else $sw2_port++;
				if ($sw2_slot=='10') $sw2_slot='11';
				if ($sw2_slot=='9' and $bld!='E6') $sw2_slot='11';

				$my_2x10g--;
				$my_10g--;
				$i++;
			
				
				}
			
			
			if ($single_sw==1) $single_sw=2;
			else if ($single_sw==2) $single_sw=1;
			
			

	
			}// if single
			
	$rr--;
	} //while



/*	while ($my_2x10g>0 and $my_10g>0 and $rr>0) {
	echo "<BR>$rr -- my10g:$my_10g  my2x10g: $my_2x10g";
		if ($my_10g-$my_2x10g>0) {
			echo "<BR> Port ".$my_2x10g." /3/1 TO -------- ";
			echo "<BR> Port ".$my_2x10g." /3/2 TO -------- ";
			$my_2x10g--;
			$my_10g--;
			$my_10g--;
			}
		if ($my_10g-$my_2x10g==0) {
			echo "<BR> Port $my_2x10g /3/1 TO -------- ";
			$my_2x10g--;
			$my_10g--;
			}
			
	$rr--;
	}
*/

	

	}


}



function showportmapping($src_type,$dst_type){
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
     $sql="select substr(dst_switch,5,2) as mm , src_switch, src_slot, src_port,src_ip,dst_ip , dst_switch, dst_slot, dst_port ";
     $sql=$sql." from portmapping where src_type='".$src_type."' and dst_type='".$dst_type."' order by 1 desc ,2,3";
     
   
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



echo "</body>";
echo "</html>";

?>
