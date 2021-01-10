<?php 
// DB credentials.
define('DB_HOST','192.254.190.210');
define('DB_USER','banbeis');
define('DB_PASS','hm*Fnw#N4L');
define('DB_NAME','banbeis_mtpool');

//$servername = "192.254.190.210";
//$username = "banbeis";
//$password = "hm*Fnw#N4L";
//$db = "banbeis_mtpool";
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>