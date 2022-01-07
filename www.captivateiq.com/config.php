
<?php
define('DBSERVER', 'sql304.epizy.com'); // Database server
define('DBUSERNAME', 'epiz_29444213'); // Database username
define('DBPASSWORD', 'ZxLmlQjOeZW'); // Database password
define('DBNAME', 'epiz_29444213_testlogin'); // Database name
 
/* connect to MySQL database */
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
 
// Check db connection
if($db === false){
    die("Error: connection error. " . mysqli_connect_error());
}
?>
