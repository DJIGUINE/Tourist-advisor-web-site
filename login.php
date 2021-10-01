<?php require_once('Connections/tourisme.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['txtusername'])) {
  $loginUsername=$_POST['txtusername'];
  $password=$_POST['txtpassword'];
  $MM_fldUserAuthorization = "usertype";
  $MM_redirectLoginSuccess = "adminviewuser.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_tourisme, $tourisme);
  	
  $LoginRS__query=sprintf("SELECT customername, password, usertype FROM customer WHERE customername=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $tourisme) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'usertype');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>


  <?php 




@$txtusername=$_POST['txtusername']; 
@$txtpassword=$_POST['txtpassword']; 
;


@$totalprice=$price*$numroom*$numday;





?>;</p>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet"   href="footer.css" type="text/css" />
<link rel="stylesheet" href="styles.css">
</head>

<body>
<div align="center">
  <h1>AVELON TRIP ADVISOR</h1>
  <p>&nbsp;</p>
</div>
<p align="center"><img src="images/86690725-belle-chute-d-eau-sala-près-de-labe-avec-des-arbres-piscine-verte-et-beaucoup-d-écoulement-de-l-39.jpg" onmouseover="this.src='images/1200x630_100_300_000000x30x0.jpg'  " width="1161" height="410" /></p>
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="login.php">hotel boking</a>  </li>
  <li><a href="login.php">car booking</a></li>
  <li><a href="login.php">product </a></li>
  <li><a href="login.php">login</a></li>
  <li><a href="signup.php">sign up</a></li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center" id="body">
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <div align="center">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="200" border="0">
      <tr>
        <td height="44"><p align="center">Username</p></td>
        <td><label for="txtusername2"></label>
          <input type="text" name="txtusername" id="txtusername2"  placeholder="full name please"required="required"/></td>
      </tr>
      <tr>
        <td height="29"><p align="center">Password</p></td>
        <td><label for="txtpassword"></label>
          <input type="password" name="txtpassword" id="txtpassword"  placeholder="***********" required="required" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center">
          <input type="submit" name="txtbutom" id="txtbutom" value="Log In" />
        </div></td>
      </tr>
    </table>
  </div>
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>


<div align="center" id="footer">
  <h1>&nbsp;</h1>
  <h1>&nbsp;</h1>
  <h1>LET'S GET SOCIALL</h1>
  <h3>FOLOW US ON YOUTUBE ON INSTAGRAME OR BECOME OUR FRIEND ON FACBOOK   </h3>
  <p>&nbsp;</p>
  <table width="200" border="0">
    <tr>
      <td height="267"><p><a href="https://www.youtube.com/channel/UCAd-iarQzJ2jZ7qghS7TD-Q"><img src="images/index.png" width="99" height="100" alt="facebook" /></a></p></td>
      <td><a href="https://www.instagram.com/ansdjiguine/"><img src="images/QVxuHzpM_400x4001.png" width="100" height="100" alt="ins" /></a></td>
      <td><a href="https://www.facebook.com/ansoumane.djiguine"><img src="images/facebook-icon-white-logo-png-transparent.png" width="96" height="100" alt="t" /></a></td>
    </tr>
  </table>
  
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>