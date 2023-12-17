<?php

require 'FileStorage.php';
$fileStorage = new FileStorage();

// Get IDs from MySQL or other data source
$ids = [123456, 987654, 555555];

foreach($ids as $id){
    $json = $fileStorage->getContent($id, 'json');
    if(empty($json)){
        continue;
    }

    // Do something with the JSON
}