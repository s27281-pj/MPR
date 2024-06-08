<?php
session_start();

$validUsername = 'admin';
$validPassword = 'admin123';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == $validUsername && $password == $validPassword) {
        $_SESSION['logged_in'] = true;
        header("Location: reservation.html");
        exit();
    } else {
        echo "<p>Invalid username or password</p>";
    }
}
?>
