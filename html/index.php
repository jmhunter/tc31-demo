<html>
<head>
<?php
	$tmp = error_reporting(); error_reporting(0);
	$conn = new mysqli($_ENV['DB_HOSTNAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DB']);
	error_reporting($tmp);

	if ($conn->connect_error) {
		$err .= "Could not connect to database: " . $conn->connect_error;
	}

	$redirect=0;
	if ($_GET['delete']) {
		if ($statement = $conn->prepare("DELETE FROM demo WHERE id=?") ) {
			if ($statement->bind_param("i", $_GET['delete'])) {
				if ($statement->execute()) {
					$redirect=1;
				} else {
					$err.= "Could not insert new record. ";
				}
			} else {
				$err.= "Could not bind parameters for insert. ";
			}
		} else {
			$err.= "Could not prepare insert statement. ";
		}
	}

	if ($_POST['item']) {
		if ($statement = $conn->prepare("INSERT INTO demo (data) VALUES (?)") ) {
			if ($statement->bind_param("s", $_POST['item'])) {
				if ($statement->execute()) {
					$redirect=1;
				} else {
					$err.= "Could not insert new record. ";
				}
			} else {
				$err.= "Could not bind parameters for insert. ";
			}
		} else {
			$err.= "Could not prepare insert statement. ";
		}
	}

	if ($redirect) {
		echo "<meta http-equiv=\"refresh\"; content=\"0; URL=".$_SERVER['PHP_SELF']."\">\n";
		// header("Status: 302 Moved");
		// header("Location: " . $_SERVER['PHP_SELF']);
	}
?>
	<title>TC31 Demo App</title>
</head>
<body>
<H1><center>Demo Application</center></H1>

<?php if ($err) { echo "<p style=\"color:red; font-weight:bold; font-family:monospace\">" . $err . "</p>\n"; } ?>

<P>This demo application is running on node <B><?php echo $_ENV['RUNNING_HOSTNAME']; ?></B></P>

<form method=post>
	New item: <input type=text name=item>
	<input type=submit value="Add">
</form>

<hr>
<H3><center>Current entries</center></H3>

<?php
	// Show contents
	if (!$conn->connect_error)
		$res = $conn->query("SELECT * FROM demo");

	if ($res->num_rows) {
		$res->data_seek(0);
		while ($row = $res->fetch_assoc()) {
			echo "<P>" .
				"(<a href=\"?delete=".htmlentities($row['id'])."\">Delete</a>) ".
				htmlentities($row['data']) .
				"</P>\n";
		}
	} else {
		echo "Database is currently empty";
	}

?>
</body>
</html>
