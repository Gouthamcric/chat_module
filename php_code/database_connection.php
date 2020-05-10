<?php
$con= mysqli_connect("localhost", "root", "", "chat_db")or die(mysqli_errno($con));
date_default_timezone_set('Asia/Kolkata');

function fetch_user_last_activity($user_id, $con)
{
 $query = "
 SELECT * FROM login_details 
 WHERE user_id = '$user_id' 
 ORDER BY last_activity DESC 
 LIMIT 1
 ";
$res=  mysqli_query($con, $query);
$out= mysqli_fetch_array($res);
$count= mysqli_num_rows($res);
if($count==0){return "2020-05-10 00:44:08";/*dummy value*/}
  return $out['last_activity'];
 
 }
 
 function fetch_user_chat_history($from_user_id, $to_user_id, $con)
{$query = 'SELECT * FROM chat_message WHERE (from_user_id = '.$from_user_id.' AND to_user_id = '.$to_user_id.') OR (from_user_id = '.$to_user_id.' AND to_user_id = '.$from_user_id.') ORDER BY timestamp ASC';
$res=  mysqli_query($con, $query);
$count= mysqli_num_rows($res);$i=0;$output='<ul>';

while($i!=$count){$out= mysqli_fetch_array($res);

if($out["from_user_id"] == $from_user_id){
   $output .='<li class="sent"><p>'.$out['chat_message'].'</p></li>';}
  else{$output .='<li class="replies"><p>'.$out['chat_message'].'</p></li>';
  }
$i++;
 }
$output .='</ul>';
$query = "
 UPDATE chat_message 
 SET status = '0' 
 WHERE from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."' 
 AND status = '1'
 ";
mysqli_query($con, $query);

 return $output;
}
function count_unseen_message($from_user_id, $to_user_id, $con)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";
$res=  mysqli_query($con, $query);

$count = mysqli_num_rows($res);
 $output = '';
 if($count > 0)
 {
  $output = '<span class="label label-success">'.$count.'</span>';
 }
 return $output;
}


