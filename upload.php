<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) 
{
    $file = $_FILES['file'];

    // file will be uploaded to the following folder
    $uploadDir = 'uploads-assets/';

    // unique file name generated
    // $fileName = uniqid() . '_' . $file['name'];
    $fileName = $file['name'];

    // moving the uploaded file from temp location to our target location
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
        echo 'File uploaded successfully.';
    } else {
        echo 'Failed to upload file.';
    }
}
