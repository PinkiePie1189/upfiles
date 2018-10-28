<?php
error_reporting(0);
if (file_exists("file") == false)
	mkdir("file");
	
//PUT Handling
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
	$target_file = "file/" . md5_file("php://input");
	$upfile = fopen($target_file, "w");
	
	if (filesize("php://input") > 64000000) {
		die("Please don't upload files larger than 64MB.");
	}
	
	if (fwrite($upfile, file_get_contents('php://input')) != false)
		echo "File uploaded: " . "upfiles.ga/" . $target_file;
	else 
		echo "Could not upload file.";
	
	fclose($upfile);
	die();
}
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
	$target_file = "file/" . md5_file($_FILES["file"]["tmp_name"]);

	if ($_SERVER['CONTENT_LENGTH'] > 64000000) {
		echo "<p style='position: center; margin: auto; width: 350px; margin-top: 2%; font-family: \"Source Sans Pro\",Helvetica,sans-serif;'>Please don't upload files larger than 64MB.</p>";
		die();
	}

	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
		echo "<p style='position: center; margin: auto; width: 350px; margin-top: 2%; font-family: \"Source Sans Pro\",Helvetica,sans-serif;'>File uploaded: <a href=\"/" . $target_file . "\"> " . "upfiles.ga/" . $target_file . " </a></p>";
	else
		echo "<p style='position: center; margin: auto; width: 350px; margin-top: 2%; font-family: \"Source Sans Pro\",Helvetica,sans-serif;'>File wasn't uploaded. </p>";

}
?>
</html>