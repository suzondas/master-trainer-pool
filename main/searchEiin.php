<?php
header('Content-Type: application/json; charset=UTF-8');
echo
curlPost('http://192.168.245.36/inhouse-training/services/searchEiin.php', [
    'eiin' => $_POST['eiin']
]);


function curlPost($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error !== '') {
        throw new \Exception($error);
    }

    return $response;
}
?>