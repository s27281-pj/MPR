<?php

$con = mysqli_connect("localhost","root","","social");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Eclaring variablers to prevent errors
$fname = ""; //Imię
$lname = ""; //nazwisko
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date =""; //data rejestracji
$error_array = ""; //zatrzymuje komunikaty o błędach

if(isset($_POST['register_button'])){

    //Imię
    $fname = strip_tags($_POST['reg_fname']); //usówa tagi HTML
    $fname = str_replace(' ','', $fname); //usówa błędnie dodane spacje
    $fname = ucfirst(strtolower($fname)); //pierwsza litera zawsze wielka, pozostałę zawsze małe

    //Nazwisko
    $lname = strip_tags($_POST['reg_lname']); //usówa tagi HTML
    $lname = str_replace(' ','', $lname); //usówa błędnie dodane spacje
    $lname = ucfirst(strtolower($lname)); //pierwsza litera zawsze wielka, pozostałę zawsze małe

    //Email
    $em = strip_tags($_POST['reg_email']); //usówa tagi HTML
    $em = str_replace(' ','', $em); //usówa błędnie dodane spacje
    $em = ucfirst(strtolower($em)); //pierwsza litera zawsze wielka, pozostałę zawsze małe

    //Email 2
    $em2 = strip_tags($_POST['reg_email2']); //usówa tagi HTML
    $em2 = str_replace(' ','', $em2); //usówa błędnie dodane spacje
    $em2 = ucfirst(strtolower($em2)); //pierwsza litera zawsze wielka, pozostałę zawsze małe

    //Hasło
    $password = strip_tags($_POST['reg_password']); //usówa tagi HTML

    //Hasło 2
    $password2 = strip_tags($_POST['reg_password2']); //usówa tagi HTML

    //Data
    $date = date("Y-m-d"); //aktualna data

    if ($em == $em2) {
        //sprawdzamy, czy email jest poprawny
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            //Sprawdzamy, czy email jest już w bazie
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            //Zliczamy ilość wierszy w odpowiedzi na zapytanie
            $num_rows = mysqli_num_rows($e_check);
            if($num_rows > 0 ) {
                echo "Email już znajduje się w bazie";
            }
        }
        else {
            echo "błędny format emaila";
        }
    }
    else {
        echo "Podano różne hasła";
    }

    if(strlen($fname) > 25 || strlen($fname) < 2 ) {
        echo "Twoje imię musi zawierać się w przedziale 2 i 25 znaków.";
    }

    if(strlen($lname) > 25 || strlen($lname) < 2 ) {
        echo "Twoje nazwisko musi zawierać się w przedziale 2 i 25 znaków.";
    }

    if($password != $password2) {
        echo "Wprowadzono różne hasła";
    }
    else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            echo "Hasło może zawierać jedynie międzynarodowe litery lub liczby";
        }
    }

    if (strlen($password) > 30) {
        echo "Hasło musi zawierać się pomiędzy 5 i 30 znakami";
    } elseif (strlen($password) < 5) {
        echo "Hasło musi zawierać się pomiędzy 5 i 30 znakami";
    }

//    || strlen($password) < 5

}

?>

<html>
<head>
    <title>   Witaj w krypcie!    </title>
</head>
<body>
    <form action="register.php" method="post">
        <input type="text" name="reg_fname" placeholder="First Name" required>
        <br>
        <input type="text" name="reg_lname" placeholder="Last Name" required>
        <br>
        <input type="email" name="reg_email" placeholder="Email" required>
        <br>
        <input type="email" name="reg_email2" placeholder="Confirm Email" required>
        <br>
        <input type="password" name="reg_password" placeholder="Password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
        <br>
        <input type="submit" name="register_button" value="Register">




    </form>
</body>
</html>
