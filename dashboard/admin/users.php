<?php
include('header.php');
if(isset($_POST['search'])){
$pid = mysql_real_escape_string($_POST['user']);
$sql = mysql_query(" SELECT * from users where `id`='".$pid."' or `login`='".$pid."' ");
$check = mysql_num_rows($sql);
 if($check != 0){
  $msg="<center>Found the user!</center>";
  redirect("edit.php?user=".$pid." ");
 }else{
 $msg="<center>Cannot find the user with that username.</center>";
 }
}





?>
<?php echo $msg?>
<div class="content">
<form style="width:100%;text-align:center;margin-top:100px;" action="" method="post">
<input type="text" placeholder="Username or id" value="" name="user"  required />
<input type="submit" value="Search" name="search" >


</form>
</div>