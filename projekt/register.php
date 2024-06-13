<?php
session_start();
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
$error_array = array(); //zatrzymuje komunikaty o błędach

if(isset($_POST['register_button'])){

    //Imię
    $fname = strip_tags($_POST['reg_fname']); //usówa tagi HTML
    $fname = str_replace(' ','', $fname); //usówa błędnie dodane spacje
    $fname = ucfirst(strtolower($fname)); //pierwsza litera zawsze wielka, pozostałę zawsze małe
    $_SESSION['reg_fname'] = $fname; //trzyma zmienne

    //Nazwisko
    $lname = strip_tags($_POST['reg_lname']); //usówa tagi HTML
    $lname = str_replace(' ','', $lname); //usówa błędnie dodane spacje
    $lname = ucfirst(strtolower($lname)); //pierwsza litera zawsze wielka, pozostałę zawsze małe
    $_SESSION['reg_lname'] = $lname; //trzyma zmienne


    //Email
    $em = strip_tags($_POST['reg_email']); //usówa tagi HTML
    $em = str_replace(' ','', $em); //usówa błędnie dodane spacje
    $em = ucfirst(strtolower($em)); //pierwsza litera zawsze wielka, pozostałę zawsze małe
    $_SESSION['reg_email'] = $em; //trzyma zmienne


    //Email 2
    $em2 = strip_tags($_POST['reg_email2']); //usówa tagi HTML
    $em2 = str_replace(' ','', $em2); //usówa błędnie dodane spacje
    $em2 = ucfirst(strtolower($em2)); //pierwsza litera zawsze wielka, pozostałę zawsze małe
    $_SESSION['reg_email2'] = $em2; //trzyma zmienne


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
                array_push($error_array, "Email już znajduje się w bazie<br>");
            }
        }
        else {
            array_push($error_array, "błędny format emaila<br>");
        }
    }
    else {
        array_push($error_array, "Podano różne emaile<br>");
    }

    if(strlen($fname) > 25 || strlen($fname) < 2 ) {
        array_push($error_array, "Twoje imię musi zawierać się w przedziale 2 i 25 znaków.<br>");
    }

    if(strlen($lname) > 25 || strlen($lname) < 2 ) {
        array_push($error_array, "Twoje nazwisko musi zawierać się w przedziale 2 i 25 znaków.<br>");
    }

    if($password != $password2) {
        array_push($error_array, "Wprowadzono różne hasła<br>");
    }
    else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Hasło może zawierać jedynie międzynarodowe litery lub liczby<br>");
        }
    }

    if (strlen($password) > 30) {
        array_push($error_array, "Hasło musi mieć mniej niż 30 znaków<br>");
    } elseif (strlen($password) < 5) {
        array_push($error_array, "Hasło musi mieć więcej niż 5 znaków<br>");
    }

    if(empty(@$error_array)) {
        $password = md5($password); //Haszowanie hasła przed wysłaniem hasła do bazy danych

        //Generowanie nazwy użytkownika
        $username = strtolower($fname . "_". $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i = 0;
        //jeżeli nazwa użytkownika nie jest unikalna, dodaje kolejny numer do nazwy użytkownika.
        while(mysqli_num_rows($check_username_query) !=0 ) {
            $i++; //kolejna liczba
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        //Przydzielenie zdjęcia profilowego
        $rand = rand(1, 5); // Losowa liczba od 1 do 5. Potrzebujemy jej do wylosowania zdjęcia profilowego.

        if($rand == 1) {
            $profile_pic = "assets/images/profile_pics/defaults/blue_r.png";
        } else if ($rand == 2) {
            $profile_pic = "assets/images/profile_pics/defaults/green_r.png";
        } else if ($rand == 3) {
            $profile_pic = "assets/images/profile_pics/defaults/yellow_r.png";
        } else if ($rand == 4) {
            $profile_pic = "assets/images/profile_pics/defaults/red_r.png";
        } else if ($rand == 5) {
            $profile_pic = "assets/images/profile_pics/defaults/pink_r.png";
        }

        $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',' )");
        array_push($error_array, "<span style='color: darkred'>You're all set! Welcome into the tomb!</span><br>");
        //Czyszczenie zmiennych sesji
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";

    }


}

?>

<html>
<head>
    <title>   Witaj w krypcie!    </title>
</head>
<body>
    <form action="register.php" method="post">
        <input type="text" name="reg_fname" placeholder="First Name" value="<?php
        if(isset($_SESSION['reg_fname'])) {
            echo $_SESSION['reg_fname'];
        }
        ?>" required>
        <br>
        <?php if(in_array("Twoje imię musi zawierać się w przedziale 2 i 25 znaków.<br>", $error_array)) echo "Twoje imię musi zawierać się w przedziale 2 i 25 znaków.<br>"; ?>



        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php
        if(isset($_SESSION['reg_lname'])) {
            echo $_SESSION['reg_lname'];
        }
        ?>" required>
        <br>
        <?php if(in_array("Twoje nazwisko musi zawierać się w przedziale 2 i 25 znaków.<br>", $error_array)) echo "Twoje nazwisko musi zawierać się w przedziale 2 i 25 znaków.<br>"; ?>



        <input type="email" name="reg_email" placeholder="Email" value="<?php
        if(isset($_SESSION['reg_email'])) {
            echo $_SESSION['reg_email'];
        }
        ?>" required>
        <br>
        <?php if(in_array("Email już znajduje się w bazie<br>", $error_array)) echo "Email już znajduje się w bazie<br>";
        else if(in_array("błędny format emaila<br>", $error_array)) echo "błędny format emaila<br>";
        else if(in_array( "Podano różne emaile<br>", $error_array)) echo  "Podano różne emaile<br>"; ?>




        <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php
        if(isset($_SESSION['reg_email2'])) {
            echo $_SESSION['reg_email2'];
        }
        ?>" required>
        <br>
        <?php if(in_array("Email już znajduje się w bazie<br>", $error_array)) echo "Email już znajduje się w bazie<br>";
        else if(in_array("błędny format emaila<br>", $error_array)) echo "błędny format emaila<br>";
        else if(in_array( "Podano różne emaile<br>", $error_array)) echo  "Podano różne emaile<br>"; ?>


        <input type="password" name="reg_password" placeholder="Password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
        <br>
        <?php if(in_array("Wprowadzono różne hasła<br>", $error_array)) echo "Wprowadzono różne hasła<br>";
        else if(in_array("Hasło może zawierać jedynie międzynarodowe litery lub liczby<br>", $error_array)) echo "Hasło może zawierać jedynie międzynarodowe litery lub liczby<br>";
        else if(in_array( "Hasło musi mieć mniej niż 30 znaków<br>", $error_array)) echo  "Hasło musi mieć mniej niż 30 znaków<br>";
        else if(in_array( "Hasło musi mieć więcej niż 5 znaków<br>", $error_array)) echo  "Hasło musi mieć więcej niż 5 znaków<br>"; ?>


        <input type="submit" name="register_button" value="Register">

        <?php if(in_array("<span style='color: darkred'>You're all set! Welcome into the tomb!</span><br>", $error_array)) echo "<span style='color: darkred'>You're all set! Welcome into the tomb!</span><br>";
        ?>

    </form>
</body>
</html>
