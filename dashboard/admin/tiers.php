<?php
include('header.php');

//    ----------Country Search and tiers settings ---------------------
if (isset($_POST['sub_cntrset'])) {
    foreach (array_keys($_POST['cnt_tiers']) as $salis) {
        mysql_query("UPDATE list_countries SET tiers = ".$_POST['cnt_tiers'][$salis]." WHERE id = '$salis' ") or die (mysql_error());    
    }
}


?>	
<div class="content">
<CENTER>
<TABLE style="FONT-SIZE: 9pt; FONT-FAMILY: Verdana; BORDER-COLLAPSE: collapse" borderColor=#111111 cellSpacing=0 
borderColorDark=#ffffff cellPadding=3 width=733 bgColor=#ebebeb borderColorLight=#ffffff border=1>




    <tr>
    <td >
   
    <P align=center><br><span class=goldname><u><b>Setup Country tiers</b></u></span><br /><br />
    
    <table width=450 class=cheat style="FONT-WEIGHT: bold; font-family:Verdana; font-size: 9pt"  bgcolor=white cellSpacing="1" cellPadding="2" align="center" border="0">
    <FORM action=tiers.php method=post>
  <tr bgColor="#c0c0c0" align=center>
    <td rowspan="2" width=*><a href=tiers.php?cnord=country>Country</td>
    <td colspan="4" ><a href=tiers.php?&cnord=tiers>tiers</td>
  </tr>
  <tr bgColor="#c0c0c0" align=center>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
  </tr>
  <?php
  function checkt($tiers) {
    global $row;
    if ($row['tiers'] == $tiers) return "checked";
    
  }

  
if (!isset($_GET['cnord'])) $order='tiers'; 
else if ($_GET['cnord'] == 'country') $order = $_GET['cnord'];
else $order = $_GET['cnord']." DESC";
$query = mysql_query("SELECT * FROM list_countries WHERE id>0 ORDER BY ".$order); $set=0;
while ($row = mysql_fetch_array($query)) {
  echo "
    <tr bgcolor=#F1F1E0 align=center>
    <td>".$row['country']."</td>
    <td><input type=radio ".checkt(1)." name=cnt_tiers[".$row['id']."] value=1></td>
    <td><input type=radio ".checkt(2)." name=cnt_tiers[".$row['id']."] value=2></td>
    <td><input type=radio ".checkt(3)." name=cnt_tiers[".$row['id']."] value=3></td>
    <td><input type=radio ".checkt(4)." name=cnt_tiers[".$row['id']."] value=4></td>
  </tr>";
  $set++;
}
  ?>
  <tr bgColor="#c0c0c0" align=center>
    <td colspan=6><hr width='90%' color=#FFFFFF></td>  
  </tr>
  <tr bgColor="#F1F1E0" align=center valign=middle height=50>
    <td colspan=6><input type=submit value='Update' name=sub_cntrset></td>  
  </tr>
    </table>
    </form><br></p>

</td></tr></table>

</div>