<?php

// Fetch file from database 
$db = new PDO('mysql:host=127.0.0.1; dbname=test', 'root', 'root');
$data = $db -> query('SELECT file FROM files ORDER BY id DESC LIMIT 1;');
$data = $data -> fetch(PDO::FETCH_ASSOC)['file'];

// $data = pack($data) // if column is BLOB, data is retrieved as binary by default, so there is no need to 'pack()' it: php.net/pack

header('Content-Type: image/jpeg', true); // I have used a jpeg image for this test
header('Content-Length: ' . strlen($data) , true); // Reply content length

print($data); // Output data to client