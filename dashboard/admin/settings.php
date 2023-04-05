<?php
include('header.php');
if(isset($_POST['update'])) {

mysql_query("UPDATE settings SET `site_name`='".$_POST['site_name']."', `site_description`='".$_POST['site_desc']."', `site_url`='".$_POST['site_url']."', `site_email`='".$_POST['site_email']."', `ref_percent`='".$_POST['ref_percent']."', `pay_min`='".$_POST['pay_min']."', `paypal_status`='".$_POST['paypal_status']."', `payza_status`='".$_POST['payza_status']."', `creditt`='".$_POST['creditt']."', `emailv`='".$_POST['emailv']."'  ") or die(mysql_error());

}
if(isset($_POST['update1'])) {
mysql_query("UPDATE settings SET `tier1`='".$_POST['tier1']."', `tier2`='".$_POST['tier2']."', `tier3`='".$_POST['tier3']."', `tier4`='".$_POST['tier4']."' ") or die(mysql_error());
}
if(isset($_POST['update2'])) {
mysql_query("UPDATE settings SET `pex`='".$_POST['pex']."', `minpex`='".$_POST['minpex']."' ") or die(mysql_error());
}			
?>
<div class="content">
<div class="setbox">
<center><h3>General</h3></center>
<form action=""  method="post" style="padding:50px;">
<label>Site name :</label>
<input placeholder="Site Name" value="<?php echo $site['site_name']?>" name="site_name" required/>
<label>Site Desc :</label>
<input placeholder="Site Description" value="<?php echo $site['site_description']?>" name="site_desc" required/>
<label>Site Url :</label>
<input placeholder="Site Url" value="<?php echo $site['site_url']?>" name="site_url" required/></br><small>(ex: " http://skillerzforum.com ")</small></br>
<label>Site Email :</label>
<input placeholder="Site Email" value="<?php echo $site['site_email']?>" name="site_email" required/>
<label>Referral earnings(%) :</label>
<input placeholder="Referral earnings in %" value="<?php echo $site['ref_percent']?>" name="ref_percent" required/>
<label>Min payout :</label>
<input placeholder="Min Payout" value="<?php echo $site['pay_min']?>" name="pay_min" required/>
<label>Paypal :</label>
<input placeholder="0 or 1" value="<?php echo $site['paypal_status']?>" name="paypal_status" required/></br><small>(0=disabled, 1=enabled)</small></br>
<label>Payza :</label>
<input placeholder="0 or 1" value="<?php echo $site['payza_status']?>" name="payza_status" required/>
<label>Wait Time(seconds) :</label>
<input placeholder="Time in seconds" value="<?php echo $site['creditt']?>" name="creditt" required/>
<label>Email verification :</label>
<input placeholder="Time in seconds" value="<?php echo $site['emailv']?>" name="emailv" required/></br><small>(0=disabled, 1=enabled)</small></br>
<input style="margin-left:45px;" type="submit" value="Update" name="update" />

</form>

</div>

<div class="setbox1">
<center><h3>Credits for tiers</h3></center>
<form action=""  method="post" style="padding:50px;">
<label>Tier 1 :</label>
<input placeholder="Credits for tier 1" value="<?php echo $site['tier1']?>" name="tier1" required/>
<label>Tier 2 :</label>
<input placeholder="Credits for tier 2" value="<?php echo $site['tier2']?>" name="tier2" required/>
<label>Tier 3 :</label>
<input placeholder="Credits for tier 3" value="<?php echo $site['tier3']?>" name="tier3" required/>
<label>Tier 4 :</label>
<input placeholder="Credits for tier 4" value="<?php echo $site['tier4']?>" name="tier4" required/>

<input style="margin-left:45px;" type="submit" value="Update" name="update1" />

</form>
</div>

<div class="setbox2">
<center><h3>Exchange settings</h3></center>
<form  action=""  method="post" style="padding:50px;">
<label>Exchange rate(per point) :</label>
<input placeholder="1 point = ?" value="<?php echo $site['pex']?>" name="pex" required/>
</br><small>(min rate 1 point =0.00001)</small></br>
<label>Min points(To convert) :</label>
<input placeholder="Credits for tier 2" value="<?php echo $site['minpex']?>" name="minpex" required/>

<input style="margin-left:45px;" type="submit" value="Update" name="update2" />

</form>
</div>




</div>