<?php

require '../FileManagement.php';
$fileManagement = new FileManagement();

// Get IDs from MySQL or other data source
$ids = [123456, 987654, 555555];

foreach($ids as $id){
    $data = json_encode(['name' => 'File with ID ' . $id]);
    $fileManagement->deleteContent($id, 'json');
}