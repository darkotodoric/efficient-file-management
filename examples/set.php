<?php

require '../FileStorage.php';
$fileStorage = new FileStorage();

// Get IDs from MySQL or other data source
$ids = [123456, 987654, 555555];

foreach($ids as $id){
    $data = json_encode(['name' => 'File with ID ' . $id]);
    $fileStorage->saveContent($id,'json', $data);
}