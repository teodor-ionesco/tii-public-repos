<?php

if(!empty($_FILES['f_name']))
{
	$db = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', 'root'); // New database connection
	$fh = fopen($_FILES['f_name']['tmp_name'], 'rb'); // Open temp file for read (r) in binary (b) mode
	
	$prepare = $db -> prepare('INSERT INTO files(file) VALUES(:file);');
	$prepare -> execute([
		':file' => fread($fh, filesize($_FILES['f_name']['tmp_name'])) // Bind file content to ':file'
	]);

	fclose($fh); // Close fopen stream.
}

?>
<html>
	<form method="POST" enctype="multipart/form-data">
		<input name="f_name" type="file" required="">
		<input type="submit">
	</form>
</html>