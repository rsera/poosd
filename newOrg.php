
<!DOCTYPE html>
<html>
    <head>

    <title>Register Your Organization</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="css/styles.css" rel="stylesheet">
    <link href="css/signUp.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    </head>

    <body>

        <!-- Top Banner Start -->
        <!--Putting "navbar-fixed-top" at the top keeps the navbar fixed as you scroll the page-->
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <!-- no "collapsed" and no "aria-expanded="false"" in button class below-->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <!-- no "data-target="home" id="vtrakButton""-->
                    <a class="navbar-brand" href="index.php" data-target="home" id="vtrakButton">vTrak</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <!-- no "navbar-right" at end of ul quotes-->
                    <ul class="nav navbar-nav navbar-right">
                      <li><a href="index.php" id="homeRibbon">Home</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Top Banner End -->


        <section class="orgRegPage">
            <div class="inner">
                <div class="orgRegRespDiv">
                                <br>
                                <h1>Thank you</h1>
                                <h4>You will receive an email from us shortly</h4>
                </div>
            </div>
          </section>


        <style>
            @font-face{font-family: sanssaFont;src:url(CSS/Sansation_Regular.ttf)};
        </style>


        <?php
                // Handle new user signup input, insert into database, save hashed password
                require_once "dbinit.php";

                // Store username and password from form submission
                $orgName =  mysqli_real_escape_string($conn, $_POST['orgName']);
                $orgZip = mysqli_real_escape_string($conn, $_POST['orgZip']);
                $orgWebsite = mysqli_real_escape_string($conn, $_POST['orgWebsite']);
                $conName = mysqli_real_escape_string($conn, $_POST['conName']);
                $conEmail = mysqli_real_escape_string($conn, $_POST['conEmail']);

                // Check for error in connection
                if ($conn->connect_error)
                {
                    // Handle connection error
                    echo $conn->connect_error . "fail whale";
                }

                // Connection successful
                else
                {

                    // Make sql query string
                    $sql = "INSERT INTO organizations(orgName, orgZip, orgWebsite, conName, conEmail)
                                VALUES('" . $orgName . "','". $orgZip . "','" . $orgWebsite . "','" . $conName . "','" . $conEmail . "')";

                    if (!$conn->query($sql) == TRUE)
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    $conn->close();
                    die();
                }
        ?>


    </body>
</html>
