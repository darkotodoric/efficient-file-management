<?php

require '../FileManagement.php';
$fileManagement = new FileManagement();

// Get IDs from MySQL or other data source
$ids = [123456, 987654, 555555];

foreach($ids as $id){
    $json = $fileManagement->getContent($id, 'json');
    if(empty($json)){
        echo 'ID: ' . $id . ' | JSON: Not found' . PHP_EOL;
        continue;
    }

    echo 'ID: ' . $id . ' | JSON: ' . $json . PHP_EOL;
}