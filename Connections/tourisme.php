<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_tourisme = "localhost";
$database_tourisme = "tourisme";
$username_tourisme = "root";
$password_tourisme = "";
$tourisme = mysql_pconnect($hostname_tourisme, $username_tourisme, $password_tourisme) or trigger_error(mysql_error(),E_USER_ERROR); 
?>