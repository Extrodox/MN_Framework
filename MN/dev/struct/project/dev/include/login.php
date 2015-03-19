<?php
session_start();

$Password = 'admin123'; // Set your password here
    if(!isset($_SESSION['admin'])){
     if (isset($_POST['submit_pwd'])){
        $pass = isset($_POST['passwd']) ? $_POST['passwd'] : '';
        
        if ($pass != $Password) {
           showForm("Wrong password");
           exit();     
        }else{
          $_SESSION['admin']=true;
        }
     } else {

        showForm();
        exit();
     }
   
    }
      
function showForm($error="Developer's Login"){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
   <title>Authentication Required</title>
   <link href="style/style.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
    <div id="main">
      <div class="caption"><?php echo $error; ?></div>
      <div id="icon">&nbsp;</div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="pwd">
        Password:
        <table>
          <tr><td><input class="text" name="passwd" type="password"/></td></tr>
          <tr><td align="center"><br/>
             <input class="text" type="submit" name="submit_pwd" value="Login"/>
          </td></tr>
        </table>  
      </form>
      <div id="source">MN framework</div>
   </div>
   <?php include "back.php"; ?>
</body>       

<?php   
}

?>

