<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Form</title>
	</head>
	<body>
		<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
			<form action="gotcha.php" method="post">
				Name: <input type="text" name="name"><br>
				E-mail: <input type="text" name="email"><br>
				<input type="submit">
			</form>

		<?php echo $_POST["name"]; ?><br>
		<?php echo $_POST["email"]; ?>
	</body>
</html>