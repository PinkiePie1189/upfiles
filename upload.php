<?php
error_reporting(0);
$target_file = "file/" . md5_file($_FILES["file"]["tmp_name"]);

if ($_SERVER['CONTENT_LENGTH'] > 64000000)
    die("Please don't upload files larger than 64MB");

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
    echo "File uploaded: <a href=\"/" . $target_file . "\"> " . $target_file . " </a>";
else
    die("File wasn't uploaded.");
?>