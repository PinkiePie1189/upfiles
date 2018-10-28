<?php
$Lifetime = 6 * 3600;
$MaxFilesize = 64000000;

$FileSizeError = -1;
$FileWriteError = -2;

$HTML_DefaultTextStyle = "<p style='position: center; margin: auto; width: 350px; margin-top: 2%; font-family: \"Source Sans Pro\",Helvetica,sans-serif;'>";

error_reporting(0);
if (file_exists("file") == false) {
	mkdir("file");
	fwrite(fopen("file/.htaccess", "w"), "RemoveHandler .php .phtml .php3\nRemoveType .php .phtml .php3\nphp_flag engine off");
}

function uploadFile ($tempname, $filename) {
	if (filesize($tempname) > $GLOBALS['MaxFilesize']) {
		return -1;
	}
	
	$filename = preg_replace("/[^a-zA-Z0-9._]+/m", "-", $filename);
	$hash = substr(md5_file($tempname), 0, 6);
	if (file_exists("file/" . $hash) == false)
		mkdir ("file/" . $hash);
	
	$target_file = "file/" . $hash . '/' . $filename;
	$upfile = fopen($target_file, "w");
	
	if (fwrite($upfile, file_get_contents($tempname)) != false) {
		//$txt = $hash . " " . (time() + $GLOBALS['Lifetime']);
		//file_put_contents('KillLog.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		//fclose($upfile);
		return $target_file;
	} else
		return -2;
}

//PUT Handling
/*if($_SERVER['REQUEST_METHOD'] == 'PUT') {
	$responsecode = uploadFile("php://input");
	
	if ($responsecode == $FileSizeError) {
		echo "Please upload files smaller than: " . $MaxFileSize . " Bytes.\n";
	} else if ($responsecode == $FileWriteError) {
		echo "File was not uploaded.\n";
	} else {
		echo "File Uploaded: upfiles.ga/" . $responsecode . "\n";
	}
}*/
?>

<!DOCTYPE html>
<html>
<head>
<title> UpFiles: Minimalist File Upload Service </title>
</head>

<div style ="background-color: #F6F8F8; padding: 0px; margin: 0px; width: 100%; height: 80px">
<a style="position: absolute; text-decoration: none; padding: 0px; margin: 0px;" href="/">
	<h1 style='font-family: "Source Sans Pro",Helvetica,sans-serif; position: center; margin-top: 14%; color: #3b3b3b; margin-left: 20%'>upfiles.ga</h1>
</a>
</div>

<div style ="position: center; margin: auto; width: 350px; margin-top: 10%; background-color: #F6F8F8; outline: 5px solid #85B4B9; border: 5px solid #F6F8F8">
<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload File" name="submit">
</form>
</div>

<?php
if ($_FILES["file"] != null) {
	$responsecode = uploadFile($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
	
	if ($responsecode == $GLOBALS['FileSizeError']) {
		echo $HTML_DefaultTextStyle . "Please upload files smaller than: " . $MaxFileSize . " Bytes.</p>";
	} else if ($responsecode == $GLOBALS['FileWriteError']) {
		echo $HTML_DefaultTextStyle . "File was not uploaded.</p>";
	} else {
		echo $HTML_DefaultTextStyle . "File Uploaded: <a href=\"" . $responsecode . "\">" . "upfiles.ga/" . $responsecode . "</a></p>";
	}
}
?>
</html>