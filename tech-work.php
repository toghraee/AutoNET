<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ Physical Installation Work Order </title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center>";
echo " AutoNet\\ Physical Installation Work Order</p>";
echo "<br>";
echo "<p align=center><font size=48 color=NAVY> Physical Installation Work Order";

$room_id=$_GET['room_id'];
$room_type=$_GET['room_type'];
$bld=$_GET['bld'];

//echo substr($bld,0,1);

if ($room_type=='MTR') {
	if (substr($bld,0,1)=='A') build_mtr_a($bld);
}

if ($room_type=='FTR') {
	if (substr($bld,0,1)=='A') build_ftr_a($bld);
}

 




function build_mtr_a($bld){


echo "<BR><font size=48 color=NAVY>Building:".$bld."  Physical Installation WorkOrder </font></p>";

 
echo "</font></font><p>";

echo "1- Collect all switches of this Building";
echo "<BR>"; 
echo "2- Collect all power cables (Total number of siwtches x 2) - 2";
echo "<BR>";
echo "3- Collect the drawings";
echo "<BR>";
echo "4- Move the equipment for building $bld";
echo "<BR>";
echo "5- (INSIDE THE MTR)";
echo "<BR>";
echo "6- Remove side racks of IT racks";
echo "<BR>";
echo "7- Mount switches in the IT rack which already have the SingleMode fiber patch panel installed leave 2Units after last device in rack";
echo "<BR>";
echo "8- Keep 1 U free space between switches";
echo "<BR>";
echo "9- connect stacking cable between switches";
echo "<BR>";
echo "10- connect switches to power";
echo "<BR>";
echo "11- Test turning on the switches";
echo "<BR>";
echo "12- swicth off the PDU is test was successfull or not";
echo "<BR>";
echo "13- Collecting information :";
echo "<BR>";
echo "14- Analyzers  Number of ports and free ports";
echo "<BR>";
echo "15- 24 core singlemode fiber A is it available and terminated in patch panel?";
echo "<BR>";
echo "16- 24 core singlemode fiber B is it available and terminated in patch panel?";
echo "<BR>";
echo "17- Write Room number and AFC number";
echo "<BR>";
}// function




function build_ftr_a($bld){


echo "<BR><font size=48 color=NAVY>Building:".$bld."  Physical Installation WorkOrder </font></p>";

 
echo "</font></font><p>";

echo "1- Collect all switches of this Building";
echo "<BR>"; 
echo "2- Collect all power cables (Total number of siwtches x 2) - 2";
echo "<BR>";
echo "3- Collect the drawings";
echo "<BR>";
echo "4- Move the equipment for building $bld";
echo "<BR>";
echo "5- (INSIDE THE FTR)";
echo "<BR>";
echo "6- Mount switches in the IT rack  leave 2Units after last device in rack";
echo "<BR>";
echo "7- Keep 1 U free space between switches";
echo "<BR>";
echo "8- connect stacking cable between switches ";
echo "<BR>";
echo "9- If no stacking is required, copllect the un-used stackimg cables and bring it back to warehouse";
echo "<BR>";
echo "10- connect switches to power";
echo "<BR>";
echo "11- Test turning on the switches";
echo "<BR>";
echo "12- swicth off the PDU is test was successfull or not";
echo "<BR>";
echo "13- Collecting information :";
echo "<BR>";
echo "14- Analyzers  Number of ports and free ports";
echo "<BR>";
echo "15- Number of Copper Patch Panels";
echo "<BR>";
echo "16- Number of Passive Ports";
echo "<BR>";
echo "17- Write Room number and AFC number";
echo "<BR>";
echo "18- Write the FIBER LABEL  (should be something similar to L0 FTR2)  !Very Important! ";
echo "<BR>";
echo "19- check vertical and horizontal cable managers are in place.";
echo "<BR>";




}// function

?>
