<?php
session_start();

// Mechanizm logowania
$username = "admin";
$password = "password";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["username"] === $username && $_POST["password"] === $password) {
        $_SESSION["loggedin"] = true;
        header("location: process_reservation.php");
        exit;
    } else {
        $login_error = "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
<h2>Logowanie</h2>
<?php if(isset($login_error)) { echo "<p style='color:red;'>$login_error</p>"; } ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" name="username" id="username" required><br><br>
    <label for="password">Hasło:</label>
    <input type="password" name="password" id="password" required><br><br>
    <input type="submit" value="Zaloguj">
</form>
</body>
</html>