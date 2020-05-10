<!--
//login.php
!-->

<?php $message="";
if(isset($_POST['username'])){
    session_start();
    include('database_connection.php');

   
        $username=$_POST['username'];
        $password=$_POST['password'];
        $querry="select * from login";
        $res= mysqli_query($con, $querry)or die(mysqli_errno($con));
        $count= mysqli_num_rows($res);
      $i=0;
      $f=1;
        if($count!=0){
        while($i<$count)
        {   $out= mysqli_fetch_array($res)or die(mysqli_errno($con));
            if($username==$out['username'] && $password==$out['password'])
        {    $f=0;
       break;
        }
     $i++;
        }}
        if($f==0){
        $sub_query="
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$out['user_id']."')
        ";
        $res2= mysqli_query($con, $sub_query) ;
        $_SESSION['user_id'] = $out['user_id'];
        $_SESSION['username'] = $out['username'];
        $_SESSION['login_details_id']=$con->insert_id;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (300); 
            header('location: index.php');}
 else
 {
  $message = "<label>Wrong Username or password</label>";
 }
}

?>

<html>  
    <head>  
        <title>Chat Application </title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
   <br />
   
   <h3 align="center">Chat Application </a></h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading">Chat Application Login</div>
    <div class="panel-body">
     <form method="post">
      <p class="text-danger"><?php echo $message; ?></p>
      <div class="form-group">
       <label>Enter Username</label>
       <input type="text" name="username" class="form-control" required />
      </div>
      <div class="form-group">
       <label>Enter Password</label>
       <input type="password" name="password" class="form-control" required />
      </div>
      <div class="form-group">
       <input type="submit" name="login" class="btn btn-info" value="Login" />
      </div>
     </form>
    </div>
   </div>
  </div>
    </body>  
</html>