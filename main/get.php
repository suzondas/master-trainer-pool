<?php

// Connects to the XE service (i.e. database) on the "localhost" machine
$conn = oci_connect('BANBEISLIVE2018', 'BANBEISLIVE2018', '192.168.245.42:1521/ORCL');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
 header('Content-Type: application/json; charset=UTF-8');
$sql = oci_parse($conn, "select I.DIVISION_NAME, I.DISTRICT_NAME,I.THANA_NAME,T.INSTITUTE_TYPE_NAME,I.INSTITUTE_NAME_NEW 
from institutes_loc_name_view i,INSTITUTES_TYPES t where I.INSTITUTE_TYPE_ID=T.INSTITUTE_TYPE_ID and EIIN = :eiin");

$compiled = oci_parse($conn, $sql);
oci_bind_by_name($compiled, ':eiin', $_POST['eiin']);
oci_execute($compiled);


$rows = array();
while ($row = oci_fetch_array($compiled, OCI_ASSOC+OCI_RETURN_NULLS)) {
    
   $rows[] = $row;
   
}
print json_encode($rows);


?>