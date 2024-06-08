<?php

$con = mysqli_connect("localhost","root","","social");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$query = mysqli_query($con,"INSERT INTO test VALUES(NULL,'Cyprian')");

?>

<html>
<head>
    <title>        Feed    </title>
</head>
<body>
Hej Cyp!
</body>
</html>
