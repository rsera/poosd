<?php

	// Handle new user signup input, insert into database, save hashed password
  include "header.php";

  $json = file_get_contents('php://input');
  $obj = json_decode($json, TRUE);


	// Store username and password from form submission
	$FName =  mysqli_real_escape_string($conn, $obj['FName']);
	$LName = mysqli_real_escape_string($conn, $obj['LName']);
  $zip = mysqli_real_escape_string($conn, $obj['zip']);
  $username = mysqli_real_escape_string($conn, $obj['username']);
	$goal = mysqli_real_escape_string($conn, $obj['goal']);
  $pass = mysqli_real_escape_string($conn, $obj['PWHash']);
  $pass2 = mysqli_real_escape_string($conn, $obj['PWHash2']);

	// Check if passwords are equal
	// If wrong,  redirect back to home
	if($pass != $pass2)
	{
		//header("Location: /?default=signup&fname=".$FName."&lname=".$LName."&username=".$username."&goal=".$goal."&error=Passwords don't match.");
		die();
	}

	// Check for error in connection
	if ($conn->connect_error)
	{
		// Handle connection error
		echo $conn->connect_error . "fail whale";
	}

	// Connection successful

	// Check if account already exists for this user.
	// If so, redirect back to sign in page
	$sql = "SELECT username FROM user WHERE username = '". $username . "'";
	$usernameCheck = mysqli_query($conn, $sql);

	if (mysqli_num_rows($usernameCheck) > 0)
	{
		// Invalid - Username exists in table already, go to Login
		//header("Location: /?default=signup&fname=".$FName."&lname=".$LName."&username=".$username."&goal=".$goal."&error=Username already exists.");
		die();
	}


	// Valid username, insert new user
	else
	{
		// Make hashed version of password using bcrypt
		$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

		// Make sql query string
		$sql = "INSERT INTO user(FName, LName, userZip, goal, username, userPWHash)
					VALUES('" . $FName . "','". $LName . "','" . $zip . "','" . $goal . "','" . $username . "','" . $hashedPass . "')";

		if (!$conn->query($sql) == TRUE)
		{
    		echo "Error: " . $sql . "<br>" . $conn->error;
		}

		// Obtain UserID of newly created user
		$userIDQuery = "SELECT UserID, userPWHash FROM user WHERE username='" . $username . "'";

		$userIDResult = $conn->query($userIDQuery);
		$validID = $userIDResult->fetch_assoc();
		$userID = $validID["UserID"];
		$retrievedHash = $validID["userPWHash"];

    $placeholder = "INSERT INTO experiences(userID, name, expDate, hours, notes)
      VALUES('$userID', 'Start Volunteering!', '0000-00-00', '0', 'Your volunteering events will show up here.')";

    if($placer = $conn->query($placeholder) == TRUE)
      echo "inserted";
    else
      echo "failed placeholder";

		if(password_verify($pass, $retrievedHash))
		{

			$sql = "INSERT INTO sessions(userID, sessionID) VALUES('".$userID."', UUID())";
			if ($result = $conn->query($sql) == TRUE)
			{
				$sql = "SELECT sessionID FROM sessions WHERE userID = '".$userID."' ORDER BY lastActivity DESC LIMIT 1";
				$result = $conn->query($sql);
				if ($result->num_rows > 0)
				{
          echo "signed up";
					$result = $result->fetch_assoc();
					setcookie("vtrakSession", $result["sessionID"], time() + (86400 * 30), "/"); // (86400 * 30) is to expire after 30 days -- can modify if desired
					setcookie("vtrakUser", $userID, time() + (86400 * 30), "/"); // (86400 * 30) is to expire after 30 days -- can modify if desired
					$_SESSION["UserID"] = $userID;
					$loginFlag = true;
				}
			}
		}
		$conn->close();
		die();
	}
?>
