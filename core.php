<?php
echo "<html>";
echo "<head>";
echo "<title>AutoNet\\ CORE Information</title>";
echo "</head>";
echo "<body bgcolor=#009999 lang=EN-US style='tab-interval:.5in'>";
echo "<P fontsize=15 align=center > AutoNet\\ CORE Information </p>";
echo "<br>";
echo "<br>";

echo "<table border=1 align = center>";
echo "<tr>";
echo "<td>Core Switch</td><td> Get Info </td>";
echo "</tr>";

echo "<tr><form name=form2 method=get action=coreinf.php>";
echo "<td><input name=sw     type=text READONLY value='EarthNET_Core_01'></td>";
echo "<td><input type=submit value=GetInfo></td>";
echo "</tr></form>";

echo "<tr><form name=form2 method=get action=coreinf.php>";
echo "<td><input name=sw     type=text READONLY value='EarthNET_Core_02'></td>";
echo "<td><input type=submit value=GetInfo></td>";
echo "</tr></form>";

echo "<tr><form name=form2 method=get action=coreinf.php>";
echo "<td><input name=sw     type=text READONLY value='SpaceNET_Core_01'></td>";
echo "<td><input type=submit value=GetInfo></td>";
echo "</tr></form>";

echo "<tr><form name=form2 method=get action=coreinf.php>";
echo "<td><input name=sw     type=text READONLY value='SpaceNET_Core_02'></td>";
echo "<td><input type=submit value=GetInfo></td>";
echo "</tr></form>";



echo "</body>";
echo "</html>";

?>
